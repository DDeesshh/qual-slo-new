@extends('layouts.layout')
@section('title')
    @parent{{ $title }}
@endsection

@section('basic_header')
    @parent
    <div class="container">
        <h1>Вход</h1>
    </div>
@endsection
@section('content')
    <div class="container mt-5 mb-5">
        <form action="{{ route('login') }}" method ="post">
            @csrf
            <label for="email">Введите email</label>
            <input class="form-control" type="text" name="email">
            <label for="password" class="mt-2">Введите пароль</label>
            <input class="form-control" type="password" name="password">
            <button class="btn btn-primary container-fluid my-2 mt-3" type="submit">Войти</button>
        </form>
    </div>
@endsection

