<?php

namespace App\Models;

class ApiResponse
{


    public static function success($data, $message = ''): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
        ]);
    }

    public static function error($message, $statusCode, $data = ""): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }

}
