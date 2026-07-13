<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // 管理者ログイン機能用
        // 作成したミドルウェアを登録
        // -----------------------
        $middleware->prependToGroup('web', \App\Http\Middleware\UseAdminSessionCookie::class);
        // -----------------------

    })
    ->withExceptions(function (Exceptions $exceptions) {

        // 管理者ログイン機能用
        // ミドルウェアでガードされてるページに不正アクセスがあった時の振り分け
        // -----------------------
        $exceptions->render(function (AuthenticationException $e, $request) {
            if (in_array('admin', $e->guards())) {
                return redirect()->guest(route('admin.login'));
            }

            // admin以外（通常のweb guard）は今まで通り
            return redirect()->guest(route('login'));
        });
        // -----------------------
        
    })->create();
