@include('layouts.halaman_admin.header')

<meta name="csrf-token" content="{{ csrf_token() }}">


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
                                            <h4 class="card-title text-center">Daftar Unit Kerja</h4>
                                            <p class="card-description text-center">
                                                Referensi unit kerja untuk surat pemanggilan tes dan wawancara
                                            </p>
                                            <div class='d-flex justify-content-between'>
                                                <a href="{{ route('admin.unitKerja.addUnitKerja') }}" class="btn btn-rounded btn-primary"><span
                                                    class="mdi mdi-eye-plus"></span> Tambah Unit Kerja</a>
                                            <div class="d-flex">
                                                    <input type='search' class="form-control" placeholder="Search Unit Kerja Here" name='q' id='search' />
                                                </div>

                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover" id="search-results">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>@sortablelink('nama_unit_kerja', 'Unit Kerja')</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        @foreach ($unitKerja as $item)
                                                            <tr>
                                                                <td>{{ $no++ . '.' }}</td>
                                                                <td> {{ $item->nama_unit_kerja }} </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                            <a href="{{ route('admin.unitKerja.editUnitKerja', $item->id) }}" class="btn btn-info">
                                                                                                <span>Edit</span>
                                                									        </a>
                                                									        &nbsp;
                                                            <button class="btn btn-danger btn-rounded ml-2 delete-btn" data-id="{{ $item->id }}">
            <span>Delete</span>
        </button>
                                                                    </div>
                                                                    
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @if($unitKerja->count() > 0)
                                                    <div class="row">
                                                        <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                                            <div class="mt-2">
                                                                Showing {{ $unitKerja->firstItem() }} to {{ $unitKerja->lastItem() }} of {{ $unitKerja->total() }} entries
                                                            </div>
                                                            <div>
                                                                {!! $unitKerja->appends(Request::except('page'))->render() !!}
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
                url: "{{ route('admin.unitKerja.search') }}", // Use the search route
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
                                    <td>${item.nama_unit_kerja}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ url('admin/lowongan/edit') }}/${item.id}" class="btn btn-info">
                                                <span>Edit</span>
                                            </a>
                                            &nbsp;
                                            <button class="btn btn-danger btn-rounded ml-2 delete-btn" data-id="${item.id}">
            <span>Delete</span>
        </button>
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
    
    $(document).on('click', '.delete-btn', function() {
            let lowonganId = $(this).data('id'); // Ambil ID lowongan
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/unitKerja/deleteUnitKerja/${lowonganId}`, // URL endpoint
                        type: "POST",
                        data: {
                            _method: 'DELETE', // Laravel memerlukan _method untuk metode DELETE
                            _token: "{{ csrf_token() }}" // Token CSRF untuk otentikasi
                        },
                        success: function(response) {
                            Swal.fire("Berhasil!", response.message, "success").then(() => {
                                window.location.reload(); // Reload halaman untuk memperbarui data
                            });
                        },
                        error: function(xhr) {
                            // Tangani kesalahan
                            Swal.fire(
                                "Gagal!",
                                xhr.responseJSON?.message || "Terjadi kesalahan saat menghapus data.",
                                "error"
                            );
                        }
                    });
                }
            });
        });
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
@include('sweetalert::alert')

</html>
