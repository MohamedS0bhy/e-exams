<?php

use Illuminate\Database\Seeder;
use App\User;
class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'student';
        $user->password = bcrypt('st');
        $user->email = 'st@mail.com';
        $user->phone_number = rand(1000000000000,9999999999999);
        $user->date_of_birth = date('Y-m-d', strtotime(rand(1900 , 2010) . '/' . rand(1,12) . '/' . rand(1,30)));
        $user->role = '0';
        $user->save();

        $user = new User();
        $user->username = 'doctor';
        $user->password = bcrypt('dc');
        $user->email = 'dc@mail.com';
        $user->phone_number = rand(1000000000000,9999999999999);
        $user->date_of_birth = date('Y-m-d', strtotime(rand(1900 , 2010) . '/' . rand(1,12) . '/' . rand(1,30)));
        $user->role = '1';
        $user->save();

        $user = new User();
        $user->username = 'admin';
        $user->password = bcrypt('ad');
        $user->email = 'ad@mail.com';
        $user->phone_number = rand(1000000000000,9999999999999);
        $user->date_of_birth = date('Y-m-d', strtotime(rand(1900 , 2010) . '/' . rand(1,12) . '/' . rand(1,30)));
        $user->role = '10';
        $user->save();


    }
}
