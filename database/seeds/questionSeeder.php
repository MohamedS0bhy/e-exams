<?php

use Illuminate\Database\Seeder;
use App\question;
use App\exam;

class questionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $is = exam::select('id')->where('exam_name' , '=', 'information system exam 1')->first();
        
        $question = new question();
        $question->question = 'It is impossible to deal with the vast amount of data created daily without:';
        $question->choices = '[{"content" : "A)	Highly-trained personnel.","correct" : "0"},
        {"content" : "B)	Knowledgeable management.","correct" : "0"},
        {"content" : "C)	Information technology.","correct" : "1"},
        {"content" : "D)	Pentium-level chips.","correct" : "0"}]';
        $question->grade = 10;
        $question->exam_id =$is->id;
        $question->save();

        $question = new question();
        $question->question = 'A major trend facing industrialized nations is:';
        $question->choices = '[{"content" : "A)	The fall of labor unions.","correct" : "0"},
        {"content" : "B)	The movement of workers from one area of the world to another.","correct" : "0"},
        {"content" : "C)	The move toward a service-oriented economy.","correct" : "1"},
        {"content" : "D)	Downward-spiraling educational standards.","correct" : "0"}]';
        $question->grade = 10;
        $question->exam_id =$is->id;
        $question->save();

        $question = new question();
        $question->question = 'In today\'s business environment, it is becoming most difficult to find a managerial job that is/has:';
        $question->choices = '[{"content" : "A)	Good benefits.","correct" : "0"},
        {"content" : "B)	Available to persons without a doctoral degree.","correct" : "1"},
        {"content" : "C)	Permanent.","correct" : "0"},
        {"content" : "D)	A high salary.","correct" : "0"}]';
        $question->grade = 10;
        $question->exam_id =$is->id;
        $question->save();

        $question = new question();
        $question->question = 'GATT stands for:';
        $question->choices = '[{"content" : "A)	Global Awareness of Treaties and Tariffs.","correct" : "1"},
        {"content" : "B)	General Agreement on Tariffs and Trade.","correct" : "0"},
        {"content" : "C)	General Agreement on Trade and Treaties.","correct" : "0"},
        {"content" : "D)	Gilverhanson\'s Assessments of Teaching and Tutorials.","correct" : "0"}]';
        $question->grade = 10;
        $question->exam_id =$is->id;
        $question->save();

        $question = new question();
        $question->question = 'Mintzberg\'s three categories of managerial tasks are:';
        $question->choices = '[{"content" : "A)	Managerial, span of responsibility, financial planning.","correct" : "0"},
        {"content" : "B)	Human resource planning, financial planning, resource planning.","correct" : "0"},
        {"content" : "C)	Decisional, interpersonal, and informational.","correct" : "1"},
        {"content" : "D)	Developmental, resource identification, and interpersonal.","correct" : "0"}]';
        $question->grade = 10;
        $question->exam_id =$is->id;
        $question->save();
        
        $it = exam::select('id')->where('exam_name' , '=', 'information technology exam 1')->first();

        $question = new question();
        $question->question = 'It is impossible to deal with the vast amount of data created daily without:';
        $question->choices = '[{"content" : "A)	Highly-trained personnel.","correct" : "0"},
        {"content" : "B)	Knowledgeable management.","correct" : "0"},
        {"content" : "C)	Information technology.","correct" : "1"},
        {"content" : "D)	Pentium-level chips.","correct" : "0"}]';
        $question->grade = 10;
        $question->exam_id =$it->id;
        $question->save();

        $question = new question();
        $question->question = 'A major trend facing industrialized nations is:';
        $question->choices = '[{"content" : "A)	The fall of labor unions.","correct" : "0"},
        {"content" : "B)	The movement of workers from one area of the world to another.","correct" : "0"},
        {"content" : "C)	The move toward a service-oriented economy.","correct" : "1"},
        {"content" : "D)	Downward-spiraling educational standards.","correct" : "0"}]';
        $question->grade = 10;
        $question->exam_id =$it->id;
        $question->save();

        $question = new question();
        $question->question = 'In today\'s business environment, it is becoming most difficult to find a managerial job that is/has:';
        $question->choices = '[{"content" : "A)	Good benefits.","correct" : "0"},
        {"content" : "B)	Available to persons without a doctoral degree.","correct" : "1"},
        {"content" : "C)	Permanent.","correct" : "0"},
        {"content" : "D)	A high salary.","correct" : "0"}]';
        $question->grade = 10;
        $question->exam_id =$it->id;
        $question->save();

        $question = new question();
        $question->question = 'GATT stands for:';
        $question->choices = '[{"content" : "A)	Global Awareness of Treaties and Tariffs.","correct" : "0"},
        {"content" : "B)	General Agreement on Tariffs and Trade.","correct" : "0"},
        {"content" : "C)	General Agreement on Trade and Treaties.","correct" : "1"},
        {"content" : "D)	Gilverhanson\'s Assessments of Teaching and Tutorials.","correct" : "0"}]';
        $question->grade = 10;
        $question->exam_id =$it->id;
        $question->save();

        $question = new question();
        $question->question = 'Mintzberg\'s three categories of managerial tasks are:';
        $question->choices = '[{"content" : "A)	Managerial, span of responsibility, financial planning.","correct" : "0"},
        {"content" : "B)	Human resource planning, financial planning, resource planning.","correct" : "0"},
        {"content" : "C)	Decisional, interpersonal, and informational.","correct" : "1"},
        {"content" : "D)	Developmental, resource identification, and interpersonal.","correct" : "0"}]';
        $question->grade = 10;
        $question->exam_id =$it->id;
        $question->save();
    }
}
