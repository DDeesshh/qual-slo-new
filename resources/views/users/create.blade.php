@extends('layouts.layout')
@section('title')
    @parent{{ $title }}
@endsection

@section('basic_header')
    @parent
    <div class="container">
        <p>Создание пользователя</p>
    </div>
@endsection
@section('content')
    <div class="container">
        <form action="{{ route('users.store') }}" method ="post" enctype="multipart/form-data">
            @csrf
            <label for="name">Введите имя</label>
            <input class="form-control" type="text" name="name">
            <label for="email">Введите email</label>
            <input class="form-control" type="text" name="email">
            <label for="password">Введите пароль</label>
            <input class="form-control" type="password" name="password">
            <label for="password">Введите пароль</label>
            <input class="form-control" type="password" name="password_confirmation">
            <div class="mb-3">
                <label for="avatar" class="form-label">Загрузите фотографию для аватара</label>
                <input type="file" class="form-control" id="avatar" name="avatar">
            </div>
            <button class="py-2 my-3" type="submit">Зарегистрироваться</button>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
