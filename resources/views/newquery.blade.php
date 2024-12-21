@extends('layouts.layout')

@section('title')
    @parent{{ $title }}
@endsection


@section('content')
    <div class="py-5 text-center container">
        <form action="{{route('newquery.create')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="title">Заголовок</label>
                <input class="form-control" id="title" type="text" name="title">
            </div>
            <div class="mb-3">
                <label class="form-label" for="category">Категория</label>
                <select name="category_id" id="category" class="form-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="description">Описание проблемы</label>
                <input class="form-control" id="description" type="text" name="description">
            </div>
            <div class="mb-3">
                <label class="form-label" for="photo_before">Фото проблемы</label>
                <input class="form-control" id="photo_before" type="file" name="photo_before">
            </div>
            <button type="submit">Добавить</button>
        </form>
    </div>
@endsection
