<div id="header">
    <section>
        <h1><a href="{{route('staff.home.index')}}" title="先生のダッシュボード">先生のダッシュボード</a></h1>

        <div id="a-tel">
        <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @unless (Auth::guard('staff')->check())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staff.login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('staff.register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staff.register') }}">{{ __('Register') }}</a>
                </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('staff.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                    <form id="logout-form" action="{{ route('staff.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                </li>
            @endunless
            </ul>
        </div>
    </section>
</div><!-- #header -->