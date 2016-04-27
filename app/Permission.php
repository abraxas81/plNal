<?php namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $fillable = ['name','display_name','description'];

    public function uloge()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'permission_id', 'role_id');
    }
}
