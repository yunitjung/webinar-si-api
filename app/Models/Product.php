<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id','name', 'category_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
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
