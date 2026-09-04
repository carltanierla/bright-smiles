<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name', 'name_on_card_first', 'name_on_card_last',
        'address_line_1', 'address_line_2', 'city', 'state', 'zip_code',
        'country', 'email', 'authorize_charge', 'payment_for', 'amount',
        'stripe_payment_id', 'payment_status', 'date_submitted', 'signature_path',
    ];
}
