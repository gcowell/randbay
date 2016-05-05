<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Randbay</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/buyorders/create') }}">Buy</a></li>
                <li><a href="{{ url('/saleitems/create') }}">Sell</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if(auth()->guest())

                @if(!Request::is('auth/login'))
                <li><a href="{{ url('/auth/login') }}">Login</a></li>
                @endif

                @if(!Request::is('auth/register'))
                <li><a href="{{ url('/auth/register') }}">Register</a></li>
                @endif

                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
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