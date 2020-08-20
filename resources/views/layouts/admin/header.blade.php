<div id="header">
    <section>
        <h1><a href="{{route('admin.home.index')}}" title="管理者のダッシュボード">管理者のダッシュボード</a></h1>

        <div id="a-tel">
        <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @unless (Auth::guard('admin')->check())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('admin.register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.register') }}">{{ __('Register') }}</a>
                </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                </li>
            @endunless
            </ul>
        </div>
    </section>
</div><!-- #header -->