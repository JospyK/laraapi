<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function handleResponse($result, $msg)
    {
        // format response
        $response = [
            "success" => true,
            "data"    => $result,
            "message" => $msg
        ];
        // return response
        return response()->json($response, 200);
    }

    public function handleError($error, $errorMessages = [], $code = 404)
    {
        // format error
        $response = [
            "success" => false,
            "message" => $error
        ];

        // check if there is error messages
        if (!empty($errorMessages)) {
            $response["data"] = $errorMessages;
        }

        // return response
        return response()->json($response, $code);
    }
}
