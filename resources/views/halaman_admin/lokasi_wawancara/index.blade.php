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
                                            <h4 class="card-title text-center">Daftar Lokasi Wawancara</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada saat pembuatan surat undangan pemanggilan tes dan wawancara
                                            </p>
                                            <a href="{{ route('admin.lokasiWawancara.addLokasiWawancara') }}"
                                                class="btn btn-rounded btn-primary"><span
                                                    class="mdi mdi-eye-plus"></span> Tambah Lokasi Wawancara</a>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>@sortablelink('ruangan', 'Ruangan')</th>
                                                            <th>@sortablelink('lokasi', 'Lokasi Wawancara')</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        @foreach ($lokasiWawancara as $item)
                                                            <tr>
                                                             <td>{{ $no++ . '.' }}</td>
                                                             <td>{{$item->ruangan}}</td>
                                                             <td>{{$item->lokasi}}</td>
                                                             <td>
                                                                 <div class="d-flex justify-content-center">
                                                    <a href="{{ route('admin.lokasiWawancara.editLokasiWawancara', $item->id) }}" class="btn btn-info">
                                                        <span>Edit</span>
        									        </a>
                                        </div>
                                                             </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @if($lokasiWawancara->count() > 0)
                                                    <div class="row">
                                                        <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                                            <div>
                                                                Showing {{ $lokasiWawancara->firstItem() }} to {{ $lokasiWawancara->lastItem() }} of {{ $lokasiWawancara->total() }} entries
                                                            </div>
                                                            {!! $lokasiWawancara->appends(Request::except('page'))->render() !!}
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center mt-4 mb-4">
                                                            <p>No entries found.</p>
                                                        </div>
                                                    </div>
                                                @endif
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