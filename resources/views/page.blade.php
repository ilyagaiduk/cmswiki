<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$indexText->h1}} — {{$settings->title}}</title>
    <meta property="og:title" content="{{$indexText->h1}}"/>
    <meta property="og:description" content="Самая занимательная вики энциклопедия — {{$settings->title}}"/>
    <meta property="og:image" content="<?php echo url(''); ?>{{$indexText->img}}"/>
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
            <img class="sm:rounded-lg" src="{{$indexText->img}}" width="250px"/>
             <div class="text-end">
                 @if(Auth::check())
                     <div class="text-center">
                     @if ($message = Session::get('success'))
                         <div style="color: green;">
                             <strong>{{ $message }}</strong>
                         </div>
                     @endif
                     </div>
                     @if(Auth::user()->name == 'admin')
                <style>
                    .image-upload>input {
                        display: none;
                    }
                </style>
                <form method="post" action="{{ route('saveMainImage') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="text-center image-upload mb-2">
                        <label for="image">
                            <img id="attach" style="cursor:pointer" class="sm:rounded-lg" src="/img/attach.png" width="36px"/>
                        </label>
                        <input name="image" id="image" type="file" />
                    </div>
                    <input type='hidden' name='url2' value='<?php echo $_SERVER['REQUEST_URI']; ?>'>

                    <div class="text-center"><button class="btn btn-secondary " type="submit">Загрузить</button></div>
                    <div class="text-center">

                    </div>
                </form>
                     @endif

                @endif
                <div class="text-center mt-5">
                    <form action="{{route('random')}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Рандомная статья</button>
                    </form>
                </div>
                <div class="text-center mt-3">
                    <form action="{{route('new')}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Новое</button>
                    </form>
                </div>
                <div class="text-center mt-3">
                    {!! $settings->search !!}
                </div>
                     @if(Auth::check())
                     @if(Auth::user()->name == 'admin')
                         <div class="text-center"><a href="{{route('moderate')}}">Правки({{$countModerate}})</a></div>

                     @endif
                     @endif
            </div>
        </div>
        <div class="col-md-1">

        </div>
        <div class="col-md-7">
            @if(Auth::check()) <div class="text-end">
                <img id="pencil" style="cursor:pointer" class="sm:rounded-lg" src="/img/pencil.png" width="36px"/>
            </div>@endif
            <h1 id="h1">{{$indexText->h1}}</h1>
            <hr>
            <div id="text">{!! $indexText->text !!}</div>
            <br>
                @if(Auth::check())
                    @if(Auth::user()->name == 'admin')
            <form action="{{route('deletePage')}}" method="post">
                @csrf
                <input type='hidden' name='url3' value='<?php echo $_SERVER['REQUEST_URI']; ?>'>
                <button class="btn btn-warning" id="deleteButton" type="submit">Удалить страницу</button>
            </form>
                <script>
                    $("#deleteButton").click(function(){
                        if(confirm("Вы дейсвтительно хотите удалить страницу?")){
                           alert('Хорошо, удаляем страницу!')
                        }
                        else{
                            return false;
                        }
                    });
                </script>
                        @endif
                    @endif
        </div>
        <script>
            $(document).ready(function() {
                $(document).on('click touchstart', '#pencil', function(){
                    let header = $("#h1").text();
                    $('#h1').append('<form id=\'formText\' method=\'post\' action=\'/savemain\'> @csrf <input name=\'newh1\' class=\'form-control\' type=\'text\' value=\''+ header +'\'>');
                    let text = $("#text").html();
                    $('#h1').append('<br><textarea form=\'formText\' name=\'newText\' id=\'textarea\' rows=\'10\' class=\'form-control\'>'+ text +'</textarea>');
                    $('#h1').append('<input form=\'formText\' type=\'hidden\' name=\'url\' value=\'<?php echo $_SERVER['REQUEST_URI']; ?>\'>');
                    $('#h1').append('<br><button class=\'btn btn-success\' id=\'submit\' type=\'submit\'>Сохранить</button></form>');
                    $('#pencil').remove();

                });
            });
            $(function() {
                $(document).on('click touchstart', '#submit', function(){
                    $('#formText').submit();
                });
            });



        </script>
    </div>
    <div class="row">
        <div class="col-md-5">

        </div>
        <div class="col-md-7 text-center">
            <hr>
            <span>Опубликовал(а): @if($userInfo->currname == 0){{$userInfo->name}} @else {{$userInfo->fullname}} @endif</span>
            <br>
            <span>Просмотров: {{$indexText->views}}</span>
            <br>
            <?php
            date_default_timezone_set($settings->timezone); // your user's timezone
            $my_datetime= $indexText->date;
            $numMonth = date('n', strtotime($my_datetime));
            $array = [1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа', 9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'];
            ?>
            <span>Последнее редактирование: <?php echo date('j ' . $array[$numMonth] . ', Y H:i', strtotime("$indexText->date Europe/Moscow")); ?>, Часовой пояс: {{$settings->timezone}}</span>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
{!! $settings->metrika !!}
</body>
</html>

