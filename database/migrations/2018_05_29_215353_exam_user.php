<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExamUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    //table will store list of users to open exams for them
    //when admin or doctor close the exam will remove this 
    //exam students list

    public function up()
    {
        Schema::create('exam_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('exam_id');
            
            $table->longText('answers')->nullable();
            $table->double('grade')->nullable();
            $table->timestamp('enrolled_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            
            $table->foreign('user_id')->references('id')
            ->on('users')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')
            ->on('exams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_user');
    }
}
