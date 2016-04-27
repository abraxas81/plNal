<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Support\Facades\Hash;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
	use EntrustUserTrait ;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Operateri';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
	
	public function setPasswordAttribute($value) {
		$this->attributes['password'] = Hash::make($value);
	}

	public function klijenti()
	{
		return $this->belongsToMany('App\Klijent', 'OperateriKlijenti', 'OperateriId', 'KlijentiId');
	}
	public function roles()
	{
		return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
	}

	public function parametri(){
		return $this->hasMany('App\Parametar','OperaterId','id');
	}

	public function posts()
	{
		return $this->hasMany('App\Post');
	}

}