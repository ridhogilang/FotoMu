<div class="navbar-custom">
    <div class="topbar">
        <div class="topbar-menu d-flex align-items-center gap-1">

            <!-- Topbar Brand Logo -->
            <div class="logo-box">
                <!-- Brand Logo Light -->
                <a href="{{ route('user.produk') }}" class="logo-light">
                    <img src="{{ asset('images/logo-light.png') }}" alt="logo" class="logo-lg">
                    <img src="{{ asset('') }}images/logo-sm.png" alt="small logo" class="logo-sm">
                </a>

                <!-- Brand Logo Dark -->
                <a href="{{ route('user.produk') }}" class="logo-dark">
                    <img src="{{ asset('images/logo-dark.png') }}" alt="dark logo" class="logo-lg">
                    <img src="{{ asset('') }}images/logo-sm.png" alt="small logo" class="logo-sm">
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>

        <ul class="topbar-menu d-flex align-items-center">
            <!-- Topbar Search Form -->
            @php
                // Check if the authenticated user is already in DaftarFotografer
                $isFotografer = \App\Models\DaftarFotografer::where('user_id', Auth::id())->exists();
            @endphp

            @if (!$isFotografer)
                <li class="app-search dropdown me-3 d-none d-lg-block">
                    <a href="{{ route('user.upgrade') }}" class="btn btn-info rounded-pill waves-effect waves-light">
                        <i class="mdi mdi-camera me-1"></i> Become Fotografer
                    </a>
                </li>
            @endif
            <!-- Fullscreen Button -->
            <li class="d-none d-md-inline-block">
                <a class="nav-link waves-effect waves-light" href="" data-toggle="fullscreen">
                    <i class="fe-maximize font-22"></i>
                </a>
            </li>

            <!-- Search Dropdown (for Mobile/Tablet) -->
            <li class="dropdown d-lg-none">
                <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" data-bs-toggle="dropdown"
                    href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ri-search-line font-22"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                    <form class="p-3">
                        <input type="search" class="form-control" placeholder="Search ..."
                            aria-label="Recipient's username">
                    </form>
                </div>
            </li>

            <!-- Notofication dropdown -->
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" data-bs-toggle="dropdown"
                    href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="fe-shopping-cart font-22"></i>
                    @php
                        $CartCount = Auth::user()->cart()->count();
                        $cartItems = Auth::user()->cart;
                    @endphp
                    <span class="badge bg-danger rounded-circle noti-icon-badge">{{ $CartCount }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                    <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-16 fw-semibold"> Cart</h6>
                            </div>
                        </div>
                    </div>

                    <div class="px-1" style="max-height: 300px;" data-simplebar>

                        <h5 class="text-muted font-13 fw-normal mt-2"></h5>
                        @foreach ($cartItems as $cart)
                            <a href="javascript:void(0);"
                                class="dropdown-item p-0 notify-item card unread-noti shadow-none mb-1">
                                <div class="card-body">
                                    <span class="float-end noti-close-btn text-muted" id="close-btn-{{ $cart->id }}"
                                        data-id="{{ $cart->id }}"><i class="mdi mdi-close"></i></span>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="notify-icon bg-primary">
                                                <img src="{{ Storage::url($cart->foto->fotowatermark) }}"
                                                    alt="Icon" style="width: 40px; height: 40px;">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 text-truncate ms-2">
                                            <h5 class="noti-item-title fw-semibold font-14">
                                                {{ $cart->foto->event->event }} <small
                                                    class="fw-normal text-muted ms-1">1 min ago</small></h5>
                                            <small class="noti-item-subtitle text-muted">Rp.
                                                {{ number_format($cart->foto->harga, 0, ',', '.') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                        <div class="text-center">
                            <i class="mdi mdi-dots-circle mdi-spin text-muted h3 mt-0"></i>
                        </div>
                    </div>

                    <!-- All-->
                    <a href="{{ route('user.cart') }}"
                        class="dropdown-item text-center text-primary notify-item border-top border-light py-2">
                        View Cart
                    </a>

                </div>
            </li>
            {{-- Wishlist Icon --}}
            <li class="notification-list">
                <a class="nav-link waves-effect waves-light" href="#">
                    <i class="fe-heart font-22"></i>
                    @php
                        $wishlistCount = Auth::user()->wishlist()->count();
                    @endphp

                    @if ($wishlistCount > 0)
                        <span class="badge bg-danger rounded-circle noti-icon-badge"
                            id="wishlist-count">{{ $wishlistCount }}</span>
                    @endif
                </a>
            </li>

            <!-- Light/Dark Mode Toggle Button -->
            <li class="d-none d-sm-inline-block">
                <div class="nav-link waves-effect waves-light" id="light-dark-mode">
                    <i class="ri-moon-line font-22"></i>
                </div>
            </li>

            <!-- User Dropdown -->
            <li class="dropdown">
                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
                    href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('iconrobot/user/user1.png') }}" alt="user-image" class="rounded-circle">
                    <span class="ms-1 d-none d-md-inline-block">
                        {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                    <!-- item-->
                    <a href="{{ route('user.profil') }}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>Profil</span>
                    </a>

                    <a href="{{ route('user.konten-terhapus') }}" class="dropdown-item notify-item">
                        <i class="fe-slash"></i>
                        <span>FotoMu Terhapus</span>
                    </a>

                    <a href="{{ route('user.wishlist') }}" class="dropdown-item notify-item">
                        <i class="fe-heart"></i>
                        <span>Favorit FotoMu</span>
                    </a>

                    <a href="{{ route('user.download') }}" class="dropdown-item notify-item">
                        <i class="fe-download"></i>
                        <span>Download FotoMu</span>
                    </a>

                    <!-- item-->
                    <a href="{{ route('user.robomu') }}" class="dropdown-item notify-item">
                        <i class="mdi mdi-robot-love-outline"></i>
                        <span>RoboMu</span>
                    </a>

                    @if (\App\Models\Fotografer::where('user_id', Auth::id())->exists())
                        <a href="{{ route('foto.dashboard') }}" class="dropdown-item notify-item">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span>Dashboard Fotografer</span>
                        </a>
                    @endif


                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <!-- Tautan Logout -->
                    <a href="javascript:void(0);" class="dropdown-item notify-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fe-log-out"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
