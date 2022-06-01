<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tutor extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'firstname,', 'lastname', 'description', 'education', 'tnumber', 'pricePerHour', 'priceForTenHours', 'comment', 'users_id'];

    /**
     * tutor has many subjects
     */

    public function subjects() : HasMany {
        return $this->hasMany(Subject::class);
    }

    /*
     * tutor belongs to one user
     */
    public function users() : belongsTo {
        return $this->belongsTo(User::class);
    }


}
