<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['firstname', 'lastname', 'users_id'];

    /**
     * student has many appointments
     */

    public function appointments() : HasMany {
        return $this->hasMany(Appointment::class);
    }

    /*
     * student belongs to one user
     */
    public function users() : belongsTo {
        return $this->belongsTo(User::class);
    }

    /*
     * student has Many messages
     */
    public function message() : hasMany {
        return $this->hasMany(Message::class);
    }
}
