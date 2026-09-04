<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Stripe\Exception\CardException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PatientPaymentController extends Controller
{
    /**
     * Map of valid payment options and their fixed prices (in AUD cents).
     */
    private const PAYMENT_ITEMS = [
        'deposit' => [
            'label' => 'Appointment Deposit (non-refundable)',
            'amount_cents' => 5000, // $50.00
        ],
        'retainers_both' => [
            'label' => 'Upper & Lower retainers - Pick up from clinic',
            'amount_cents' => 54000, // $540.00
        ],
        'retainer_upper' => [
            'label' => 'Upper retainer only - Pick up from clinic',
            'amount_cents' => 27000, // $270.00
        ],
        'retainer_lower' => [
            'label' => 'Lower retainer only - Pick up from clinic',
            'amount_cents' => 27000, // $270.00
        ],
    ];

    public function index()
    {
        $payments = PatientPayment::orderBy('created_at', 'desc')->get()->map(function ($payment) {
            return [
                'id' => $payment->id,
                'patient_name' => $payment->patient_name,
                // Concatenate first and last name for the frontend
                'name_on_card' => trim($payment->name_on_card_first . ' ' . $payment->name_on_card_last),
                // Build a single billing address string
                'billing_address' => implode(', ', array_filter([
                    $payment->address_line_1,
                    $payment->address_line_2,
                    $payment->city,
                    $payment->state,
                    $payment->zip_code,
                    $payment->country
                ])),
                'email' => $payment->email,
                'authorization' => $payment->authorize_charge,
                'payment_for' => $payment->payment_for,
                'order_summary' => '$' . number_format($payment->amount, 2),
                'status' => $payment->payment_status,
                'date_added' => $payment->created_at->format('Y-m-d H:i'),
                'submitted' => $payment->date_submitted,
                'signature' => $payment->signature_path,
            ];
        });

        return response()->json($payments);
    }

    public function processPayment(Request $request)
    {
        // 1. Validate Input Data
        $validated = $request->validate([
            'nameOnCardFirst' => 'required|string|max:100',
            'nameOnCardLast' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'addressLine1' => 'required|string|max:255',
            'addressLine2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zipCode' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'paymentItemKey' => 'required|string|in:'.implode(',', array_keys(self::PAYMENT_ITEMS)),
            'stripePaymentMethodId' => 'required|string',
            'signature' => 'required|string',
            'authorizeCharge' => 'required|string|in:Yes',
            'patientName' => 'nullable|string|max:255',
        ]);

        try {
            // 2. Server-side Price Calculation (Prevents Price Tampering)
            $selectedItem = self::PAYMENT_ITEMS[$validated['paymentItemKey']];
            $baseAmountCents = $selectedItem['amount_cents'];

            // Calculate 4.24% Stripe processing fee server-side
            $processingFeeCents = (int) round($baseAmountCents * 0.0424);
            $totalAmountCents = $baseAmountCents + $processingFeeCents;

            // 3. Process Stripe Payment
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmountCents,
                'currency' => 'aud',
                'payment_method' => $validated['stripePaymentMethodId'],
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
                'description' => $selectedItem['label'],
                'receipt_email' => $validated['email'],
                'metadata' => [
                    'patient_name' => $validated['patientName'] ?? 'N/A',
                    'cardholder_name' => $validated['nameOnCardFirst'].' '.$validated['nameOnCardLast'],
                ],
            ]);

            // 4. Secure Signature Storage (Private Disk)
            $signaturePath = null;
            if (! empty($validated['signature']) && str_contains($validated['signature'], ';base64,')) {
                $imageParts = explode(';base64,', $validated['signature']);
                $imageBase64 = base64_decode($imageParts[1]);

                // Store on non-public disk
                $fileName = 'signatures/'.date('Y/m/').uniqid('sig_', true).'.png';
                Storage::disk('local')->put($fileName, $imageBase64);
                $signaturePath = $fileName;
            }

            // 5. Store Payment Record
            $paymentRecord = PatientPayment::create([
                'patient_name' => $validated['patientName'] ?? null,
                'name_on_card_first' => $validated['nameOnCardFirst'],
                'name_on_card_last' => $validated['nameOnCardLast'],
                'address_line_1' => $validated['addressLine1'],
                'address_line_2' => $validated['addressLine2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zipCode'],
                'country' => $validated['country'],
                'email' => $validated['email'],
                'authorize_charge' => $validated['authorizeCharge'],
                'payment_for' => $selectedItem['label'],
                'amount' => $totalAmountCents / 100, // Store standard unit in DB ($)
                'stripe_payment_id' => $paymentIntent->id,
                'payment_status' => $paymentIntent->status === 'succeeded' ? 'Paid' : 'Pending',
                'date_submitted' => now()->toDateString(),
                'signature_path' => $signaturePath,
            ]);

            return response()->json([
                'message' => 'Payment processed successfully.',
                'transaction_id' => $paymentIntent->id,
            ], 200);

        } catch (CardException $e) {
            // Card declined or invalid card details
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);

        } catch (\Exception $e) {
            // Log full exception details internally
            Log::error('Payment processing failure: '.$e->getMessage(), [
                'exception' => $e,
                'request' => $request->except(['stripePaymentMethodId', 'signature']),
            ]);

            return response()->json([
                'message' => 'An error occurred while processing your payment. Please try again.',
            ], 500);
        }
    }
}
