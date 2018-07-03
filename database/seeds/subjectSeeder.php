<?php

use Illuminate\Database\Seeder;
use App\User;
use App\subject;
class subjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::select('id')->where('username' , '=', 'doctor')->first();

        $subject = new subject();
        $subject->subject_name = "information system";
        $subject->desc = "information system subject";
        $subject->user_id = $user->id;
        $subject->save();

        $subject = new subject();
        $subject->subject_name = "information technology";
        $subject->desc = "information technology subject";
        $subject->user_id = $user->id;
        $subject->save();

    }
}
