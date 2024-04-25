@include('layouts.halaman_admin.header')

<body class="with-welcome-text">
    <div class="container-scroller">
        @include('layouts.halaman_admin.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts.halaman_admin.sidebar')
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
                                                Digunakan setelah rekrutmen dan psikotes dibuat (Hasil Akhir)
                                            </p>
                                            <a href="{{ route('admin.hasil_tes.add_surat_penerimaan') }}"
                                                class="btn btn-rounded btn-primary"><span
                                                    class="mdi mdi-eye-plus"></span> Tambah Data Penerimaan</a>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>Nomor Dokumen (SP)</th>
                                                            <th>Pemohon</th>
                                                            <th>Status</th>
                                                            @if ($hasil_tes && count($hasil_tes) > 0)
                                                                @php
                                                                    $item = $hasil_tes[0];
                                                                @endphp
                                                                @if ($item->status_approval == 'pending')
                                                                    <th>Aksi</th>
                                                                @elseif ($item->status_approval == 'approved')
                                                                    <th>Aksi</th>
                                                                @endif
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        @foreach ($hasil_tes as $item)
                                                            <tr>
                                                                <td><a
                                                                        href="{{ route('admin.hasil_tes.view_surat_penerimaan', $item->id) }}">{{ $item->no_doku }}</a>
                                                                </td>
                                                                <td> {{ $item->rekrutmen->pemohon }} </td>
                                                                <td class="text-center">
                                                                    @if ($item->status_approval == 'pending')
                                                                        <label class="badge badge-warning"
                                                                            style="font-size: 1.2em">Pending</label>
                                                                    @elseif ($item->status_approval == 'approved')
                                                                        <label class="badge badge-success"
                                                                            style="font-size: 1.2em">Approved</label>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                                        @if ($item->status_approval == 'pending')
                                                                            <a href="{{ route('admin.hasil_tes.acc_surat_penerimaan', $item->id) }}"
                                                                                class="btn btn-rounded btn-warning">Setujui</a>
                                                                        @elseif ($item->status_approval == 'approved')
                                                                            <a href="{{ route('admin.hasil_tes.send_surat_penerimaan', $item->id) }}"
                                                                                class="btn btn-rounded btn-warning">Kirim
                                                                                Email</a>
                                                                        @endif
                                                                    </div>
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
                @include('layouts.halaman_admin.footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    @include('layouts.halaman_admin.script')
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>
@include('sweetalert::alert')

</html>
