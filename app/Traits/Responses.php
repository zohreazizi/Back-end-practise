<?php

namespace App\Traits;
trait Responses
{
    public function getErrors($error, $code, $validRoles, $userRoles)
    {
        return response()
            ->json([
                'error' => $error,
                'status' => $code,
                'valid_roles' => $validRoles,
                'your_role' =>  $userRoles
            ]);
    }

    public function getMessages($message, $code)
    {
        return response()
            ->json([
                'message' => $message,
                'status' => $code
            ]);
    }
}
