<?php

namespace App\Helpers;

class ApiResponse
{

    static function response($code = 200, $message = null, $data = null)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
