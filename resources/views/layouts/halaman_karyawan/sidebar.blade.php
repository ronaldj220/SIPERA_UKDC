<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.beranda') }}">
                <i class="mdi mdi-home-circle menu-icon"></i>
                <span class="menu-title">Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.recruitmen') }}">
                <i class="mdi mdi-account-search menu-icon"></i>
                <span class="menu-title">Rekrutmen</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pelamar.psikotes') }}">
                <i class="mdi mdi-brain menu-icon"></i>
                <span class="menu-title">Psikotes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.surat_penerimaan') }}">
                <i class="mdi mdi-mail menu-icon"></i>
                <span class="menu-title">Surat Penerimaan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link"
                href="{{ env('GOOGLE_DRIVE_USER_GUIDE') }}">
                <i class="mdi mdi-account-question menu-icon"></i>
                <span class="menu-title"><i>User Guide</i></span>
            </a>
        </li>
    </ul>
</nav>
<!-- partial -->
