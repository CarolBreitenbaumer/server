<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'time', 'duration', 'place', 'attend', 'subject_id', 'student_id'];

    /**
     * appointment has one subject
     */
    public function subject(): BelongsTo{
        return $this->belongsTo(Subject::class);
    }

    /**
     * appointment has one student
     */
    public function student(): BelongsTo{
        return $this->belongsTo(Student::class);
    }

}
