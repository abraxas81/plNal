<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $fillable = ['name','display_name','description'];

    public function operateri()
    {
        return $this->belongsToMany('App\Users', 'role_user', 'role_id', 'user_id');
    }

    public function dozvole()
    {
        return $this->belongsToMany('App\Permission', 'permission_role', 'role_id', 'permission_id');
    }

}

