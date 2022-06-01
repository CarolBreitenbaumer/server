<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Author;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Faker\Provider\DateTime;
use Illuminate\Database\Seeder;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appointment1 = new Appointment();
        $appointment1->date = date("2022-01-07");
        $appointment1->time = '15:00';
        $appointment1->duration = '1:00:00';
        $appointment1->attend = true;
        $appointment1->place = 'online, Zoom';
        //get the first student
        $student = Student::all()->first();
        $appointment1->student()->associate($student);
        $subject = Subject::all()->first();
        $appointment1->subject()->associate($subject);
        $appointment1->save();


        $appointment2 = new Appointment();
        $appointment2->date = date("2022-05-30");
        $appointment2->time = '16:00';
        $appointment2->duration = '1:00:00';
        $appointment2->attend = true;
        $appointment2->place = 'online, MS Teams';
        $student = Student::all()->first();
        $appointment2->student()->associate($student);
        $subject = Subject::all()->first();
        $appointment2->subject()->associate($subject);
        $appointment2->save();

        $appointment3 = new Appointment();
        $appointment3->date = date("2022-06-12");
        $appointment3->time = '13:00';
        $appointment3->duration = '1:00:00';
        $appointment3->attend = false;
        $appointment3->place = 'online, Zoom';
        $subject = Subject::all()->first();
        $appointment3->subject()->associate($subject);
        $appointment3->save();

        $appointment4 = new Appointment();
        $appointment4->date = date("2022-08-01");
        $appointment4->time = '17:00';
        $appointment4->duration = '1:00:00';
        $appointment4->attend = false;
        $appointment4->place = 'online, Zoom';
        $student = Student::all()->first();
        $appointment4->student()->associate($student);
        $appointment4->subject()->associate($subject);
        $appointment4->save();

        $appointment5 = new Appointment();
        $appointment5->date = date("2022-07-30");
        $appointment5->time = '20:00';
        $appointment5->duration = '1:00:00';
        $appointment5->attend = false;
        $appointment5->place = 'online, Zoom';
        $subject = Subject::all()->first();
        $appointment5->subject()->associate($subject);
        $appointment5->save();

        $appointment6 = new Appointment();
        $appointment6->date = date("2022-06-02");
        $appointment6->time = '18:00';
        $appointment6->duration = '1:00:00';
        $appointment6->attend = false;
        $appointment6->place = 'online, Zoom';
        $subject = Subject::all()->first();
        $appointment6->subject()->associate($subject);
        $appointment6->save();

        $appointment4 = new Appointment();
        $appointment4->date = date("2022-12-22");
        $appointment4->time = '17:00';
        $appointment4->duration = '1:00:00';
        $appointment4->attend = false;
        $appointment4->place = 'online, Zoom';
        $subject = Subject::all()->first();
        $appointment4->subject()->associate($subject);
        $appointment4->save();
    }
}
