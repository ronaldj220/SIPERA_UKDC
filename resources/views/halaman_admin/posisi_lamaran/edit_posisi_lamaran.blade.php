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
                                            <h4 class="card-title text-center">Edit Posisi Lamaran</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada saat penerimaan
                                            </p>
                                            <form action="{{ route('admin.pos_lamaran.update_pos_lamaran', $posisiLamaran->id) }}"
                                                method="post" id="myForm">
                                                @csrf
                                                <div class="form-floating mb-3">
                                                  <input type="text" class="form-control @error('pos_lamaran') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name='pos_lamaran' value="{{ old('pos_lamaran', $posisiLamaran->posisi) }}">
                                                  @error('pos_lamaran')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                  <label for="floatingInput">Posisi Lamaran</label>
                                                </div>
                                                <div class="form-floating mt-3">
                                                  <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="unit_kerja">
                                                    <option value="">---Pilih---</option>
                                                    @foreach($unitKerja as $item)
                                                    <option value="{{$item->nama_unit_kerja}}" {{ old('unit_kerja', $posisiLamaran->unit_kerja) == $item->nama_unit_kerja ? 'selected' : '' }}>{{$item->nama_unit_kerja}}</option>
                                                    @endforeach
                                                  </select>
                                                  <label for="floatingSelect">Unit Kerja</label>
                                                </div>
                                                <div class="form-floating mt-3">
                                                  <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="status_pegawai">
                                                    <option value="">---Pilih---</option>
                                                    @foreach($statusPegawai as $item)
                                                    <option value="{{$item->nama_status}}" {{ old('status_pegawai', $posisiLamaran->status_pegawai) == $item->nama_status ? 'selected' : '' }}>{{$item->nama_status}}</option>
                                                    @endforeach
                                                  </select>
                                                  <label for="floatingSelect">Status Pegawai</label>
                                                </div>
                                            
                                            <div class="row g-2 mt-3">
  <div class="col-md">
    <div class="form-floating">
      <input type="date" class="form-control" id="floatingInputGrid" placeholder="name@example.com" value="{{ old('tanggal_awal', $posisiLamaran->masa_percobaan_awal) }}" name="tanggal_awal" >
      <label for="floatingInputGrid">Awal Posisi Lamaran</label>
    </div>
  </div>
  <div class="col-md">
    <div class="form-floating">
      <input type="date" class="form-control" id="floatingInputGrid" placeholder="name@example.com" value="{{ old('tanggal_akhir', $posisiLamaran->masa_percobaan_akhir) }}" name="tanggal_akhir">
      <label for="floatingInputGrid">Akhir Posisi Lamaran</label>
    </div>
  </div>
</div>
                                            <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Perbarui Posisi Lamaran</button>
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