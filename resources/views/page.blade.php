<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$indexText->h1}} — {{$settings->title}}</title>
    <meta property="og:title" content="{{$indexText->h1}}"/>
    <meta property="og:description" content="{{ __('ui.page_description', ['title' => $settings->title]) }}"/>
    <meta property="og:image" content="<?php echo url(''); ?>{{$indexText->img}}"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous">
    </script>
    <link rel="icon" type="image/png" href="{{$settings->favicon}}">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable_inline {
            min-height: 360px;
        }
        #editBox {
            display: none;
        }
        #editBox .form-control {
            border-radius: .375rem;
        }
        #text img,
        .ck-content img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        #text figure.image {
            margin: 1rem 0;
        }
        #text figure.image img {
            margin-left: auto;
            margin-right: auto;
        }
        #text blockquote,
        .ck-content blockquote {
            border-left: 5px solid #198754;
            margin: 1.25rem 0;
            padding: .75rem 1rem;
            background: #f8f9fa;
            color: #333;
            font-style: italic;
        }
        #text blockquote p,
        .ck-content blockquote p {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <a href="/index"><img src="/img/logo-not-fon.png" width="65px"/></a> <span class="fs-2">{{$settings->title}}</span>
        </div>
        <div class="col-md-8">
            <div class="fs-5 text-end">@if(Auth::check())<a id="user" class="link-dark" href="#">@if($currName == 0) {{ Auth::user()->name }} @elseif($currName == 1) {{ Auth::user()->fullname }}@endif</a><br><div id="menu" style="display:none; background: #f7fafc; width: 150px; height: 200px" class="col float-end"><a class="link-dark p-3" href="/index">{{ __('ui.home') }}</a><br><br><a class="link-dark p-3" href="{{ route('settings') }}">{{ __('ui.settings') }}</a><br><br><a class="link-dark p-3" href="/logout">{{ __('ui.logout') }}</a></div></div> @else <a class="pe-3 link-dark" href="/login">{{ __('ui.login') }}</a>   <a class="link-dark" href="/register">{{ __('ui.register') }}</a>@endif</div>
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

                    <div class="text-center"><button class="btn btn-secondary " type="submit">{{ __('ui.upload') }}</button></div>
                    <div class="text-center">

                    </div>
                </form>
                     @endif

                @endif
                <div class="text-center mt-5">
                    <form action="{{route('random')}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-secondary">{{ __('ui.random_article') }}</button>
                    </form>
                </div>
                <div class="text-center mt-3">
                    <form action="{{route('new')}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-secondary">{{ __('ui.new') }}</button>
                    </form>
                </div>
                <div class="text-center mt-3">
                    {!! $settings->search !!}
                </div>
                     @if(Auth::check())
                     @if(Auth::user()->name == 'admin')
                         <div class="text-center"><a href="{{route('moderate')}}">{{ __('ui.edits') }}({{$countModerate}})</a></div>

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
            <div id="text">{!! html_entity_decode($indexText->text, ENT_QUOTES, 'UTF-8') !!}</div>

            @if(Auth::check())
                <div id="editBox" class="mt-3">
                    <form id="formText" method="post" action="/savemain">
                        @csrf
                        <div class="mb-3">
                            <label for="newh1" class="form-label">{{ __('ui.title') }}</label>
                            <input name="newh1" id="newh1" class="form-control" type="text" value="{{ $indexText->h1 }}">
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="editor" class="form-label mb-0">{{ __('ui.article_text') }}</label>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-danger btn-sm" id="clearEditorLinks" type="button">{{ __('ui.remove_links') }}</button>
                                    <button class="btn btn-outline-secondary btn-sm" id="toggleHtmlMode" type="button">{{ __('ui.html_code') }}</button>
                                </div>
                            </div>
                            <textarea name="newText" id="editor" rows="16" class="form-control">{!! e(html_entity_decode($indexText->text, ENT_QUOTES, 'UTF-8')) !!}</textarea>
                            <input type="hidden" name="newTextHtml" id="newTextHtml">
                        </div>
                        <input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <button class="btn btn-success" id="submit" type="submit">{{ __('ui.save') }}</button>
                        <button class="btn btn-secondary" id="cancelEdit" type="button">{{ __('ui.cancel') }}</button>
                    </form>
                </div>
            @endif
            <br>
                @if(Auth::check())
                    @if(Auth::user()->name == 'admin')
            <form action="{{route('deletePage')}}" method="post">
                @csrf
                <input type='hidden' name='url3' value='<?php echo $_SERVER['REQUEST_URI']; ?>'>
                <button class="btn btn-warning" id="deleteButton" type="submit">{{ __('ui.delete_page') }}</button>
            </form>
                <script>
                    $("#deleteButton").click(function(){
                        if(confirm(@json(__('ui.confirm_delete_page'))){
                           alert(@json(__('ui.ok_delete_page')))
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
                let wysiwygEditor = null;
                let htmlMode = false;

                class UploadAdapter {
                    constructor(loader) {
                        this.loader = loader;
                        this.xhr = null;
                    }

                    upload() {
                        return this.loader.file.then(file => new Promise((resolve, reject) => {
                            this._initRequest();
                            this._initListeners(resolve, reject, file);
                            this._sendRequest(file);
                        }));
                    }

                    abort() {
                        if (this.xhr) {
                            this.xhr.abort();
                        }
                    }

                    _initRequest() {
                        const xhr = this.xhr = new XMLHttpRequest();
                        xhr.open('POST', '/ckeditor/upload', true);
                        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        xhr.responseType = 'json';
                    }

                    _initListeners(resolve, reject, file) {
                        const xhr = this.xhr;
                        const genericErrorText = `{{ __('ui.upload_error', ['file' => '${file.name}']) }}`;

                        xhr.addEventListener('error', () => reject(genericErrorText));
                        xhr.addEventListener('abort', () => reject());
                        xhr.addEventListener('load', () => {
                            const response = xhr.response;

                            if (!response || response.error) {
                                return reject(response && response.error ? response.error.message : genericErrorText);
                            }

                            resolve({
                                default: response.url
                            });
                        });

                        if (xhr.upload) {
                            xhr.upload.addEventListener('progress', evt => {
                                if (evt.lengthComputable) {
                                    this.loader.uploadTotal = evt.total;
                                    this.loader.uploaded = evt.loaded;
                                }
                            });
                        }
                    }

                    _sendRequest(file) {
                        const data = new FormData();
                        data.append('upload', file);
                        this.xhr.send(data);
                    }
                }

                function normalizeEditorLinks(html, forceClearAllLinks = false) {
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = html || '';

                    const totalTextLength = (wrapper.textContent || '').trim().length;
                    let linkedTextLength = 0;

                    wrapper.querySelectorAll('a').forEach(link => {
                        linkedTextLength += (link.textContent || '').trim().length;
                    });

                    const linkRatio = totalTextLength > 0 ? linkedTextLength / totalTextLength : 0;
                    const looksLikeWholeArticleLink = totalTextLength > 120 && linkRatio > 0.75;

                    wrapper.querySelectorAll('a').forEach(link => {
                        const href = (link.getAttribute('href') || '').trim();
                        const hasBlockContent = !!link.querySelector('p, div, ul, ol, li, h1, h2, h3, h4, h5, h6, blockquote, table, figure, img, iframe');
                        const unsafeHref = href.toLowerCase().startsWith('javascript:');

                        if (forceClearAllLinks || looksLikeWholeArticleLink || hasBlockContent || unsafeHref || href === '') {
                            const fragment = document.createDocumentFragment();
                            while (link.firstChild) {
                                fragment.appendChild(link.firstChild);
                            }
                            link.replaceWith(fragment);
                        }
                    });

                    return wrapper.innerHTML;
                }

                function UploadAdapterPlugin(editor) {
                    editor.plugins.get('FileRepository').createUploadAdapter = loader => new UploadAdapter(loader);
                }

                const editorConfig = {
                    extraPlugins: [UploadAdapterPlugin],
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo'
                    ],
                    image: {
                        toolbar: [
                            'imageTextAlternative',
                            'toggleImageCaption',
                            'imageStyle:inline',
                            'imageStyle:block',
                            'imageStyle:side'
                        ]
                    },
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    }
                };

                function createVisualEditor() {
                    $('#editor').removeClass('font-monospace');
                    $('#editor').val(normalizeEditorLinks($('#editor').val()));

                    return ClassicEditor
                        .create(document.querySelector('#editor'), editorConfig)
                        .then(editor => {
                            wysiwygEditor = editor;
                            htmlMode = false;
                            $('#toggleHtmlMode').text('{{ __('ui.html_code') }}');
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }

                function startEditor() {
                    $('#text').hide();
                    $('#editBox').show();
                    $('#pencil').hide();

                    if (!wysiwygEditor && !htmlMode) {
                        createVisualEditor();
                    }
                }

                function switchToHtmlMode() {
                    if (!wysiwygEditor) {
                        return;
                    }

                    const editorHtml = wysiwygEditor.getData();
                    $('#editor').val(editorHtml);
                    $('#newTextHtml').val(editorHtml);

                    wysiwygEditor.destroy().then(() => {
                        wysiwygEditor = null;
                        htmlMode = true;
                        $('#editor').show().addClass('font-monospace').css('min-height', '360px');
                        $('#toggleHtmlMode').text(@json(__('ui.visual_mode')));
                    });
                }

                function switchToVisualMode() {
                    const editorHtml = $('#editor').val();
                    $('#newTextHtml').val(editorHtml);
                    htmlMode = false;
                    createVisualEditor();
                }

                $(document).ready(function() {
                    $(document).on('click touchstart', '#pencil', function(e){
                        e.preventDefault();
                        startEditor();
                    });

                    $(document).on('click touchstart', '#toggleHtmlMode', function(e){
                        e.preventDefault();

                        if (wysiwygEditor) {
                            switchToHtmlMode();
                        } else if (htmlMode) {
                            switchToVisualMode();
                        }
                    });

                    $(document).on('click touchstart', '#clearEditorLinks', function(e){
                        e.preventDefault();

                        if (!confirm(@json(__('ui.remove_all_links_confirm')))) {
                            return;
                        }

                        if (wysiwygEditor) {
                            wysiwygEditor.setData(normalizeEditorLinks(wysiwygEditor.getData(), true));
                        } else {
                            $('#editor').val(normalizeEditorLinks($('#editor').val(), true));
                        }
                    });

                    $('#formText').on('submit', function(){
                        const editorHtml = normalizeEditorLinks(wysiwygEditor ? wysiwygEditor.getData() : $('#editor').val());
                        $('#editor').val(editorHtml);
                        $('#newTextHtml').val(editorHtml);
                    });

                    $(document).on('click touchstart', '#cancelEdit', function(e){
                        e.preventDefault();
                        $('#editBox').hide();
                        $('#text').show();
                        $('#pencil').show();
                    });
                });
            </script>
    </div>
    <div class="row">
        <div class="col-md-5">

        </div>
        <div class="col-md-7 text-center">
            <hr>
            <span>{{ __('ui.published_by') }}: @if($userInfo->currname == 0){{$userInfo->name}} @else {{$userInfo->fullname}} @endif</span>
            <br>
            <span>{{ __('ui.views') }}: {{$indexText->views}}</span>
            <br>
            <?php
            date_default_timezone_set($settings->timezone); // your user's timezone
            $my_datetime= $indexText->date;
            $numMonth = date('n', strtotime($my_datetime));
            $array = app()->getLocale() === 'en'
                ? [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December']
                : [1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа', 9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'];
            ?>
            <span>{{ __('ui.last_edit') }}: <?php echo app()->getLocale() === 'en' ? date($array[$numMonth] . ' j, Y H:i', strtotime("$indexText->date Europe/Moscow")) : date('j ' . $array[$numMonth] . ', Y H:i', strtotime("$indexText->date Europe/Moscow")); ?>, {{ __('ui.timezone') }}: {{$settings->timezone}}</span>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
{!! $settings->metrika !!}
</body>
</html>

