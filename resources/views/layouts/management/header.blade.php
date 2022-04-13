<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu ficon"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            @yield('notification')
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span class="user-name font-weight-bolder">{{Auth::user()->name;}}</span><span class="user-status">{{Auth::user()->role_name;}}</span></div><span class="avatar"><img class="round" src="{{!empty(Auth::user()->photo_profile) ? asset('images/'.Auth::user()->photo_profile) : 'https://cdn-icons-png.flaticon.com/512/1946/1946429.png'}}" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user"><a class="dropdown-item" href="{{route('management.profile')}}"><i class="mr-50" data-feather="user"></i> Profile</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item"><i class="mr-50" data-feather="power"></i> Logout</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>


