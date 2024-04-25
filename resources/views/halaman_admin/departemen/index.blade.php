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
                                            <h4 class="card-title text-center">Daftar Departemen</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada saat proses rekrutmen
                                            </p>
                                            <a href="{{ route('admin.departemen.add_departemen') }}"
                                                class="btn btn-rounded btn-primary"><span
                                                    class="mdi mdi-eye-plus"></span> Tambah Departemen</a>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Departemen</th>
                                                            @if ($departemen && count($departemen) > 0)
                                                                @php
                                                                    $item = $departemen[0];
                                                                @endphp
                                                                @if ($item->PIC)
                                                                    <th>PiC</th>
                                                                @endif
                                                            @endif
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        @foreach ($departemen as $item)
                                                            <tr>
                                                                <td>{{ $no++ . '.' }}</td>
                                                                <td> {{ $item->departemen }} </td>
                                                                @if ($item->PIC)
                                                                    <td> {{ $item->PIC }} </td>
                                                                @endif
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                                        <a id="hapusBtn"
                                                                            class="btn btn-rounded btn-outline-warning"
                                                                            data-id="{{ $item->id }}"><span
                                                                                class="mdi mdi-delete-circle"></span>&nbsp;
                                                                            Hapus</a>
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
        document.getElementById('hapusBtn').addEventListener('click', function(event) {
            var dataId = this.getAttribute('data-id');
            // console.log(dataId);
            event
        .preventDefault(); // Mencegah aksi default tombol (misalnya, pengiriman formulir atau navigasi link)

            Swal.fire({
                title: 'Yakin akan menghapus data?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'departemen/hapus_departemen/' + dataId +
                    ''; // Arahkan ke halaman hapus_data jika disetujui
                }
            });
        });
    </script>
</body>
@include('sweetalert::alert')

</html>
