<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {

        $data =  [
                    'id'                    => $this->id,
                    'name'                  => $this->name,
                ];

        if($this->category)
            $data['category'] = new CategoryResource($this->category);

        return $data;

    }
}