@include('layouts.halaman_karyawan.header')

<body class="with-welcome-text">
    <div class="container-scroller">
        @include('layouts.halaman_karyawan.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts.halaman_karyawan.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-lg-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Daftar Rekrutmen</h4>
                                            <p class="card-description text-center">
                                                Daftar proses pelamar kerja
                                            </p>
                                            <a href="{{ route('karyawan.recruitmen.add_recruitmen') }}"
                                                class="btn btn-rounded btn-primary"><span
                                                    class="mdi mdi-eye-plus"></span> Ajukan Lamaran</a>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            @if ($recruitmen && count($recruitmen) > 0)
                                                                @php
                                                                    $item = $recruitmen[0];
                                                                @endphp
                                                                @if ($item->status_approval == 'approved')
                                                                    <th>Nomor Dokumen</th>
                                                                @endif
                                                            @endif
                                                            <th>Pemohon</th>
                                                            <th>Tanggal Pengajuan</th>
                                                            <th>Departemen</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($recruitmen as $item)
                                                            <tr>
                                                                @if ($item->status_approval == 'approved')
                                                                    <td><a
                                                                            href="{{ route('karyawan.recruitmen.view_doc', $item->id) }}">{{ $item->no_doku }}</a>
                                                                    </td>
                                                                @endif
                                                                <td> {{ $item->pemohon }} </td>
                                                                <td> {{ date('d F Y', strtotime($item->tgl_pengajuan)) }}
                                                                </td>
                                                                <td> {{ $item->departemen }} </td>
                                                                <td class="text-center">
                                                                    @if ($item->status_approval == 'submitted')
                                                                        <label class="badge badge-danger"
                                                                            style="font-size: 1.2em">Submitted</label>
                                                                    @elseif ($item->status_approval == 'pending')
                                                                        <label class="badge badge-warning"
                                                                            style="font-size: 1.2em">Pending</label>
                                                                    @elseif ($item->status_approval == 'approved')
                                                                        <label class="badge badge-success"
                                                                            style="font-size: 1.2em">Approved</label>
                                                                    @elseif ($item->status_approval == 'rejected')
                                                                        <label class="badge badge-danger"
                                                                            style="font-size: 1.2em">Rejected</label>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                @include('layouts.halaman_karyawan.footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    @include('layouts.halaman_karyawan.script')
</body>
@include('sweetalert::alert')

</html>
