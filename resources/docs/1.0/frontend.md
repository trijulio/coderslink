# Overview

---

- [resources/views/main.blade.php](#section-1)
- [resources/views/index.blade.php](#section-2)

Frontend blade files used in this project

---

<a name="section-1"></a>
### resources/views/main.blade.php
Main Blade Wrapper
```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test Website</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>

        <nav class="navbar navbar-dark bg-dark navbar-expand-lg  container">
          <a class="navbar-brand font-weight-bold" href="{{route('index')}}">Laravel/VueJS Test</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link text-white" href="{{route('index')}}">Gallery</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="{{route('docs')}}">Docs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="https://github.com/trijulio/coderslink" target="_blank">Github</a>
              </li>
            </ul>
            <span class="navbar-text">
              Made by: Julio Popócatl
            </span>
          </div>
        </nav>

        <!-- Page Content -->
        <div class="container" id="app">

            @yield('content')

        </div>
        <!-- /.container -->

        <script src="{{ mix('js/app.js') }}" ></script>
    </body>
</html>

```

---

<a name="section-2"></a>
### resources/views/index.blade.php
Index Blade to include VUE Component
```html
@extends('main')

@section('content')
  <file-upload-component></file-upload-component>
@endsection
```