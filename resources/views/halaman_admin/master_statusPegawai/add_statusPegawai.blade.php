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
                                            <h4 class="card-title text-center">Tambah Status Pegawai</h4>
                                            <p class="card-description text-center">
                                                Referensi unit kerja untuk pemanggilan tes dan wawancara dosen serta tenaga kependidikan
                                            </p>
                                            <form action="{{ route('admin.statusPegawai.saveStatusPegawai') }}"
                                                method="POST" id="myForm">
                                                @csrf
                                                <div class="form-floating mb-3 mt-5">
                                                  <input type="text" class="form-control @error('status_pegawai') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name="status_pegawai" value="{{ old('status_pegawai') }}">
                                                @error('status_pegawai')
                                                    <p style="color: red;" class="mt-1">* {{$message}}</p>
                                                @enderror
                                                  <label for="floatingInput">Status Pegawai</label>
                                            </div>
                                            
                                            <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Ajukan Status Pegawai</button>
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
