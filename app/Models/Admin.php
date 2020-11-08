<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
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
}
