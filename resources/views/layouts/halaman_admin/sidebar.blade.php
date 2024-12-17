<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.beranda') }}">
                <i class="mdi mdi-home-circle menu-icon"></i>
                <span class="menu-title">Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-cog-outline"></i>
                <span class="menu-title">Setting</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <a class="nav-link" href="{{ route('admin.admin') }}">Daftar Admin</a>
                    <a class="nav-link" href="{{ route('admin.departemen') }}">Daftar Departemen</a>
                    <a class="nav-link" href="{{route('admin.lowongan')}}">Daftar Lowongan</a>
                    <a class="nav-link" href="{{ route('admin.lokasi_psikotes') }}">Lokasi Psikotes</a>
                    <a class="nav-link" href="{{ route('admin.lokasiWawancara') }}">Lokasi Wawancara</a>
                    <a class="nav-link" href="{{ route('admin.statusPegawai') }}">Status Pegawai</a>
                    <a class="nav-link" href="{{ route('admin.unitKerja') }}">Unit Kerja</a>
                    <a class="nav-link" href="{{ route('admin.pos_lamaran') }}">Posisi Lamaran</a>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.recruitmen') }}">
                <i class="mdi mdi-account-search menu-icon"></i>
                <span class="menu-title">Rekrutmen</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.psikotes') }}">
                <i class="mdi mdi-brain menu-icon"></i>
                <span class="menu-title">Psikotes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.hasil_tes') }}">
                <i class="mdi mdi-mail menu-icon"></i>
                <span class="menu-title">Surat Penerimaan</span>
            </a>
        </li>
    </ul>
</nav>
<!-- partial -->
