<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// 管理者ログイン機能用に、このミドルウェアを作成しました
// ユーザーと管理者でセッションを使い分けるミドルウェア

class UseAdminSessionCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin*')) {
            config(['session.cookie' => 'admin_session']);
        }

        return $next($request);
    }
}
