<div class="header">
    <div class="container">
        <div class="header-left">
            <a href="/" class="logo"><span></span> Download</a>
            <a href="" id="menuShow" class="header-menu-icon d-lg-none"><span></span></a>
        </div><!-- header-left -->
        <div class="d-flex m-5" style="width: 80%">
            <div class="header-menu">
                <div class="header-menu-header">
                    <a href="/" class="logo"><span></span> Download</a>
                    <a href="" class="close">&times;</a>
                </div><!-- header-menu-header -->
                <ul class="nav">
                    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="/" class="nav-link"><i class="typcn typcn-chart-area-outline"></i>
                            Dashboard</a>
                    </li>
                    <li class="nav-item dropdown {{ request()->routeIs('download.*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown">
                            <i class="typcn typcn-document"></i>
                            Download
                        </a>
                        <ul class="dropdown-menu mt-2 mt-md-4" aria-labelledby="navbarDropdown" data-bs-popper="none">
                            <li class="{{ request()->routeIs('download.data-upload') ? 'active' : '' }}"><a class="dropdown-item" href="{{ route('download.data-upload') }}">Data Upload</a></li>
                            <li class="{{ request()->routeIs('download.suppression-upload') ? 'active' : '' }}"><a class="dropdown-item" href="{{ route('download.suppression-upload') }}">Suppression Upload</a></li>
                            <li class="{{ request()->routeIs('download.data-download') ? 'active' : '' }}"><a class="dropdown-item" href="{{ route('download.data-download') }}">Data Download</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- header-menu -->
        </div>
        <div class="header-right" style="width: 100px;">
            <!-- Right side menu -->
            <ul class="nav">
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"><i class="typcn typcn-power-outline"></i>
                        Logout</a>
                </li>
            </ul>
        </div><!-- header-right -->
    </div><!-- container -->
</div><!-- header -->
