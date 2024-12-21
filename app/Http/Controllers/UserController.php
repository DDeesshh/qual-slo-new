<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ----------------------------------- index -----------------------------------
    public function index()
    {
        $queries = auth()->user()->queries;
        return view('users.profile', ['title'=>'Профиль', 'queries' => $queries]);
        
    }

    // -----------------------------------create -----------------------------------
    public function create()
    {
        return view('users.create', ['title' => "Создание пользователя"]);
    }

    // ----------------------------------- store -----------------------------------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:3', 'max:15'],
            'avatar' => ['nullable', 'image'],
        ]);

        // Сохраняем аватар, если он был загружен
        $avatar_path = $request->hasFile('avatar')
            ? $request->file('avatar')->store('images', 'public')
            : null;

        // Создание пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar' => $avatar_path,
            'role' => $request->role ?? 0,

        ]);

        return redirect('home')->with('success', 'Пользователь создан успешно!');
    }

    // ----------------------------------- update -----------------------------------
    public function update(Request $request, $queryId)
    {   // Логика для обновления заявки
        if (!auth()->check()) {
            return redirect()->route('loginform')->withErrors(['auth' => 'Пожалуйста, войдите в систему']);
        }

        if (auth()->user()->role != 1) {
            return redirect()->route('home')->withErrors(['access' => 'У вас нет прав для выполнения этого действия.']);
        }
    }

    // ----------------------------------- loginform -----------------------------------
    public function loginform() {
        return view('users.loginform', ['title' => "Вход"]);
    }

    // ----------------------------------- login -----------------------------------
    public function login(Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'Введенные данные не соответствуют.',
        ])->onlyInput('email');

    }

    // ----------------------------------- logout -----------------------------------
    public function logout() {
        Auth::logout();
        return redirect()->route('loginform');
    }
}
