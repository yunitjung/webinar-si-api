<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Traits\JsonResponse;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    use JsonResponse;

    public function __construct(Category $table)
    {
        $this->table = $table;
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories'
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        $store = $this->table->store($request->all());

        return $this->responseWithCondition(new CategoryResource($store), 'Successfully storing category', 'Failed to store category');
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id'   => 'required',
            'name' => 'required|unique:categories,name,'.$request->id.',id'
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        $store = $this->table->patch($request->id, $request->except('id'));

        return $this->responseWithCondition($store, 'Successfully updating category', 'Failed to update category');
    }

    public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        $store = $this->table->remove($request->id);

        return $this->responseWithCondition($store, 'Successfully removing category', 'Failed to remove category');
    }

    public function list(){
        $data = $this->table->all();

        return $this->responseWithCondition($data, 'Successfully retrieve category list', 'Failed to retrieve category list');
    }

    public function find(Request $request){
        $validator = Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        $data = $this->table->findOrFail($request->id);

        return $this->responseWithCondition($data, 'Successfully retrieve category', 'Failed to retrieve category');

    }
}
