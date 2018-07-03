<?php

use Illuminate\Database\Seeder;
use App\User;
use App\question;
class question_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = User::select('id')->where('username' , '=', 'student')->first();

        // $question = question::select('id')->where('question' , 'like ', 'It is impossible to deal with the vast amount of data created daily without%')->first();
        // $user->questions()->attach($question->id , ['answer' => 'A)	Highly-trained personnel.', 'grade' => 0]);
        
        // $question = question::select('id')->where('question' , 'like ', 'A major trend facing industrialized nations is%')->first();
        // $user->questions()->attach($question->id , ['answer' => 'B)	The movement of workers from one area of the world to another.', 'grade' => 0]);
        
        // $question = question::select('id')->where('question' , 'like ', 'In today\'s business environment, it is becoming most difficult to find a managerial job that is/has%')->first();
        // $user->questions()->attach($question->id , ['answer' => 'B)	Available to persons without a doctoral degree.', 'grade' => 10]);
        
        // $question = question::select('id')->where('question' , 'like ', 'GATT stands for%')->first();
        // $user->questions()->attach($question->id , ['answer' => 'A)	Global Awareness of Treaties and Tariffs.', 'grade' => 10]);
        
        // $question = question::select('id')->where('question' , 'like ', 'Mintzberg\'s three categories of managerial tasks are%')->first();
        // $user->questions()->attach($question->id , ['answer' => 'C)	Decisional, interpersonal, and informational.', 'grade' => 10]);
        

        // $question = question::select('id')->where('question' , 'like ', 'It is impossible to deal with the vast amount of data created daily without%')->skip(1)->first();
        // $user->questions()->attach($question->id , ['answer' => 'C)	Information technology.', 'grade' => 10]);
        
        // $question = question::select('id')->where('question' , 'like ', 'A major trend facing industrialized nations is%')->skip(1)->first();
        // $user->questions()->attach($question->id , ['answer' => 'C)	The move toward a service-oriented economy.', 'grade' => 10]);
        
        // $question = question::select('id')->where('question' , 'like ', 'In today\'s business environment, it is becoming most difficult to find a managerial job that is/has%')->skip(1)->first();
        // $user->questions()->attach($question->id , ['answer' => 'C)	Permanent.', 'grade' => 0]);
        
        // $question = question::select('id')->where('question' , 'like ', 'GATT stands for%')->skip(1)->first();
        // $user->questions()->attach($question->id , ['answer' => 'B)	General Agreement on Tariffs and Trade.', 'grade' => 0]);
        
        // $question = question::select('id')->where('question' , 'like ', 'Mintzberg\'s three categories of managerial tasks are%')->skip(1)->first();
        // $user->questions()->attach($question->id , ['answer' => 'C)	Decisional, interpersonal, and informational.', 'grade' => 10]);
        
    }
}
