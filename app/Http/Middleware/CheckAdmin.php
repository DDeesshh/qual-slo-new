<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Убедитесь, что пользователь аутентифицирован
        if (!auth()->check()) {
            return redirect()->route('loginform')->withErrors(['access' => 'Вы должны быть авторизованы.']);
        }

        // Проверьте, является ли пользователь администратором
        if (auth()->user()->role != 1) {
            // Перенаправьте на страницу, не использующую этот миддлваре, чтобы избежать цикла
            return redirect()->route('profile')->withErrors(['access' => 'У вас нет прав для выполнения этого действия.']);
        }

        return $next($request);
    }
}
