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
                                            <h4 class="card-title text-center">Tambah Departemen</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada saat proses rekrutmen
                                            </p>
                                            <form action="{{ route('admin.departemen.save_departemen') }}"
                                                method="post" id="myForm">
                                                @csrf
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('departemen') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Departemen"
                                                        name="departemen" value="{{ old('departemen') }}">
                                                    <label for="floatingInput">Departemen</label>
                                                </div>
                                                @error('departemen')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="form-floating">
                                                    <input type="text"
                                                        class="form-control @error('pic') is-invalid @enderror"
                                                        id="floatingPassword" placeholder="Masukkan PiC" name="pic">
                                                    <label for="floatingPassword">PiC</label>
                                                </div>
                                                @error('pic')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Submit</button>
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
