<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'student_id', 'readed', 'subject_id'];

    /*
    * message belongs to one subject
    */
    public function subject() : belongsTo {
        return $this->belongsTo(Subject::class);
    }

    /*
    * message belongs to one student
    */
    public function student() : belongsTo {
        return $this->belongsTo(Student::class);
    }
}
