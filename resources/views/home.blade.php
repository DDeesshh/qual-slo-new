@extends('layouts.layout')

@section('title')
    @parent{{ $title }}
@endsection


@section('content')
    <div class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-12 col-md-8 mx-auto">
                <h1 class="fw-light">Сделаем лучше вместе!</h1>
                @guest
                    <p class="lead">На данном портале вы моежете подать заявку на устранение проблем в вашем городе.
                    </p>
                @endguest
                @auth
                    <p class="lead">Перейдите в личный кабинет для подачи новых заявок и просмотра статуса текущих.
                    </p>
                    <div>
                        <h2>Количество решенных заявок</h2>
                        <p><strong>{{ $resolved }}</strong>
                    </div>
                    <p>
                        <a href="{{ route('newquery') }}" class="btn btn-primary my-2">Подать заявку</a>
                        <a href="{{ route('profile') }}" class="btn btn-secondary my-2">Личный кабинет</a>
                    </p>
                @endauth
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <h3>Последние решенные заявки</h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            @foreach ($queriesSolved as $query)
                <div class="col">
                    <div class="card shadow-sm ">
                        <h5>Фото до</h5>
                        <img src="{{ asset( $query->photo_before) }}" class="bd-placeholder-img card-img-top" width="100%"
                            height="225" role="img">

                        <h5>Фото после</h5>
                        <img src="{{ asset($query->photo_after) }}" class="bd-placeholder-img card-img-top" width="100%"
                            height="225" role="img">
                        <div class="card-body">
                            <p class="card-text">Заголовок: {{ $query->title }}</p>
                            <p class="card-text">Описание: {{ $query->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @auth
        @if (auth()->user()->role == 1)
            <div class="container">
                <h2>Все заявки(только для администратора)</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col">Заголовок</th>
                            <th class="col">Дата создания заявки</th>
                            <th class="col">Код заявки</th>
                            <th class="col">Обновление статуса заявки</th>
                            <th class="col">Добавление фото решения</th>
                            <th class="col">Удаление заявки</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($AllowedQueries as $query)
                            <tr>
                                <td>{{ $query->title }}</td>
                                <td>{{ $query->created_at->format('d.m.y, H:i') }}</td>
                                <td>{{ $query->query_id }}</td>
                                <td>
                                    <form action="{{ route('home.update', $query->query_id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <select name="status" id="status" class="form-select">
                                            <option value="В процессе" {{ $query->status == 'В процессе' ? 'selected' : '' }}>В
                                                процессе</option>
                                            <option value="Решено" {{ $query->status == 'Решено' ? 'selected' : '' }}>Решено
                                            </option>
                                            <option value="Отклонена" {{ $query->status == 'Отклонено' ? 'selected' : '' }}>
                                                Отклонена</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary mt-3">Изменить статус</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('home.update', $query->query_id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input class="form-control" id="photo_after" type="file" name="photo_after">
                                        <button type="submit" class="btn btn-primary mt-3">Добавить фото</button>
                                    </form>
                                </td>
                                <td>
                                    <a class="btn btn-primary link-underline-opacity-0 link-light"
                                        href="{{ route('queries.destroy', $query->query_id) }}">Удалить</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h2>Новые заявки</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col">Заголовок</th>
                            <th class="col">Дата создания заявки</th>
                            <th class="col">Код заявки</th>
                            <th class="col">Описание</th>
                            <th class="col">Отклонение</th>
                            <th class="col">Одобрение</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($NewQueries as $query)
                            <tr>
                                <td>{{ $query->title }}</td>
                                <td>{{ $query->created_at->format('d.m.y, H:i') }}</td>
                                <td>{{ $query->query_id }}</td>
                                <td>{{ $query->description }}</td>
                                <td>
                                    <form action="{{ route('queries.reject', $query->query_id) }}" method="POST">
                                        @csrf
                                        <label for="comment">Введите комментарий для отклонения</label>
                                        <input class="form-control" type="text" name="comment" id="comment">
                                        <button type="submit"
                                            class="btn btn-primary link-underline-opacity-0 link-light mt-3">Отклонить</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('queries.aprove', $query->query_id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-primary link-underline-opacity-0 link-light mt-3">Одобрить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endauth

    @auth
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                </div>
                <p class="text-center my-3 py-2 btn container-fluid"><a href="{{ route('queries') }}">Посмотреть
                        свою историю заявок</a></p>
            </div>
        </div>
    @endauth

    @guest
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                </div>
                <p class="text-center my-3 py-2 container-fluid"><a href="{{ route('users.create') }}">Зарагестрируйтесь</a>
                    или
                    <a href="{{ route('login') }}">войдите</a> в аккаунт, чтобы посмотреть свою историю
                    заявок
                </p>
            </div>
        </div>
    @endguest
@endsection
