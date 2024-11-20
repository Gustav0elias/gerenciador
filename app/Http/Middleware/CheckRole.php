<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        \Log::info('Papéis do usuário:', $user->getRoleNames()->toArray());

        if (!array_intersect($user->getRoleNames()->toArray(), $roles)) {
            return response()->json(['message' => 'Papel não autorizado'], 403);
        }

        return $next($request);
    }
}
