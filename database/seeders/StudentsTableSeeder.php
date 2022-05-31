<?php

namespace Database\Seeders;

use App\Models\Benutzer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $student1 = new Student();
        $user = User::all()->first();
        //wegen Belongs To Beziehung
        //speichern User zum Tutor
        $student1->users()->associate(User::all()->skip(1)->first());
        $student1 ->firstname="Stefan";
        $student1 ->lastname="Breitenbaumer";



        /*
        $user = User::all()->first()->id;
        $student1 -> user_id = $student1->users()->associate($user);
        */
        $student1 ->save();

        $student2 = new Student();
        $student2 ->firstname="Karl";
        $student2 ->lastname="Boborgmann";
        //wegen Belongs To Beziehung
        //speichern User zum Tutor
        $student2->users()->associate(User::all()->skip(2)->first());
        /*$user = User::all()->first()->id;
        $student2 -> user_id = $student2->users()->associate($user);
        */
        $student2 ->save();
    }
}
