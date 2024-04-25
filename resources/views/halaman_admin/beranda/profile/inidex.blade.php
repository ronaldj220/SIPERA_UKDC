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
                                            <h4 class="card-title text-center">Ubah Kata Sandi</h4>
                                            <p class="card-description text-center">
                                                Untuk Pembaruan Kata Sandi
                                            </p>
                                            <form action="{{ route('admin.change_pwd') }}" method="post"
                                                id="myForm">
                                                @csrf
                                                <div class="form-floating">
                                                    <input type="password"
                                                        class="form-control @error('new_password') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Departemen"
                                                        name="new_password" value="{{ old('departemen') }}">
                                                    <label for="floatingInput">New Password</label>
                                                </div>
                                                @error('new_password')
                                                    <p style="color: red;">{{ $message }}</p>
                                                @enderror
                                                <div class="form-floating">
                                                    <input type="password"
                                                        class="form-control @error('confirm_password') is-invalid @enderror"
                                                        id="floatingPassword" placeholder="Masukkan PiC"
                                                        name="confirm_password">
                                                    <label for="floatingPassword">Confirm Password</label>
                                                </div>
                                                @error('confirm_password')
                                                    <p style="color: red;">{{ $message }}</p>
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
