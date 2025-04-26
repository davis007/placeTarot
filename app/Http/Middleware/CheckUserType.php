<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $userType
     */
    public function handle(Request $request, Closure $next, string $userType = null): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if ($userType === 'admin' && !$request->user()->isAdmin()) {
            abort(403, '管理者権限が必要です。');
        }

        if ($userType === 'practitioner' && !$request->user()->isPractitioner()) {
            abort(403, '鑑定師権限が必要です。');
        }

        if ($userType === 'expert' && !$request->user()->isExpert()) {
            abort(403, '優良鑑定師権限が必要です。');
        }

        if ($userType === 'client' && !$request->user()->isClient()) {
            abort(403, '相談者権限が必要です。');
        }

        return $next($request);
    }
}
