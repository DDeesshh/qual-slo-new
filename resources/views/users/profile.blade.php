@extends('layouts.layout')

@section('title')
    @parent{{ $title }}
@endsection


@section('content')
    <div class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-12 col-md-8 mx-auto">
                <h1 class="fw-light">Ваш личный кабинет</h1>
                <p class="lead">Здесь собрана информация о вас, а также вы можете посмотреть свои заявки
                </p>
                <div class="text-start py-4">
                    <h3>Ваши данные</h3>
                    <p>Ваше имя: {{ auth()->user()->name }}</p>
                    <p>Ваш аватар: <br><img src="{{ asset('storage/' . auth()->user()->avatar) }}" height="60px" width="60px"></p>
                    @if (auth()->user()->role == 1)
                    <p>
                        <a href="{{ route('categories.create') }}" class="btn btn-dark my-2">Создать категорию</a>
                    </p>
                @else
                    <p class="text-muted">Вы не можете создавать категории, так как у вас нет прав администратора.</p>
                @endif

                @if (auth()->user()->role == 0)
                    <p>
                        <a href="{{ route('newquery', ['user_id' => auth()->user()->id]) }}" class="btn btn-dark my-2">Подать заявку</a>
                    </p>
                @endif
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="col">Заголовок</th>
                                <th class="col">Дата создания заявки</th>
                                <th class="col">Код заявки</th>
                                <th class="col">Статус заявки</th>
                                <th class="col">Удаление заявки</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($queries as $query)
                                <tr>
                                    <td>{{ $query->title }}</td>
                                    <td>{{ $query->created_at->format('d.m.y, H:i') }}</td>
                                    <td>{{ $query->query_id }}</td>
                                    <td>
                                        @if (auth()->user()->role == 1)
                                            <form action="{{ route('home.update', $query->query_id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <select name="status" id="status" class="form-select">
                                                    <option value="В процессе"
                                                        {{ $query->status === 'В процессе' ? 'selected' : '' }}>В
                                                        процессе</option>
                                                    <option value="Решена"
                                                        {{ $query->status === 'Решена' ? 'selected' : '' }}>
                                                        Решена
                                                    </option>
                                                    <option value="Отклонена"
                                                        {{ $query->status === 'Отклонено' ? 'selected' : '' }}>
                                                        Отклонена</option>
                                                </select>
                                                @if ($query->status === 'Отклонено')
                                                    <p><strong>Комментарий:</strong> {{ $query->comment }}</p>
                                                @endif
                                                <button type="submit" class="btn btn-primary mt-3">Изменить статус</button>
                                            </form>
                                        @elseif (!auth()->user()->role == 1)
                                            {{ $query->status }}
                                            @if ($query->status === 'Отклонено')
                                                <p><strong>Комментарий:</strong> {{ $query->comment }}</p>

                                            @endif

                                        @endif
                                    </td>
                                    <td>
                                        @if ($query->status === 'Новая' || $query->status === 'Отклонено')
                                            <a class="btn btn-primary link-underline-opacity-0 link-light"
                                                href="{{ route('queries.destroy', $query->query_id) }}">Удалить</a>
                                        @else
                                            <a class="btn btn-secondary link-underline-opacity-0 link-light">Нельзя
                                                удалить</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p>
                    <a href="{{ route('newquery', ['user_id' => asset(auth()->user()->id)]) }}"
                        class="btn btn-dark my-2">Подать заявку</a>
                </p>
            </div>
        </div>
    </div>

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            </div>
            <p class="text-center my-3 py-2 btn container-fluid"><a href="{{ route('queries') }}">Посмотреть
                    свою историю заявок</a></p>
        </div>
    </div>
@endsection
