<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;


class Admin extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasApiTokens;

    protected $fillable = [
        'id','name', 'password', 'email', 'is_active', 'reset_token', 'reset_token_expire'
    ];

    protected $hidden = [
        'password'
    ];
    public function store(Array $arr){
        return $this->firstOrCreate($arr);
    }

    public function patch($id, Array $arr){
        return $this->where('id', $id)
                    ->update($arr);
    }

    public function remove($id){
        return $this->destroy($id);
    }

    public function findBy($key, $value){
        return $this->where($key, $value)->first();
    }
}
