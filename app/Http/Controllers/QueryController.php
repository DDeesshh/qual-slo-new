<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Query;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QueryController extends Controller
{
    // ----------------------------------- конструктор с проверкой на роль администратора -----------------------------------
    // public function __construct()
    // {
    //     $this->middleware('admin')->only(['show', 'store', 'index']);
    // }

    // ----------------------------------- index -----------------------------------
    public function index()
    {
        $queries = Query::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('queries', ['title' => 'Заявки', 'queries' => $queries]);
    }

    // ----------------------------------- store -----------------------------------
    public function store(Request $request)
    {
        $validate = $request->validate([
            'photo_before' => ['image'],
            'photo_after' => ['image'],
        ]);

        if ($request->hasFile('photo_before')) {
            $photo_before_path = $request->file('photo_before')->store('images');
        } elseif (!$request->hasFile('photo_before')) {
            abort(403);
        }

        Query::create([
            'category_id' => $request->category_id,
            'description' => $request->description,
            'photo_before' => $photo_before_path,
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'status' => $request->status ?? 'Новая',
        ]);

        return redirect('profile');
    }

    // ----------------------------------- show -----------------------------------
    public function show()
    {
        $categories = Category::all();
        return view('newquery', ['title' => 'Создание заявки', 'categories' => $categories]);
    }

    // ----------------------------------- destroy -----------------------------------
    public function destroy($query_id)
    {
        Query::where('query_id', $query_id)->delete();
        return redirect('profile');
    }

    // ----------------------------------- reject -----------------------------------
    public function reject(Request $request, $query_id)
    {
        Query::where('query_id', $query_id)->update(['status' => 'Отклонено', 'comment' => $request->comment]);
        return redirect('/home');
    }

    // ----------------------------------- aprove -----------------------------------
    public function aprove($query_id)
    {
        Query::where('query_id', $query_id)->update(['status' => 'В процессе']);
        return redirect('/home');
    }


}
