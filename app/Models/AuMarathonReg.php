<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
class AuMarathonReg extends Authenticatable{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'au_marathon_reg';
	protected $fillable = ['name','email','mobile_no','dob','gender','t_shirt_size','t_status','created_at','updated_at'];
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  /**
	 * A profile belongs to a user
	 *
	 * @return mixed
	 */
}
