<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'name', 'tutor_id'];

    /**
     * subject has one tutor
     */

    public function tutor(): BelongsTo{
        return $this->belongsTo(Tutor::class);
    }


    /**
     * subject has many appointments
     */

    public function appointments() : HasMany {
        return $this->hasMany(Appointment::class);
    }



}
