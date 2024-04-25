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
                                            <h4 class="card-title text-center">Daftar Rekrutmen</h4>
                                            <p class="card-description text-center">
                                                Daftar proses pelamar kerja
                                            </p>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>Nomor Dokumen</th>
                                                            <th>Pemohon</th>
                                                            <th>Tanggal Pengajuan</th>
                                                            <th>Departemen</th>
                                                            <th>Status</th>
                                                            @if ($recruitmen && count($recruitmen) > 0)
                                                                @php
                                                                    $item = $recruitmen[0];
                                                                @endphp
                                                                @if ($item->status_approval == 'submitted')
                                                                    <th>Aksi</th>
                                                                @elseif ($item->status_approval == 'pending')
                                                                    <th>Aksi</th>
                                                                @elseif ($item->status_approval == 'approved')
                                                                    <th>Aksi</th>
                                                                @elseif ($item->status_approval == 'rejected')
                                                                    <th>Aksi</th>
                                                                @endif
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        @foreach ($recruitmen as $item)
                                                            <tr>
                                                                <td><a
                                                                        href="{{ route('admin.recruitmen.view_recruitmen', $item->id) }}">{{ $item->no_doku }}</a>
                                                                </td>
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
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                                        @if ($item->status_approval == 'submitted')
                                                                            <a href="{{ route('admin.recruitmen.verify_recruitmen', $item->id) }}"
                                                                                class="btn btn-rounded btn-success">Verify</a>
                                                                            &nbsp;
                                                                            <a href="{{ route('admin.recruitmen.tolak_doc', $item->id) }}"
                                                                                class="btn btn-rounded btn-danger">Tolak</a>
                                                                        @elseif ($item->status_approval == 'pending')
                                                                            @if ($item->is_edited == 'true')
                                                                                <a href="{{ route('admin.recruitmen.edit_rekrutmen', $item->id) }}"
                                                                                    class="btn btn-rounded btn-info">Edit</a>
                                                                            @elseif ($item->is_edited == 'false')
                                                                                <a href="{{ route('admin.recruitmen.verify_recruitmen', $item->id) }}"
                                                                                    class="btn btn-rounded btn-warning">Setujui</a>
                                                                            @endif
                                                                        @elseif ($item->status_approval == 'approved')
                                                                            <a href="{{ route('admin.recruitmen.send_recruitmen', $item->id) }}"
                                                                                class="btn btn-rounded btn-warning">Kirim
                                                                                Email</a>
                                                                        @elseif ($item->status_approval == 'rejected')
                                                                            <a href="{{ route('admin.recruitmen.send_recruitmen', $item->id) }}"
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
