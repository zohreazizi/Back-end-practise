<?php

namespace App\Http\Middleware;

use App\Traits\Responses;
use Closure;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HTTPResponse;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Array_;


class CheckPermission
{
    use Responses;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param Arr $validRoles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$validRoles)
    {
        $user = auth('api')->user();
        $userRoles[] = $user->roles()->pluck('name');

        foreach ($validRoles as $validRole) {
            if (!in_array($validRole, $userRoles)) {
                return $this->getErrors('Unauthorized', HTTPResponse::HTTP_FORBIDDEN, $validRoles, $userRoles);
            }
        }
        return $next($request);
    }
}
