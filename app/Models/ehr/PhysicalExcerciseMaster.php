<?php
namespace App\Models\ehr;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
class PhysicalExcerciseMaster extends Authenticatable
{
    use Notifiable;

    /**
     * The database table used by the model.
     * @var string
     */
     protected $connection = 'mysql_ehr';
    protected $table = 'physical_excercise_master';
    //public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','file','added_by','status','delete_status'];

    /**
	 * A profile belongs to a user
	 *
	 * @return mixed
	 */
}
?>
