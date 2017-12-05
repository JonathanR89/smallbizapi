<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> SB Package Manager</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {!! Charts::styles() !!}

    <!-- Scripts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.3/pdfmake-0.1.18/dt-1.10.12/b-1.2.1/b-colvis-1.2.1/b-flash-1.2.1/b-html5-1.2.1/b-print-1.2.1/cr-1.3.2/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.3/pdfmake-0.1.18/dt-1.10.12/b-1.2.1/b-colvis-1.2.1/b-flash-1.2.1/b-html5-1.2.1/b-print-1.2.1/cr-1.3.2/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div >
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        SB Admin
                    </a>
                    @if (Auth::user())
                      <a class="navbar-brand" href="{{ route('packages') }}">
                        Packages
                      </a>
                      <a class="navbar-brand" href="{{ route('register') }}">
                        New User
                      </a>
                      <a class="navbar-brand" href="{{ route('all_vendors') }}">
                        Vendor Info
                      </a>
                      <a class="navbar-brand" href="{{ route('emails_sent') }}">
                        Dash
                      </a>
                      <a class="navbar-brand" href="{{ route('consultants') }}">
                        Consultants List
                      </a>
                      <a class="navbar-brand" href="{{  url('/consultant-questionnaire') }}">
                        Consultants
                      </a>
                      {{-- <a class="navbar-brand" href="http://qq2-admin.smallbizcrm.com/">
                        QQ2
                      </a> --}}
                      <a class="navbar-brand" href="{{  url('/question-selects') }}">
                        QQ2
                      </a>
                    @endif
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
