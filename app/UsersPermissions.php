<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersPermissions extends Model {

  protected $table = 'users_permissions';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['permission_id', 'user_id'];

  public function permissions() {

    return $this->belongsToMany('App\Permissions', 'users_permissions', 'user_id', 'permission_id');

  }

}
