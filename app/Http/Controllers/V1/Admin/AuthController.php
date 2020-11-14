<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\JsonResponse;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use JsonResponse;

    public function __construct(Admin $adminTable)
    {
        $this->adminTable = $adminTable;
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|min:2|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $checkAdmin = $this->adminTable->findBy('email', $request->email);
            if(!$checkAdmin) {
                return $this->fail('Your account does not exists in our system', 404);
            }

            if(Hash::check($request->password, $checkAdmin->password)){

                $sessionAdmin = new \StdClass;
                $sessionAdmin->name = $checkAdmin->name;
                $sessionAdmin->email = $checkAdmin->email;
                $sessionAdmin->is_active = $checkAdmin->is_active;

                return $this->success('Admin credential match', $sessionAdmin);

            } else {

                return $this->fail('Wrong password', 409);
            }
        } catch (\Throwable $e) {
            \Log::critical($e);
            throw $e;
        }
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
