<?php

namespace App\Traits;

trait ResponseTrait
{
    public function successResponse($msg, $data, $statusCode)
    {
        return response([
            "status" => true,
            "msg" => $msg,
            "data" => $data,
        ],$statusCode);
    }

    public function errorResponse($msg, $data, $statusCode)
    {
        return response([
            "status" => true,
            "msg" => $msg,
            "data" => $data,
        ],$statusCode);
    }
}