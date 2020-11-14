<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\JsonResponse;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use JsonResponse;

    public function __construct(Admin $adminTable)
    {
        $this->adminTable = $adminTable;
    }

    public function createToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        $admin = $this->adminTable->findOrFail($request->id);

        $token = $admin->createToken('AdminToken')->accessToken;

        return $this->responseWithCondition($token, 'Successfully generated token', 'Failed to generate token');
    }
}
