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
                                            <h4 class="card-title text-center">Daftar Lokasi Psikotes</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada saat pembuatan surat undangan psikotes
                                            </p>
                                            <a href="{{ route('admin.lokasi_psikotes.add_lokasi_psikotes') }}"
                                                class="btn btn-rounded btn-primary"><span
                                                    class="mdi mdi-eye-plus"></span> Tambah Lokasi Psikotes</a>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Lokasi Psikotes</th>
                                                            <th>Ruangan Psikotes</th>
                                                            <th>Alamat Psikotes</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        @foreach ($locPsikotes as $item)
                                                            <tr>
                                                             <td>{{ $no++ . '.' }}</td>
                                                             <td>{{$item->lokasi_psikotes}}</td>
                                                             <td>{{$item->ruangan_psikotes}}</td>
                                                             <td>{{$item->alamat_psikotes}}</td>
                                                             <td>
                                                                 <div class="d-flex justify-content-center">
                                                    <a href="{{ route('admin.lokasi_psikotes.edit_lokasi_psikotes', $item->id) }}" class="btn btn-info">
                                                        <span>Edit</span>
        									        </a>
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