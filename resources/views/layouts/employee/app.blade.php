@include('layouts.employee.head')

@include('layouts.employee.header')

@include('layouts.employee.sidebar')
@include('sweetalert::alert')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        @yield('content')
    </div>
</div>
@include('layouts.employee.foot')