<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();

        if (!$user || !$user->can($permission)) {
            return response()->json(['message' => 'Papel não autorizado'], 403);
        }

        return $next($request);
    }
}
