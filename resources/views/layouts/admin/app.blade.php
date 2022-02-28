@include('layouts.admin.head')

@include('layouts.admin.header')

@include('layouts.admin.sidebar')
@include('sweetalert::alert')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        @yield('content')
    </div>
</div>
@include('layouts.admin.foot')