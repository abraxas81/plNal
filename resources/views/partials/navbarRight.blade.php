<ul class="nav navbar-nav navbar-right">
    @if (Auth::guest())
        <li><a href="{{ url('/auth/login') }}"><i class="glyphicon glyphicon-log-out"></i> Login</a></li>
    <!--<li><a href="{{ url('/auth/register') }}">Register</a></li>-->
    @else
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="glyphicon glyphicon-user"></i> {{ Auth::user()->name }} <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ url('/auth/logout') }}"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                <li><a id="postavkeOperatera" href="#" data-toggle="modal" data-target="#PostavkeOperatera" data-action="{{url('operateri/operateri/'.Auth::user()->id)}}"><i class="glyphicon glyphicon-cog"></i> Postavke</a></li>
            </ul>
        </li>
    @endif
</ul>