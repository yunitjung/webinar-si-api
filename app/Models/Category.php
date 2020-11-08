<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'id','name',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

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
