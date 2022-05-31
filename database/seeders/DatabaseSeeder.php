<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();


        $this->call(UserTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(TutorsTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(MessageTableSeeder::class);
        $this->call(AppointmentsTableSeeder::class);






        }
}
