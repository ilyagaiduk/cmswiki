<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Настройки пользователя {{ Auth::user()->name }}</title>
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
            <div class="fs-5 text-end">@if(Auth::check())<a id="user" class="link-dark" href="#">@if($currName == 0) {{ Auth::user()->name }} @elseif($currName == 1) {{ Auth::user()->fullname }}@endif</a><br><div id="menu" style="display:none; background: #f7fafc; width: 150px; height: 200px" class="col float-end"><a class="link-dark p-3" href="/index">Главная</a><br><br><a class="link-dark p-3" href="{{route('settings')}}">Настройки</a><br><br><a class="link-dark p-3" href="/logout">Выйти</a></div></div> @endif</div>
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
            <img class="sm:rounded-lg" src="/img/settings.png" width="250px"/>
        </div>
        <div class="col-md-1">

        </div>
        <div class="col-md-7">
            <h1>Настройки — @if($currName == 0) {{ Auth::user()->name }} @elseif($currName == 1) {{ Auth::user()->fullname }}@endif</h1>
            <hr>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Общие</button>
                </li>
                @if(Auth::user()->name == 'admin')
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Пользователи</button>
                </li>
                @endif
{{--                <li class="nav-item" role="presentation">--}}
{{--                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Приватность</button>--}}
{{--                </li>--}}
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <hr>
                   <form class="form-control" method="post" action="{{route('getSettings')}}">
                        @csrf
                       @if (count($errors) > 0)
                           <div class="alert alert-danger">
                               <ul>
                                   @foreach ($errors->all() as $error)
                                       <li>{{ $error }}</li>
                                   @endforeach
                               </ul>
                           </div>
                       @endif
                       @if(Auth::user()->name == 'admin')
                       <h2>Часовой пояс</h2>
                    <select name="timezone" class="form-control">
                        @foreach($timezones as $value)
                        <option @if(" ".$currentTimezone == $value->timezone) selected @endif value="{{$value->timezone}}">{{$value->utc}}, {{$value->timezone}}</option>
                    @endforeach
                    </select>
                        <hr>
                        <h2>Заголовок сайта</h2>
                        <span>Заголовок не более 75 символов</span>
                        <input name="title" class="form-control mt-2" type="text" value="{{$settings->title}}">

                        <hr>
                        <h2>Имя пользователя</h2>
                        <span>Введите Имя(не более 100 символов)</span>
                        <input name="userName" class="form-control mt-2" type="text" value="{{$userInfo->fullname}}">
                        <span>Отображать, как:</span>
                        <select class="form-control mt-2" name="currName">
                            <option @if($currName == 0) selected @endif value="0">{{$userInfo->name}}</option>
                            <option @if($currName == 1) selected @endif value="1">{{$userInfo->fullname}}</option>
                        </select>
                           <hr>
                       <h2>Яндекс Метрика и Google Analytics</h2>
                           <textarea class="form-control mb-2" name="metrika" cols="40" rows="10">{{$settings->metrika}}</textarea>
                       <hr>
                           <h2>Сколько постов на правку отображать? Максимально 5.</h2>
                           <input value="{{$settings->version}}" class="form-control" type="number" min="1" max="5" name="countVersion">
                           <hr>
                           <h2>Код поисковой формы Яндекс.Поиск для сайта</h2>
                       <span><a target="_blank" href="https://site.yandex.ru/">Сайт</a></span>
                       <span> Где показывать результаты поиска(<a href="https://disk.yandex.ru/i/lCpJxVmcB-HsAw">Скрин</a>)</span>
                           <textarea class="form-control mt-2 mb-2" name="poisk" cols="40" rows="10">{{$settings->search}}</textarea>
                           <hr>
                           <h2>Favicon</h2>
                       <span>Загрузите Favicon в каталог /public/img и вставьте адрес (пример, /img/logo-not-fon.png)</span>
                           <input value="{{$settings->favicon}}" class="form-control" type="text" name="favicon">
                           <hr>
                           <br>
                       @elseif(Auth::user()->name != 'admin')
                           <hr>
                           <h2>Имя пользователя</h2>
                           <span>Введите Имя(не более 100 символов)</span>
                           <input name="userName" class="form-control mt-2" type="text" value="{{$userInfo->fullname}}">
                           <span>Отображать, как:</span>
                           <select class="form-control mt-2" name="currName">
                               <option @if($currName == 0) selected @endif value="0">{{$userInfo->name}}</option>
                               <option @if($currName == 1) selected @endif value="1">{{$userInfo->fullname}}</option>
                           </select>
                           <hr>
                       @endif
                        <button class="mt-2 btn btn-success" type="submit">Сохранить</button>
                    </form>


                    </div>
                @if(Auth::user()->name == 'admin')
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
<h1>Пользователи</h1>
                    <table class="table table-responsive">
                        <thead>
                        <th>Логин</th>
                        <th>Полное имя</th>
                        <th>Email</th>
                        @foreach($profiles as $value)
                        <tr>
                            <td>{{$value->name}}</td>
                            <td>{{$value->fullname}}</td>
                            <td>{{$value->email}}</td>
                        </tr>
                            @endforeach
                        </thead>
                    </table>
                </div>
                @endif
{{--                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">3</div>--}}
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>
</html>

