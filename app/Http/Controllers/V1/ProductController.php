<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Traits\JsonResponse;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    use JsonResponse;

    public function __construct(Product $table)
    {
        $this->table = $table;
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products',
            'category_id' => 'required'
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        $store = $this->table->store($request->all());

        return $this->responseWithCondition(new ProductResource($store), 'Successfully storing product', 'Failed to store product');
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id'   => 'required',
            'name' => 'required|unique:products,name,'.$request->id.',id'
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        $store = $this->table->patch($request->id, $request->except('id'));

        return $this->responseWithCondition($store, 'Successfully updating product', 'Failed to update product');
    }

    public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        $store = $this->table->remove($request->id);

        return $this->responseWithCondition($store, 'Successfully removing product', 'Failed to remove product');
    }

    public function list(){
        $data = ProductResource::collection($this->table->all());

        return $this->responseWithCondition($data, 'Successfully retrieve product list', 'Failed to retrieve product list');
    }

    public function find(Request $request){
        $validator = Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        $data = $this->table->findOrFail($request->id);

        return $this->responseWithCondition(new ProductResource($data), 'Successfully retrieve product', 'Failed to retrieve product');

    }
}
