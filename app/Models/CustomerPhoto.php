<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CustomerPhoto extends Model
{
    protected $guarded = []; // Or explicitly add the columns to $fillable

    protected $appends = [
        'frontal_url',
        'smile_url',
        'side_url',
        'teeth_front_url',
        'teeth_right_url',
        'teeth_left_url',
        'teeth_upper_url',
        'teeth_lower_url',
        'xray_1_url',
        'xray_2_url',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Accessor for frontal photo URL
    public function getFrontalUrlAttribute(): ?string
    {
        return $this->frontal ? Storage::disk('public')->url($this->frontal) : null;
    }

    // Accessor for smile photo URL
    public function getSmileUrlAttribute(): ?string
    {
        return $this->smile ? Storage::disk('public')->url($this->smile) : null;
    }

    // Accessor for side photo URL
    public function getSideUrlAttribute(): ?string
    {
        return $this->side ? Storage::disk('public')->url($this->side) : null;
    }
    // Accessor for Teeth front photo URL
    public function getTeethFrontUrlAttribute(): ?string
    {
        return $this->teeth_front ? Storage::disk('public')->url($this->teeth_front) : null;
    }

    public function getTeethRightUrlAttribute(): ?string
    {
        return $this->teeth_right ? Storage::disk('public')->url($this->teeth_right) : null;
    }
    public function getTeethLeftUrlAttribute(): ?string
    {
        return $this->teeth_left ? Storage::disk('public')->url($this->teeth_left) : null;
    }
    public function getTeethUpperUrlAttribute(): ?string
    {
        return $this->teeth_upper ? Storage::disk('public')->url($this->teeth_upper) : null;
    }
    public function getTeethLowerUrlAttribute(): ?string
    {
        return $this->teeth_lower ? Storage::disk('public')->url($this->teeth_lower) : null;
    }
    public function getXray1UrlAttribute(): ?string
    {
        return $this->teeth_xray_1 ? Storage::disk('public')->url($this->teeth_xray_1) : null;
    }
    public function getXray2UrlAttribute(): ?string
    {
        return $this->teeth_xray_2 ? Storage::disk('public')->url($this->teeth_xray_2) : null;
    }
}
