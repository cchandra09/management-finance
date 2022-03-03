@include('layouts.management.head')

@include('layouts.management.header')

@include('layouts.management.sidebar')
@include('sweetalert::alert')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        @yield('content')
    </div>
</div>
@include('layouts.management.foot')