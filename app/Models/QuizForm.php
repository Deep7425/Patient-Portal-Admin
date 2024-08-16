<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
class QuizForm extends Authenticatable {
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'quiz_forms';
 	protected $fillable = ['org_id','name','gender','mobile','age','meta_data','institute_id','class','subject','status'];
    public $timestamps = true;


    public function SessionAssesment(){


        return $this->hasone('App\Models\SessionAssesment', 'quiz_id');



    }


}
