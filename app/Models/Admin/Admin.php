<?php
namespace App\Models\Admin;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable {

	use Notifiable;

    protected $fillable = ['name','email','mobile_no','password','module_permissions','remember_token','status','delete_status'];

    protected $table = 'admins';
    public $timestamps = true;
}
