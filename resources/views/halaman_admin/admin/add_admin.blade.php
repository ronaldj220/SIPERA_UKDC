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
                                            <h4 class="card-title text-center">Tambah Admin</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada saat proses login ke halaman yang berbeda
                                            </p>
                                            <form action="{{ route('admin.admin.save_admin') }}" method="post"
                                                id="myForm">
                                                @csrf
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Email" name="email"
                                                        value="{{ old('email') }}">
                                                    <label for="floatingInput">Email</label>
                                                </div>
                                                @error('email')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('nama') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Nama" name="nama"
                                                        value="{{ old('nama') }}">
                                                    <label for="floatingInput">Nama</label>
                                                </div>
                                                @error('nama')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="form-floating mb-3">
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Password"
                                                        name="password" value="{{ old('password') }}">
                                                    <label for="floatingInput">Password</label>
                                                </div>
                                                @error('password')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <label for="">Gender</label>
                                                <div class="form-floating mb-3">
                                                    <input type="radio" name="gender" value="P"
                                                        {{ old('gender') == 'P' ? 'checked' : '' }}> Pria
                                                    <input type="radio" name="gender" value="W"
                                                        {{ old('gender') == 'W' ? 'checked' : '' }}> Wanita
                                                </div>
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
