<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PatientPaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        // 1. Validate Incoming Request
        $validated = $request->validate([
            'nameOnCardFirst' => 'required|string',
            'nameOnCardLast' => 'required|string',
            'email' => 'required|email',
            'addressLine1' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipCode' => 'required|string',
            'country' => 'required|string',
            'paymentFor' => 'required|string',
            'amount' => 'required|numeric',
            'stripePaymentMethodId' => 'required|string',
            'signature' => 'required|string',
            'authorizeCharge' => 'required|string',
            'date' => 'required|string',
            'patientName' => 'nullable|string',
        ]);

        try {
            // 2. Process Stripe Payment
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // The Vue component calculates the total including the 4.24% processing fee.
            // Stripe expects the amount in the smallest currency unit (cents).
            $paymentIntent = PaymentIntent::create([
                'amount' => round($request->amount * 100),
                'currency' => 'aud', // Assuming AUD based on the ABN in the context
                'payment_method' => $request->stripePaymentMethodId,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);

            // 3. Process & Save Signature Image
            $signaturePath = null;
            if ($request->signature) {
                $imageParts = explode(';base64,', $request->signature);
                $imageTypeAux = explode('image/', $imageParts[0]);
                $imageType = $imageTypeAux[1] ?? 'png';
                $imageBase64 = base64_decode($imageParts[1]);
                $fileName = 'signatures/'.uniqid().'.'.$imageType;

                Storage::disk('public')->put($fileName, $imageBase64);
                $signaturePath = $fileName;
            }

            // 4. Save to Database mapping fields from the frontend
            $paymentRecord = PatientPayment::create([
                'patient_name' => $request->patientName,
                'name_on_card_first' => $request->nameOnCardFirst,
                'name_on_card_last' => $request->nameOnCardLast,
                'address_line_1' => $request->addressLine1,
                'address_line_2' => $request->addressLine2,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zipCode,
                'country' => $request->country,
                'email' => $request->email,
                'authorize_charge' => $request->authorizeCharge,
                'payment_for' => $request->paymentFor,
                'amount' => $request->amount,
                'stripe_payment_id' => $paymentIntent->id,
                'payment_status' => $paymentIntent->status === 'succeeded' ? 'Paid' : 'Failed',
                'date_submitted' => $request->date,
                'signature_path' => $signaturePath,
            ]);

            return response()->json([
                'message' => 'Payment processed successfully',
                'data' => $paymentRecord,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Payment processing failed',
                'error' => $e->getMessage(),
            ], 422);
        }
    }
}
