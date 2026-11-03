<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <meta name="debug-locale" content="{{ app()->getLocale() }}">
    <meta name="debug-translation" content="{{ __('titles.login') }}">

    @vite('resources/css/admin/app.css')
</head>

<body>
    <div class="application" id="application" v-cloak>
        <div class="application__structure application__structure--primary">
            @include('admin.partials.header')
            @include('admin.partials.aside')
            <main class="main" id="main">
                @yield('content')
            </main>
            @if(session('notification'))
            <notification :heading="{{json_encode(session('notification')['heading'])}}"
                :text="{{json_encode(session('notification')['text'])}}"
                :type="{{json_encode(session('notification')['type'])}}"></notification>
            @endif
        </div>
    </div>

    @vite('resources/js/admin/app.js')

</body>

</html>