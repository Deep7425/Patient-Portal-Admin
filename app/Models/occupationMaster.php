<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
class occupationMaster extends Authenticatable{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'occupation_master';
    public $timestamps = false;
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
