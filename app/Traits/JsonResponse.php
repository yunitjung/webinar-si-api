<?php

namespace App\Traits;

trait JsonResponse {

    public function responseWithCondition($data, $successMsg, $failMsg)
    {
        return $data ? $this->success($successMsg, $data)
            : $this->fail($failMsg);
    }

    public function success($msg, $data = null, $code = 200, $version = '1.0')
    {
        return response()->json([
            'success' => true,
            'message' => $msg,
            'data' => $data,
            'code' => $code,
            'version' => $version
        ], $code)->header('Content-Type', 'application/json');
    }

    public function fail($msg, $code = 400, $version = '1.0')
    {
        return response()->json([
            'success' => false,
            'message' => $msg,
            'data' => null,
            'code' => $code,
            'version' => $version
        ], $code)->header('Content-Type', 'application/json');
    }
}
