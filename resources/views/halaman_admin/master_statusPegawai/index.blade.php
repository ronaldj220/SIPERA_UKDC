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
                                            <h4 class="card-title text-center">Daftar Status Pegawai</h4>
                                            <p class="card-description text-center">
                                                Referensi unit kerja untuk pemanggilan tes dan wawancara dosen serta tenaga kependidikan
                                            </p>
                                            <div class='d-flex justify-content-between'>
                                                <a href="{{ route('admin.statusPegawai.addStatusPegawai') }}" class="btn btn-rounded btn-primary"><span
                                                    class="mdi mdi-eye-plus"></span> Tambah Status Pegawai</a>
                                            <div class="d-flex">
                                                    <input type='search' class="form-control" placeholder="Search Unit Kerja Here" name='q' id='search' />
                                                </div>

                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover" id="search-results">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>@sortablelink('status_pegawai', 'Status Pegawai')</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        @foreach ($statusPegawai as $item)
                                                            <tr>
                                                                <td>{{ $no++ . '.' }}</td>
                                                                <td> {{ $item->nama_status }} </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                            <a href="{{ route('admin.statusPegawai.editStatusPegawai', $item->id) }}" class="btn btn-info">
                                                                                                <span>Edit</span>
                                                									        </a>
                                                                    </div>
                                                                    
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @if($statusPegawai->count() > 0)
                                                    <div class="row">
                                                        <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                                            <div>
                                                                Showing {{ $statusPegawai->firstItem() }} to {{ $statusPegawai->lastItem() }} of {{ $statusPegawai->total() }} entries
                                                            </div>
                                                            <div>
                                                                {!! $statusPegawai->appends(Request::except('page'))->render() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div class="col-lg-12 mt-4 mb-4 text-center">
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
        $(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val();
            $.ajax({
                url: "{{ route('admin.statusPegawai.search') }}", // Use the search route
                type: "GET",
                data: {
                    q: query // Pass the query as 'q' parameter
                },
                success: function(data) {
                    // Clear existing results
                    $('#search-results tbody').empty();
                    
                    // Append new results
                    if (data.data.length > 0) {
                        data.data.forEach(function(item, index) {
                            $('#search-results tbody').append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.nama_status}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ url('admin/lowongan/edit') }}/${item.id}" class="btn btn-info">
                                                <span>Edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#search-results tbody').append('<tr><td colspan="6" class="text-center">No entries found.</td></tr>');
                    }
                }
            });
        });
    });
    </script>
</body>
@include('sweetalert::alert')

</html>
