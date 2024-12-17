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
                                <div class="col-lg-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Tambah Lokasi Wawancara</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada saat pembuatan surat undangan pemanggilan tes dan wawancara
                                            </p>
                                            <form action="{{ route('admin.lokasiWawancara.saveLokasiWawancara') }}"
                                                method="POST" id="myForm">
                                                @csrf
                                                <div class="form-floating mb-3">
                                                  <input type="text" class="form-control @error('ruangan_wawancara') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name='ruangan_wawancara'>
                                                  @error('ruangan_wawancara')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                  <label for="floatingInput">Ruangan Wawancara</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                  <input type="text" class="form-control @error('lokasi_wawancara') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name='lokasi_wawancara'>
                                                  <label for="floatingInput">Lokasi Wawancara</label>
                                                </div>
                                                @error('lokasi_wawancara')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                            <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Tambahkan Lokasi Wawancara</button>
                                                </div>
                                            </form>
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
        document.getElementById('submitBtn').addEventListener('click', function() {
            Swal.fire({
                title: "Do you want to save the changes?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    document.getElementById('myForm').submit();
                }
            });
        });
    </script>
</body>

</html>
