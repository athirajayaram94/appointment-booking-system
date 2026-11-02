<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppointmentSlot extends Model
{
    protected $fillable = [
        'doctor_name',
        'date',
        'start_time',
        'end_time',
        'capacity',
        'is_available',
    ];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];

    /**
     * Get all appointments associated with this slot.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'slot_id');
    }
}