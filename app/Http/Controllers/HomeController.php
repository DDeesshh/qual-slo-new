<?php

namespace App\Http\Controllers;

use App\Models\Query;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

        // ----------------------------------- конструктор с проверкой на роль администратора -----------------------------------
        public function __construct()
        {
            // $this->middleware('admin')->only([ 'index', 'update']);
        }

     // ----------------------------------- index -----------------------------------
    public function index()
    {
        $queries = Query::orderBy('created_at', 'desc')->get();
        $queriesSolved = Query::where('status', 'Решена')->orderBy('updated_at', 'desc')->limit(5)->get();
        $resolved = Query::where('status', 'Решена')->count();
        $AllowedQueries = Query::whereIn('status', ['Решена', 'В процессе', 'Отклонено'])->get();
        $NewQueries = Query::where('status', 'Новая')->get();

        return view('home', [
            'title' => 'Главная страница',
            'queries' => $queries,
            'queriesSolved' => $queriesSolved,
            'AllowedQueries' => $AllowedQueries,
            'NewQueries' => $NewQueries,
            'resolved' => $resolved,
        ]);
    }

    // ----------------------------------- update -----------------------------------
    public function update(Request $request, $query_id)
    {
        if (!auth()->user()->admin) {
            abort(403);
        }

        if ($request->status) {
            Query::where('query_id', $query_id)->update(['status' => $request->status]);
        }

        if ($request->hasFile('photo_before')) {
            $photo_before_path = $request->file('photo_before')->store('images');
            Query::where('query_id', $query_id)->update(['photo_before' => $photo_before_path]);
        }

        if ($request->hasFile('photo_after')) {
            $photo_after_path = $request->file('photo_after')->store('images');
            Query::where('query_id', $query_id)->update(['photo_after' => $photo_after_path]);
        }

        return redirect('home');
    }

}
