<?php

namespace App\Traits;
trait Responses

{
    public function success($data, $message, $code)
    {
        return response()
            ->json([
                'data' => $data,
                'message' => $message,
                'status' => $code,
            ]);
    }

    public function failure($error, $code)
    {
        return response()
            ->json([
                'error' => $error,
                'status' => $code
            ]);
    }
}
