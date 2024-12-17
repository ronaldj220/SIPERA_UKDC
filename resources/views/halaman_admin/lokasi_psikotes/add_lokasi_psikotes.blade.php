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
                                            <h4 class="card-title text-center">Tambah Lokasi Psikotes</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada saat pembuatan surat undangan psikotes
                                            </p>
                                            <form action="{{ route('admin.lokasi_psikotes.save_lokasi_psikotes') }}"
                                                method="POST" id="myForm">
                                                @csrf
                                                <div class="form-floating mb-3">
                                                  <input type="text" class="form-control @error('lokasi_psikotes') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name='lokasi_psikotes'>
                                                  @error('lokasi_psikotes')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                  <label for="floatingInput">Lokasi Psikotes</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                  <input type="text" class="form-control @error('ruangan_psikotes') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name='ruangan_psikotes'>
                                                  <label for="floatingInput">Ruangan Psikotes</label>
                                                </div>
                                                @error('ruangan_psikotes')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="form-floating mb-3">
                                                  <input type="text" class="form-control @error('alamat_psikotes') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name='alamat_psikotes'>
                                                  <label for="floatingInput">Alamat Psikotes</label>
                                                </div>
                                                @error('alamat_psikotes')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                            <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Tambahkan Lokasi Psikotes</button>
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
