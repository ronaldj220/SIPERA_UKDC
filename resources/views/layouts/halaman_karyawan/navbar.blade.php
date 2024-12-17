<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <!-- Hamburger Menu -->
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-menu"></span>
            </button>
        </div>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-bs-toggle="dropdown">
                    @if ($karyawan->gender == "P")
                        <img class="img-xs rounded-circle" src="{{ asset('template') }}/images/faces/face1.jpg" alt="Profile image" style="width: 40px; height: 40px;">
                    @elseif ($karyawan->gender == 'W')
                        <img class="img-xs rounded-circle" src="{{ asset('template') }}/images/faces/face24.jpg" alt="Profile image" style="width: 40px; height: 40px;">
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        @if ($karyawan->gender == "P")
                            <img class="img-xs rounded-circle" src="{{ asset('template') }}/images/faces/face1.jpg" alt="Profile image" style="width: 40px; height: 40px;">
                        @elseif ($karyawan->gender == 'W')
                            <img class="img-xs rounded-circle" src="{{ asset('template') }}/images/faces/face24.jpg" alt="Profile image" style="width: 40px; height: 40px;">
                        @endif
                        <p class="mb-1 mt-3 font-weight-semibold">{{ Auth::user()->nama }}</p>
                        <p class="fw-light text-muted mb-0">{{ Auth::user()->email }}</p>
                    </div>
                    <a class="dropdown-item" href="{{ route('pelamar.profile') }}">
                        <i class="dropdown-item-icon mdi mdi-account text-primary me-2"></i> My Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('karyawan.ubah-pwd') }}">
                        <i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> Ubah Password
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Keluar
                    </a>
                </div>
            </li>
        </ul>

        <!-- Offcanvas toggle for mobile view -->
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas" aria-controls="offcanvas" aria-expanded="false">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>