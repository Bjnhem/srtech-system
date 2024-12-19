<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $roles = null)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.signin');
        }

        $user = Auth::user();

        // Nếu không truyền role, cho phép truy cập
        if (!$roles) {
            return $next($request);
        }

        // Nếu roles là một mảng, kiểm tra người dùng có thuộc một trong các role đó không
        $roles = is_array($roles) ? $roles : explode(',', $roles);

        // Kiểm tra role của người dùng
        if (!in_array($user->user_type, $roles)) {
            // Lưu thông báo lỗi vào session
            Session::flash('error', 'Bạn không có quyền truy cập vào trang này.');

            // Redirect về trang trước đó (hoặc trang home nếu không có)
            return redirect()->back()->withInput();
        }

        return $next($request);
    }
}
