<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $message1 = new Message();
        $message1->message = "Ich möchte einen Termin für PHP am 26. 5. 22 um 18:00 buchen.";
        $message1->readed = false;
        $student = Student::all()->first();
        $message1->student()->associate($student);
        $subject = Subject::all()->first();
        $message1->subject()->associate($subject);
        $message1->save();
    }
}
