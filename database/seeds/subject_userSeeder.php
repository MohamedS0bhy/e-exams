<?php

use Illuminate\Database\Seeder;
use App\User;
use App\subject;
class subject_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::select('id')->where('username' , '=', 'student')->first();
       
        $subject = subject::select('id')->where('subject_name' , '=', 'information system')->first();
        $user->subjects()->attach($subject->id);

        $subject = subject::select('id')->where('subject_name' , '=', 'information technology')->first();
        $user->subjects()->attach($subject->id);
    }
}
