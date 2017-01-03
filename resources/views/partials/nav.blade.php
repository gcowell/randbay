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

        </div>
    </div>
</nav>


