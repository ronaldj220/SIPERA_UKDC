@php
    date_default_timezone_set('Asia/Jakarta');

@endphp
@include('layouts.halaman_admin.header')

<body class="with-welcome-text">
    <div class="container-scroller">
        @include('layouts.halaman_admin.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts.halaman_admin.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-10 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-lg-8 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="text-center">Ajukan Surat Pemanggilan Tes dan Wawancara</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada saat pemanggilan tes dan wawancara
                                            </p>
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <form
                                                action="{{ route('admin.recruitmen.update_rekrutmen', $recruitmen->id) }}"
                                                method="post" id="myForm">
                                                @csrf
                                                <div class="form-floating mb-3">
                                                    <input type="date" class="form-control" id="floatingInput"
                                                        placeholder="Masukkan Departemen" name="tgl_hadir"
                                                        value="{{ old('tgl_hadir',  $recruitmen->tgl_hadir) }}">
                                                    <label for="floatingInput">Tanggal Hadir</label>
                                                </div>
                                                @error('tgl_hadir')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="form-group mt-3">
                                                    <label for="exampleFormControlSelect1">Lokasi Wawancara</label>
                                                    <select name="lokasi_wawancara" id="lokasi_wawancara" class="form-control">
                                                        <option value=""> --- Pilih --- </option>
                                                        @foreach ($lokasiWawancara as $item)
                                                            <option value="{{ $item->id }}" {{ old('lokasi_wawancara', $recruitmen->id_lokasi_wawancara) == $item->id ? 'selected' : '' }}>{{ $item->lokasi }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('lokasi_wawancara')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="row" id="detail">
                                                    <div class="form-group col-md-3">
                                                        <label for="inputEmail4">Jam Hadir</label>
                                                        <input type="time" class="form-control @error('jam_hadir.*') is-invalid @enderror" id="inputEmail4" name="jam_hadir[]">
                                                        @error('jam_hadir.*')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="inputEmail4">Jam Selesai</label>
                                                        <input type="time" class="form-control @error('jam_selesai.*') is-invalid @enderror" id="inputEmail4"
                                                            name="jam_selesai[]">
                                                            @error('jam_selesai.*')
            <div class="text-danger">{{ $message }}</div>
        @enderror
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div class="form-floating mb-3">
  <input type="text" class="form-control @error('kegiatan.*') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name='kegiatan[]'>
  <label for="floatingInput">Kegiatan</label>
</div>
@error('kegiatan.*')
            <div class="text-danger">{{ $message }}</div>
        @enderror
                                                    </div>
                                                    <div class="form-group col-md-3">

                                                        <a href="javascript:;" class="btn btn-info form-group btn-sm"
                                                            style="margin-bottom: -50px;" onclick="addDetail()">Add
                                                            Detail</a>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Simpan</button>
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

    <script>
        let no = 2;

        function addDetail() {
            var detail = document.getElementById('detail');
            var newRow = document.createElement('div');

            newRow.innerHTML = `
            <div class="row" id="detail">
                                                    <div class="form-group col-md-3">
                                                        <label for="inputEmail4">Jam Hadir</label>
                                                        <input type="time" class="form-control" id="inputEmail4" name="jam_hadir[]">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="inputEmail4">Jam Selesai</label>
                                                        <input type="time" class="form-control" id="inputEmail4" name="jam_selesai[]">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                                                                                <div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name='kegiatan[]'>
  <label for="floatingInput">Kegiatan</label>
</div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <button name="delete${no}" id="delete${no}" class="btn btn-danger btn-sm" type="button" onclick="deleteRow(this);" style="margin-bottom: -50px;">Hapus</button>
                                                    </div>
                                                </div>
            `;
            detail.appendChild(newRow);
        }

        function deleteRow(button) {
            // Dapatkan elemen induk dari tombol yang diklik (yaitu <tr>)
            let row = button.parentNode.parentNode;

            // Dapatkan elemen tabel yang berisi baris yang ingin dihapus
            let table = row.parentNode;

            // Hapus baris dari tabel
            table.removeChild(row);
        }
    </script>
</body>
@include('sweetalert::alert')

</html>
