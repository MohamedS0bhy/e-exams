<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call(userSeeder::class);
	    $this->call(subjectSeeder::class);
        $this->call(subject_userSeeder::class);
        $this->call(examSeeder::class);
        $this->call(questionSeeder::class);
        $this->call(question_userSeeder::class);
        $this->call(exam_userSeeder::class);
    }
}
