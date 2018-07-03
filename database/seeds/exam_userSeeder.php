<?php

use Illuminate\Database\Seeder;
use App\User;
use App\exam;
class exam_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::select('id')->where('username' , '=', 'student')->first();

        $exam = exam::select('id')->where('exam_name' , '=', 'information system exam 1')->first();
        $user->exams()->attach($exam->id);

        $exam = exam::select('id')->where('exam_name' , '=', 'information technology exam 1')->first();
        $user->exams()->attach($exam->id);


    }
}
