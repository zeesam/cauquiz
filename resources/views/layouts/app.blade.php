<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Quiz App | CAU Imphal</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <style>
        footer {
            position: fixed;
            height: 100px;
            bottom: 0;
            width: 100%;
            padding:20px;
        }
        .blink {
        animation: blink-animation 1s steps(5, start) infinite;
        -webkit-animation: blink-animation 1s steps(5, start) infinite;
      }
      @keyframes blink-animation {
        to {
          visibility: hidden;
        }
      }
      @-webkit-keyframes blink-animation {
        to {
          visibility: hidden;
        }
      }
    </style>
    @livewireStyles
    @livewireScripts
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div id="app">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Quiz App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{url('home')}}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('profile.edit')}}">Update Profile</a></li>
                        <li><a class="dropdown-item" href="{{url('info')}}">Info Collection</a></li>
                    </ul>
                </li>
                @if(Auth::user()->type == 'Faculty' || Auth::user()->type == 'SU')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Versions
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{url('version/1.1')}}">V-1.1(alpha)</a></li>
                        <li><a class="dropdown-item" href="{{url('version/1.2')}}">V-1.2(alpha)</a></li>
                        <li><a class="dropdown-item" href="{{url('version/2.0.1')}}">V-2.0.1(beta)</a></li>
                        <li><a class="dropdown-item" href="{{url('version/2.0.2')}}">V-2.0.2(beta)</a></li>
                        <li><a class="dropdown-item" href="{{url('version/2.1')}}">V-2.1(stable)</a></li>
                        <li><a class="dropdown-item" href="{{url('version/2.1.2')}}">V-2.1.2(Under Development)</a></li>
                    </ul>
                </li>
                @endif
            </ul>
            <a href="{{ route('logout') }}" class="d-flex btn btn-outline-danger"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>            </div>
        </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    <div class="b-example-divider"></div>

<div class="bg-dark text-secondary px-4 py-1 text-center">
  <div class="py-5">
    <h1 class="display-5 fw-bold text-white">Designed & Developed By</h1>
    <div class="col-lg-6 mx-auto">
      <p class="fs-5 mb-4">
        <span class="text-white">Er. S Govind Singh</span>
      <br>System Analyst, CAU Imphal<br>
      Copyright 2023 | Central Agricultural University Imphal</p>
    </div>
  </div>
</div>

<div class="b-example-divider mb-0"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
