@include('layouts.halaman_karyawan.header')

<body class="with-welcome-text">
    <div class="container-scroller">
        @include('layouts.halaman_karyawan.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts.halaman_karyawan.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-lg-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Update Profil</h4>
                                            <p class="card-description text-center">
                                                Digunakan untuk proses rekrutmen berjalan lancar
                                            </p>
                                            <form action="{{ route('pelamar.profile.update_profile', Auth::user()->id) }}" method="post"
                                                id="myForm">
                                                @csrf
                                                <div class="form-floating">
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
                                                        class="form-control @error('alamat') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Pendidikan Terakhir!"
                                                        name="alamat" value="{{ old('alamat', Auth::user()->alamat) }}">
                                                    <label for="floatingInput">Alamat</label>
                                                </div>
                                                @error('alamat')
                                                    <p style="color: red;">* {{ $message }}</p>
                                                @enderror
                                                <br>
                                                <div class="form-floating">
                                                    <input type="text" inputmode="numeric"
                                                        class="form-control @error('phone_number') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Nomor Telepon!"
                                                        name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}">
                                                    <label for="floatingInput">Nomor Telepon</label>
                                                </div>
                                                @error('phone_number')
                                                    <p style="color: red;">* {{ $message }}</p>
                                                @enderror
                                                <br>
                                                <div class="row g-2">
                                                  <div class="col-md">
                                                      <label for="floatingInputGrid">Tempat Lahir</label>
                                                      <select id="birth_place" name="tempat_lahir" class="select2">
    <option value="">Pilih Tempat Lahir</option>
    @foreach($cityList as $city)
        <option value="{{ $city['text'] }}" {{ (old('birth_place', $currentBirthPlaceId) == $city['text']) ? 'selected' : '' }}>{{ $city['text'] }}</option>
    @endforeach
</select>
                                                  </div>
                                                  @error('tempat_lahir')
                                                    <p style="color: red;">* {{ $message }}</p>
                                                @enderror
                                                  <div class="col-md">
                                                    <div class="form-floating">
                                                      <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" id="floatingInputGrid" placeholder="name@example.com" value="{{ old('tgl_lahir', Auth::user()->tgl_lahir) }}" name="tgl_lahir">
                                                      <label for="floatingInputGrid">Tanggal Lahir</label>
                                                    </div>
                                                  </div>
                                                  @error('tgl_lahir')
                                                    <p style="color: red;">* {{ $message }}</p>
                                                @enderror
                                                </div>
                                                <br>
                                                <div class="form-floating">
                                                    <input type="text"
                                                        class="form-control @error('universitas') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Nomor Telepon!"
                                                        name="universitas" value="{{ old('universitas', Auth::user()->universitas) }}">
                                                    <label for="floatingInput">Universitas</label>
                                                </div>
                                                @error('universitas')
                                                    <p style="color: red;">* {{ $message }}</p>
                                                @enderror
                                                <br>
                                                <div class="form-floating">
                                                    <input type="text"
                                                        class="form-control @error('pendidikan') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Pendidikan!"
                                                        name="pendidikan" value="{{ old('pendidikan', Auth::user()->pendidikan) }}">
                                                    <label for="floatingInput">Pendidikan Terakhir</label>
                                                </div>
                                                @error('pendidikan')
                                                    <p style="color: red;">* {{ $message }}</p>
                                                @enderror
                                                <br>
                                                <div class="form-floating">
                                                    <input type="text"
                                                        class="form-control @error('jurusan') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Nomor Telepon!"
                                                        name="jurusan" value="{{ old('jurusan', Auth::user()->jurusan) }}">
                                                    <label for="floatingInput">Jurusan/Fakultas</label>
                                                </div>
                                                @error('jurusan')
                                                    <p style="color: red;">* {{ $message }}</p>
                                                @enderror
                                                <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Simpan Perubahan</button>
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
                @include('layouts.halaman_karyawan.footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    @include('layouts.halaman_karyawan.script')
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
        
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Tempat Lahir",
                allowClear: true,
                width: '100%'
            });
        });

    </script>
</body>

</html>
