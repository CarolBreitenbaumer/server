<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $user1 = new User();
        $user1->name ="admin";
        $user1->email ="admin@gmail.com";
        $user1->password = bcrypt('admin');
        $user1->isAdmin = true;
        $user1->save();

        $user2 = new User();
        $user2->name ="student";
        $user2->email ="student@gmail.com";
        $user2->password = bcrypt('student');
        $user2->isAdmin = false;
        $user2->save();

        $user3 = new User();
        $user3->name ="student2";
        $user3->email ="student2@gmail.com";
        $user3->password = bcrypt('student2');
        $user3->isAdmin = false;
        $user3->save();


    }
}
