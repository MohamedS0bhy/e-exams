<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'questions';
    public $timestamps = false;
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['examquestionss'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'choices',
        'exam_id',
        'grade'
      ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


}
