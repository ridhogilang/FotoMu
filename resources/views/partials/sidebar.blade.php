<div class="app-menu">

    <!-- Brand Logo -->
    <div class="logo-box">
        <!-- Brand Logo Light -->
        <a href="index.php" class="logo-light">
            <img src="{{ asset('images/logo-light.png') }}" alt="logo" class="logo-lg">
            <img src="{{ asset('') }}images/logo-sm.png" alt="small logo" class="logo-sm">
        </a>

        <!-- Brand Logo Dark -->
        <a href="index.php" class="logo-dark">
            <img src="{{ asset('images/logo-dark.png') }}" alt="dark logo" class="logo-lg">
            <img src="{{ asset('') }}images/logo-sm.png" alt="small logo" class="logo-sm">
        </a>
    </div>

    <!-- menu-left -->
    <div class="scrollbar">

        <!-- User box -->
        <div class="user-box text-center">
            <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block"
                    data-bs-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted mb-0">Admin Head</p>
        </div>

        <!--- Menu -->
        <ul class="menu">

            <li class="menu-title">Admin FotoMu</li>

            <li class="menu-item">
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                    <span class="menu-icon"><i data-feather="airplay"></i></span>
                    <span class="menu-text"> Dashboards </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#FotoMu" data-bs-toggle="collapse" class="menu-link">
                    <span class="menu-icon"><i data-feather="camera"></i></span>
                    <span class="menu-text"> Fotomu </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="FotoMu">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="ecommerce-dashboard.php" class="menu-link">
                                <span class="menu-text">Foto Kontrol</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="ecommerce-products.php" class="menu-link">
                                <span class="menu-text">Event</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="ecommerce-product-detail.php" class="menu-link">
                                <span class="menu-text">Pendaftaran Fotografer</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="ecommerce-product-edit.php" class="menu-link">
                                <span class="menu-text">Fotografer Aktif</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item">
                <a href="#Pemesanan-Item" data-bs-toggle="collapse" class="menu-link">
                    <span class="menu-icon"><i data-feather="shopping-cart"></i></span>
                    <span class="menu-text"> Pemesanan </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="Pemesanan-Item">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="ecommerce-dashboard.php" class="menu-link">
                                <span class="menu-text">Riwayat Pemesanan</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="ecommerce-dashboard.php" class="menu-link">
                                <span class="menu-text">Jumlah Pembelian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item">
                <a href="#Pengguna" data-bs-toggle="collapse" class="menu-link">
                    <span class="menu-icon"><i data-feather="users"></i></span>
                    <span class="menu-text"> Pengguna </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="Pengguna">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="ecommerce-dashboard.php" class="menu-link">
                                <span class="menu-text">Daftar Pengguna</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="ecommerce-dashboard.php" class="menu-link">
                                <span class="menu-text">Tambah Admin</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i data-feather="settings"></i></span>
                    <span class="menu-text"> Setting </span>
                </a>
            </li>
        </ul>
        <!--- End Menu -->
        <div class="clearfix"></div>
    </div>
</div>