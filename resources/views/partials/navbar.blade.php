<div class="header">
    <div class="container">
        <div class="header-left">
            <a href="/" class="logo"><span></span> Download</a>
            <a href="" id="menuShow" class="header-menu-icon d-lg-none"><span></span></a>
        </div><!-- header-left -->
        <div class="d-flex w-100 m-5">
            <div class="header-menu">
                <div class="header-menu-header">
                    <a href="/" class="logo"><span></span> Download</a>
                    <a href="" class="close">&times;</a>
                </div><!-- header-menu-header -->
                <ul class="nav">
                    <li class="nav-item active show">
                        <a href="/" class="nav-link"><i class="typcn typcn-chart-area-outline"></i>
                            Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown">
                            <i class="typcn typcn-document"></i>
                            Download
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" data-bs-popper="none">
                            <li><a class="dropdown-item" href="{{ route('download.data-upload') }}">Data Upload</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- header-menu -->
        </div>
        <div class="header-right">
            <!-- Right side menu -->
        </div><!-- header-right -->
    </div><!-- container -->
</div><!-- header -->
