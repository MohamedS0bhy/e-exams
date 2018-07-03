<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subjects';
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject_name',
        'desc',
        'user_id'
      ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

     public function exams(){
       return $this->hasMany('App\exam');
     }
}
