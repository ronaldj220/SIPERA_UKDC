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
                                            <h4 class="card-title text-center">Daftar Surat Penerimaan</h4>
                                            <p class="card-description text-center">
                                                Digunakan setelah rekrutmen dan psikotes dibuat(Hasil Akhir)
                                            </p>

                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            @if ($hasil_tes && count($hasil_tes) > 0)
                                                                @php
                                                                    $item = $hasil_tes[0];
                                                                @endphp
                                                                @if ($item->status_approval == 'approved')
                                                                    <th>Nomor Dokumen</th>
                                                                @endif
                                                            @endif
                                                            <th>Pemohon</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hasil_tes as $item)
                                                            <tr>
                                                                @if ($item->status_approval == 'approved')
                                                                    <td><a
                                                                            href="{{ route('pelamar.psikotes.view_psikotes', $item->id) }}">{{ $item->no_doku_psikotes }}</a>
                                                                    </td>
                                                                @endif
                                                                <td> {{ $item->rekrutmen->pemohon }} </td>
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
