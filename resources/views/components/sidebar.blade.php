<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mb-3">
            <h6 class="mt-4"><a href="{{ url('dashboard') }}">Sistem Keuangan <br>CV Berkah Makmur</a></h6>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('dashboard') }}">
                <img alt="image"
                    src="{{ asset('img/logo.png') }}"
                    style="max-width: 50px; max-heigth: 50px;">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item {{ Request::is('dashboard')? 'active' : '' }}">
                <a href="{{ url('dashboard') }}"
                    class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Kelola Transaksi</li>
            <li class="nav-item {{ Request::is('tmasuk')? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('tmasuk') }}"><i class="fas fa-money-bill-trend-up"></i> <span>Transaksi Masuk</span></a>
            </li>
            <li class="nav-item {{ Request::is('tkeluar')? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('tkeluar') }}"><i class="fas fa-basket-shopping"></i> <span>Transaksi Keluar</span></a>
            </li>
            <li class="nav-item dropdown {{ (Request::is('sampah-masuk') || Request::is('sampah-keluar')) ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="far fa-trash-can"></i> <span>Sampah</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('sampah-masuk') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('sampah-masuk') }}">Sampah Transaksi Masuk</a>
                    </li>
                    <li class="{{ Request::is('sampah-keluar') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('sampah-keluar') }}">Sampah Transaksi Keluar</a>
                    </li>
                </ul>
            </li>
            @can('pimpinan')
            <li class="menu-header">Fitur Lainnya</li>
            <li class="nav-item {{ Request::is('label')? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('label') }}"><i class="fas fa-tag"></i> <span>Label Transaksi</span></a>
            </li>
            <li class="nav-item {{ Request::is('download')? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('download') }}"><i class="fas fa-file-arrow-down"></i> <span>Laporan</span></a>
            </li>
            <li class="nav-item {{ Request::is('makun')? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('makun') }}"><i class="far fa-user"></i> <span>Manajemen Akun</span></a>
            </li>
            @endcan
        </ul>

        <div class="hide-sidebar-mini mt-3 mb-3 p-3">
            <form action="/logout" method="post" id="sidebar_logout">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg btn-block btn-icon-split">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>
</div>
