<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // ----------------------------------- конструктор с проверкой на роль администратора -----------------------------------
    public function __construct()
    {
        $this->middleware('admin')->only(['create', 'store', 'index']);
    }

    // ----------------------------------- index -----------------------------------
    public function index()
    {
        $categories = Category::all(); // Получаем все категории
        return view('categories.index', ['categories' => $categories]); // Возвращаем представление с данными категорий
    }

    // ----------------------------------- create -----------------------------------
    public function create()
    {
        return view('categories.create', ['title' => 'Создать категорию']);
    }

    // ----------------------------------- store -----------------------------------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        Category::create([
            'name' => $validated['name'], // Сохраняем новую категорию
        ]);
        return redirect()->route('categories.index')->with('success', 'Категория успешно создана!');
    }
}
