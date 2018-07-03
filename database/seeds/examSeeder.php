<?php

use Illuminate\Database\Seeder;
use App\exam;
use App\subject;
class examSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $is = subject::select('id')->where('subject_name' , '=', 'information system')->first();
        $it = subject::select('id')->where('subject_name' , '=', 'information technology')->first();

        $exam = new exam();
        $exam->exam_name = 'information system exam 1';
        $exam->desc = 'Management Information Systems: Solving Business Problems with Information Technology';
        $exam->grade = 50;
        $exam->subject_id = $is->id;
        $exam->open = "1";
        $exam->save();

        $exam = new exam();
        $exam->exam_name = 'information system exam 2';
        $exam->desc = 'Management Information Systems: Solving Business Problems with Information Technology';
        $exam->grade = 50;
        $exam->subject_id = $is->id;
        $exam->save();

        $exam = new exam();
        $exam->exam_name = 'information technology exam 1';
        $exam->desc = 'Management Information Systems: Solving Business Problems with Information Technology';
        $exam->grade = 50;
        $exam->subject_id = $it->id;
        $exam->open = "1";
        $exam->save();

        $exam = new exam();
        $exam->exam_name = 'information technology exam 2';
        $exam->desc = 'Management Information Systems: Solving Business Problems with Information Technology';
        $exam->grade = 50;
        $exam->subject_id = $it->id;
        $exam->save();

    }
}
