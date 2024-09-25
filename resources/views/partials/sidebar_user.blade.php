<div class="app-menu">
    <div class="logo-box">
        <a href="index.php" class="logo-light">
            <img src="assets/images/logo-light.png" alt="logo" class="logo-lg">
            <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
        </a>
        <a href="index.php" class="logo-dark">
            <img src="assets/images/logo-dark.png" alt="dark logo" class="logo-lg">
            <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
        </a>
    </div>

    <div class="scrollbar">
        <ul class="menu ml-3" style="margin-right: 510px;">
            <li class="menu-item">
                <a href="{{ route('user.produk') }}" class="menu-link">
                    <span class="menu-icon"><i data-feather="camera"></i></span>
                    <span class="menu-text">FotoMu </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('event.tree') }}" class="menu-link">
                    <span class="menu-icon"><i data-feather="map"></i></span>
                    <span class="menu-text"> FotoMu Tree </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#menuComponents" data-bs-toggle="collapse" class="menu-link">
                    <span class="menu-icon"><i data-feather="shopping-bag"></i></span>
                    <span class="menu-text"> Pemesanan </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="menuComponents">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="{{ route('user.pesanan') }}" class="menu-link">
                                <span class="menu-icon"><i data-feather="trello"></i></span>
                                <span class="menu-text"> Riwayat Pemesanan </span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('user.cart') }}" class="menu-link">
                                <span class="menu-icon"><i data-feather="shopping-cart"></i></span>
                                <span class="menu-text"> Cart </span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="widgets.php" class="menu-link">
                                <span class="menu-icon"><i data-feather="download"></i></span>
                                <span class="menu-text"> Download FotoMu </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item">
                <a href="#menuComponents" data-bs-toggle="collapse" class="menu-link">
                    <span class="menu-icon"><i data-feather="settings"></i></span>
                    <span class="menu-text"> Account </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="menuComponents">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="{{ route('user.profil') }}" class="menu-link">
                                <span class="menu-icon"><i data-feather="user"></i></span>
                                <span class="menu-text"> Profil </span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('user.robomu') }}" class="menu-link">
                                <span class="menu-icon"><i class="mdi mdi-robot-love-outline"></i></span>
                                <span class="menu-text"> RoboMu </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
