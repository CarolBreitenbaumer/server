<?php

namespace Database\Seeders;


use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Seeder;

class TutorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tutor = new Tutor();
        $tutor->image = 'https://engineering.unl.edu/images/staff/Kayla-Person.jpg';
        $tutor->firstname = 'Claudia';
        $tutor->lastname = 'Huber';
        $tutor->description = 'Ich bin Claudia und habe in Traun die HAK abgeschlossen.
                            Derzeit studiere ich KWM in Hagenberg.
                            Ich gebe gerne nachhilfe in den Fächern Informatik, Word, Powerpoint und Excel.';
        $tutor->education = 'FH Hagenberg BA, KWM';
        $tutor->tnumber = '0699/18283718';
        $tutor->pricePerHour = 15;
        $tutor->priceForTenHours = 120;
        $user = User::all()->first();
        //wegen Belongs To Beziehung
        //speichern User zum Tutor
        $tutor->users()->associate($user);
        //in DB speichern
        $tutor->save();


    }
}
