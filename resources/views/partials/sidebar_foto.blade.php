<div class="app-menu">
    <div class="logo-box">
        <a href="{{ route('foto.dashboard') }}" class="logo-light">
            <img src="assets/images/logo-light.png" alt="logo" class="logo-lg">
            <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
        </a>
        <a href="{{ route('foto.dashboard') }}" class="logo-dark">
            <img src="assets/images/logo-dark.png" alt="dark logo" class="logo-lg">
            <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
        </a>
    </div>
    <div class="scrollbar">
        <ul class="menu" style="margin-right: 510px;">
            <li class="menu-item">
                <a href="{{ route('foto.dashboard') }}" class="menu-link">
                    <span class="menu-icon"><i data-feather="airplay"></i></span>
                    <span class="menu-text"> Dashboard </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('foto.tree') }}" class="menu-link">
                    <span class="menu-icon"><i data-feather="map"></i></span>
                    <span class="menu-text"> FotoMu Tree </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#menuApps" data-bs-toggle="collapse" class="menu-link">
                    <span class="menu-icon"><i data-feather="aperture"></i></span>
                    <span class="menu-text"> Unggahan </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="menuApps">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="{{ route('foto.upload') }}" class="menu-link">
                                <span class="menu-icon"><i data-feather="calendar"></i></span>
                                <span class="menu-text"> Unggah Foto </span>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{ route('foto.filemanager') }}" class="menu-link">
                                <span class="menu-icon"><i data-feather="message-square"></i></span>
                                <span class="menu-text"> File Manager </span>
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
                            <a href="{{ route('foto.profil') }}" class="menu-link">
                                <span class="menu-icon"><i data-feather="user"></i></span>
                                <span class="menu-text"> Profil </span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('foto.pembayaran') }}" class="menu-link">
                                <span class="menu-icon"><i data-feather="dollar-sign"></i></span>
                                <span class="menu-text"> Pembayaran </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>