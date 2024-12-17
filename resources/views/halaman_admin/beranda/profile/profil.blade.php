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
                                            <h4 class="card-title text-center">Profile Admin
                                            </h4>
                                            <p class="card-description text-center">
                                                Digunakan untuk pembaruan profil admin
                                            </p>
                                            <form action="{{ route('admin.profile.update_profile', Auth::user()->id) }}"
                                                method="post" id="myForm">
                                                @csrf
                                                <div class="form-floating mt-2">
                                                  <select class="form-select @error('agama') is-invalid @enderror" id="floatingSelect" aria-label="Floating label select example" name="agama">
                                                    <option value=""> --- Pilih --- </option>
                                                        @foreach ($agama as $item)
                                                            <option value="{{ $item->id }}" {{ (old('agama', Auth::user()->id_agama) == $item->id) ? 'selected' : '' }}>
                                                                {{ $item->agama }}</option>
                                                        @endforeach
                                                  </select>
                                                  <label for="floatingSelect">Agama</label>
                                                </div>
                                                @error('agama')
                                                    <p style="color: red;">* {{ $message }}</p>
                                                @enderror
                                                <br>
                                                <div class="form-floating">
                                                    <input type="text"
                                                        class="form-control @error('nama') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Nama Admin"
                                                        name="nama" value="{{ old('nama', Auth::user()->nama) }}">
                                                    <label for="floatingInput">Nama</label>
                                                </div>
                                                @error('nama')
                                                    <p style="color: red;">{{ $message }}</p>
                                                @enderror
                                                <br>
                                                <div class="form-floating">
                                                    <input type="text"
                                                        class="form-control @error('NIP') is-invalid @enderror"
                                                        id="floatingPassword" placeholder="Masukkan NIP" name="NIP" value="{{ old('NIP', Auth::user()->NIP) }}">
                                                    <label for="floatingPassword">NIP</label>
                                                </div>
                                                @error('NIP')
                                                    <p style="color: red;">{{ $message }}</p>
                                                @enderror
                                                <!--Email-->
                                                <br>
                                                <div class="form-floating">
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="floatingPassword" placeholder="Masukkan NIP" name="email" value="{{ old('email', Auth::user()->email) }}">
                                                    <label for="floatingPassword">Email</label>
                                                </div>
                                                @error('email')
                                                    <p style="color: red;">{{ $message }}</p>
                                                @enderror
                                                
                                                <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Update Profile</button>
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
