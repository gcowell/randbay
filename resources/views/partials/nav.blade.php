<nav class="navbar navbar-default" id="cssmenu">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li><a id="navbar-brand" href="{{ url('/') }}">X</a></li>
                <li><a href="{{ url('/buyorders/create') }}">Buy</a></li>
                <li><a href="{{ url('/saleitems/create') }}">Sell</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if(auth()->guest())

                @if(!Request::is('auth/login'))
                <li><a id="login-link" href="{{ url('/auth/login') }}">Login</a></li>
                @endif

                @if(!Request::is('auth/register'))
                <li><a id="register-link" href="{{ url('/auth/register') }}">Register</a></li>
                @endif

                @else
                <li><a href="{{ url('/users/dashboard') }}"><img id="notification-icon" src="/img/notify-no.png"></a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle-custom" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu-custom" role="menu">
                        <li><a href="{{ url('/users/dashboard') }}">My Dashboard</a></li>
                        <li><a href="{{ url('/saleitems') }}">My Saleitems</a></li>
                        <li><a href="{{ url('/transactions') }}">My Transactions</a></li>
                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                    </ul>
                </li>

                @endif

            </ul>
        </div>
    </div>
</nav>


