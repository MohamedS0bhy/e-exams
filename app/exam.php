<?php

namespace App;
use App\question;

use Illuminate\Database\Eloquent\Model;

class exam extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'exams';
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['exams'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exam_name',
        'desc',
        'grade',
        'open',
        'subject_id',
        'duration',
        
      ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function questions(){
      return $this->hasMany('App\question');
    }
}
