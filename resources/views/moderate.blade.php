<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Модерация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous">
    </script>
    <link rel="icon" type="image/png" href="{{$settings->favicon}}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <a href="/index"><img src="/img/logo-not-fon.png" width="65px"/></a> <span class="fs-2">{{$settings->title}}</span>
        </div>
        <div class="col-md-8">
            <div class="fs-5 text-end">@if(Auth::check())<a id="user" class="link-dark" href="#">@if($currName == 0) {{ Auth::user()->name }} @elseif($currName == 1) {{ Auth::user()->fullname }}@endif</a><br><div id="menu" style="display:none; background: #f7fafc; width: 150px; height: 200px" class="col float-end"><a class="link-dark p-3" href="/index">Главная</a><br><br><a class="link-dark p-3" href="{{ route('settings') }}">Настройки</a><br><br><a class="link-dark p-3" href="/logout">Выйти</a></div></div> @else <a class="pe-3 link-dark" href="/login">Войти</a>   <a class="link-dark" href="/register">Регистрация</a>@endif</div>
    </div>
</div>
</div>
<script>
    $(document).ready(function(){
        $('#user').click(function(){
            $('#menu').slideToggle(300);
            return false;
        });
    });
</script>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 text-center">
            <img class="sm:rounded-lg" src="/img/logo-wiki.webp" width="250px"/>
            <div class="text-center">
                @if ($message = Session::get('success'))
                    <div style="color: green;">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
            </div>
            <div class="text-end">
                @if(Auth::check())

                @if(Auth::user()->name == 'admin')
                    <div class="text-center"><a href="{{route('moderate')}}">Правки</a></div>
@endif
                @endif
            </div>
        </div>
        <div class="col-md-1">

        </div>
        <div class="col-md-7">
            @if(Auth::check())
                @if(Auth::user()->name == 'admin')
<table class="table table-responsive">
    <h1>Тексты, отправленные на правку</h1>
    <thead>
    <th>URL</th>
    <th>Заголовок</th>
    <th>Текст</th>
    <th>User</th>
    <th>Дата</th>
    <td>Править</td>
    </thead>
    @foreach($articles as $value)
        <tr>
            <td><a href="{{$value->url}}">{{$value->url}}</a></td>
            <td>{{$value->h1}}</td>
            <td>{{$value->text}}</td>
            <td>{{$value->user}}</td>
            <td>{{$value->date}}</td>
            <td>
            <form method="post">
                @csrf
                <input type="hidden" name="url" value="{{$value->url}}">
                <input type="hidden" name="text" value="{{$value->text}}">
                <input type="hidden" name="h1" value="{{$value->h1}}">
                <input type="hidden" name="type" value="success">
                <button type="submit" class="btn btn-success">Одобрить</button>

            </form>
            <form class="mt-2" method="post">
                @csrf
                <input type="hidden" name="url" value="{{$value->url}}">
                <input type="hidden" name="text" value="{{$value->text}}">
                <input type="hidden" name="h1" value="{{$value->h1}}">
                <input type="hidden" name="type" value="delete">
                <button type="submit" class="btn btn-warning">Удалить</button>
            </form>
            </td>
        </tr>

    @endforeach
</table>
                @endif
                @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
{!! $settings->metrika !!}
</body>
</html>

<?php
