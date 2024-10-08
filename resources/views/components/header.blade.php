<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#"
                    data-toggle="sidebar"
                    class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#"
                data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                @if (!empty(auth()->user()->image))
                    <img alt="image" id="foto-header"
                    src="{{ asset('storage/' . auth()->user()->image) }}"
                    class="rounded-circle mr-1">
                @else
                    <img alt="image" id="foto-header"
                    src="{{ asset('img/avatar.png') }}"
                    class="rounded-circle mr-1">
                @endif
                <div class="d-sm-none d-lg-inline-block" id="name-header">Hi, {{ Auth::check() ? auth()->user()->name : 'UserNotLoginYet' }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="/profile" class="dropdown-item has-icon"> <i class="far fa-user"></i> Profile</a>
                <form action="/logout" method="post" id="header_logout">
                    @csrf
                    <a href="javascript:{}" onclick="document.getElementById('header_logout').submit();"
                        class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>
