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
                                            <h4 class="card-title text-center">Daftar Lowongan</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada informasi lowongan yang dibuka
                                            </p>
                                            <form id="search-form" class='d-flex justify-content-between'>
                                                <a href="{{ route('admin.lowongan.add_lowongan') }}"
                                                class="btn btn-rounded btn-primary"><span
                                                    class="mdi mdi-eye-plus"></span> Tambah Lowongan
                                            </a>
                                                <div class="d-flex">
                                                    <input type='search' class="form-control" placeholder="Search Lowongan Here" name='q' id='search' />
                                                </div>
                                            </form>
                                            <div class="table-responsive" id="search-results">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>Lowongan</th>
                                                            <th>@sortablelink('name_lowongan', 'Nama Lowongan')</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        @foreach ($lowongan as $item)
                                                            <tr>
                                                            <td>
                                                                <div style="position: relative; display: inline-block;">
    <!-- Gambar Lowongan -->
    <img src="data:image/jpeg;base64,{{ $item->img_base_64 }}" alt="Poster Lowongan" style="width:300px;height:450px; border-radius: 0%;">
    
    @if($item->link_lowongan)
        <!-- QR Code di dalam gambar -->
        <div style="position: absolute; top: 325px; left: 20px;">
            {!! DNS2D::getBarcodeHTML("$item->link_lowongan", "QRCODE", 5, 5) !!}
        </div>
    @else
        <div style="position: absolute; top: 330px; left: 50px;">
            <a class="btn btn-info" href="{{route('admin.lowongan.generateQRCode',$item->id)}}">
                Generate QR Code
            </a>
        </div>
    @endif
</div>
                                                            </td>
                                                              <td>{{$item->name_lowongan}}</td>
                                                             </td>
                                                             <td>
                                                                 <div class="d-flex justify-content-center">
                                                                     <!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#modalView{{ $item->id }}">
  <span class="mdi mdi-eye"></span>
</button>

<!-- Modal -->
<div class="modal fade" id="modalView{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalLabel{{ $item->id }}">Informasi Lowongan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table-borderless" style="width:100%">
    <tr>
        <td style="padding-right: 5px;">Dibuat sejak</td>
        <td style="padding-right: 5px;">:</td>
        <td>{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY') }}</td>
    </tr>
    <tr>
        <td style="padding-right: 5px;">Kedaluwarsa</td>
        <td style="padding-right: 5px;">:</td>
        <td>{{ \Carbon\Carbon::parse($item->expired_at)->isoFormat('D MMMM YYYY') }}</td>
    </tr>
</table>
<!-- Deskripsi Pekerjaan di bawah tabel -->
    <div style="margin-top: 20px;">
          <strong>Deskripsi Pekerjaan:</strong>
          <p>{!! $item->description !!}</p>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <a href="{{ route('admin.lowongan.edit_lowongan', $item->id) }}" class="btn btn-info"><span>Edit</span></a>
        <!-- Tombol Delete -->
        <button class="btn btn-danger btn-rounded ml-2 delete-btn" data-id="{{ $item->id }}">
            <span>Delete</span>
        </button>
      </div>
    </div>
  </div>
</div>
                                                                     
                                                                 </div>
                                                             </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @if ($lowongan->count() > 0)
                                                    <div class="row">
                                                        <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                                            <div>
                                                                Showing {{ $lowongan->firstItem() }} to {{ $lowongan->lastItem() }} of {{ $lowongan->total() }} entries
                                                            </div>
                                                            <div>
                                                                {!! $lowongan->appends(Request::except('page'))->render() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center mt-3 mb-3">
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
        
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();
                $.ajax({
                    url: "{{ route('admin.lowongan.search') }}", // Use the search route
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
                                        <td><img src="data:image/jpeg;base64,${item.img_base_64}" alt="Poster Lowongan" style="width:300px;height:300px; border-radius: 0%;"></td>
                                        <td>${item.name_lowongan}</td>
                                        <td>${item.created_at}</td>
                                        <td>${item.expired_at}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ url('admin/lowongan/edit_lowongan') }}/${item.id}" class="btn btn-info">
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
                        url: `/admin/lowongan/delete_lowongan/${lowonganId}`, // URL endpoint
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