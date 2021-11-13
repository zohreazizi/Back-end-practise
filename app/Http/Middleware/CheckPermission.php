<?php

namespace App\Http\Middleware;

use App\Traits\Responses;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HTTPResponse;


class CheckPermission
{
    use Responses;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('api')->user();
        $userRoles = $user->roles()->pluck('name')->toArrayy();

        foreach ($roles as $role) {
            if (!in_array($role, $userRoles)) {
                return $this->getErrors('Unauthorized', HTTPResponse::HTTP_FORBIDDEN);
            }
        }
        return $next($request);
    }
}
