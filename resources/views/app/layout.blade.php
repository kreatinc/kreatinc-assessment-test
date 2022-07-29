<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Content Managment</title>

        <!-- Fonts -->

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
    </head>
    <body >
        

    <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
        <div class="container-fluid ">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              @auth
              <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav me-auto w-100 d-flex justify-content-center mb-2 mb-lg-0 ">
                  <li class="nav-item">
                    <a href={{  url('/') }} class="nav-link {{ (request()->is('/*')) ? 'active' : '' }}"  aria-current="page" href="#">Account</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('publish') }}" class="nav-link {{ (request()->is('publish')) ? 'active' : '' }}" href="#">Publish</a>
                  </li>
                  <li class="nav-item">
                    <a href='{{ route('connect') }}' class="nav-link {{ (request()->is('connect')) ? 'active' : '' }}" href="#">Pages</a>
                  </li>
                </ul>
              </div>
              @endauth
              @guest

              @endguest
              @auth
              <a href="{{ route('logout')}}" class="btn btn-danger btn-md">Logout</a>
              @endauth
        </div>
    </nav>
    <main class="container my-5">
         @yield('content')
    </main>
   
    {{-- javascript --}}
    {{-- JQuery plugin --}}
        <script src="https://code.jquery.com/jquery-3.6.0.slim.js" ></script>
    {{-- bootstrap plugin  --}}
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    </body>
</html>
