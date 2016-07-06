<nav class="navbar app-navbar">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Bookworm</a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            @if ( Auth::user() && isset($currentProject) )
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                @if ( $projects->isEmpty() )
                <li><a href="{{ $currentProject->url() }}">{{ $currentProject->title }}</a></li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ $currentProject->title }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><span>Change project:</span></li>
                        <li role="separator" class="divider"></li>
                        @foreach( $projects as $project )
                        <li><a href="{{ $project->url() }}">{{ $project->title }}</a></li>
                        @endforeach
                    </ul>
                </li>
                @endif
                <li><a href="{{ $currentProject->url('cases') }}">Cases</a></li>
                <li><a href="{{ $currentProject->url('board') }}">Board</a></li>
            </ul>
            @endif
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                <li><a href="{{ url('/login') }}">Login</a></li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa fa-cog"></i> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('settings/projects') }}">Projects</a></li>
                        <li><a href="{{ url('settings/users') }}">Users</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ $me->name }}
                        <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/logout') }}">Logout</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
