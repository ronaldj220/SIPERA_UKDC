@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
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
                                            <h4 class="card-title text-center">Tambah Rekrutmen</h4>
                                            <p class="card-description text-center">
                                                Daftar proses pelamar kerja
                                            </p>
                                            <form action="{{ route('karyawan.recruitmen.save_recruitmen') }}"
                                                method="post" id="myForm" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputEmail1">Nomor Dokumen</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                                        aria-describedby="emailHelp" readonly
                                                        value="{{ $no_doku }}" name="no_doku">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Tanggal Pengajuan</label>
                                                    <input type="text" class="form-control"
                                                        id="exampleInputPassword1" value="{{ date('d/m/Y') }}" readonly
                                                        name="tgl_ajukan">
                                                </div>
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputPassword1">Pemohon</label>
                                                    <input type="text" class="form-control"
                                                        id="exampleInputPassword1" value="{{ Auth::user()->nama }}"
                                                        readonly name="pemohon">
                                                </div>
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputPassword1">Email</label>
                                                    <input type="text" class="form-control"
                                                        id="exampleInputPassword1" value="{{ Auth::user()->email }}"
                                                        readonly name="email_pemohon">
                                                </div>
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputPassword1">Tanggal Masuk</label>
                                                    <input type="date" class="form-control" name="tgl_masuk">
                                                </div>
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputPassword1">Tanggal Keluar</label>
                                                    <input type="date" class="form-control" name="tgl_keluar">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Departemen</label>
                                                    <select class="form-control" id="departemen" name="nama_departemen"
                                                        data-url="{{ route('karyawan.recruitmen.getPiC') }}"
                                                        onchange="updateFields()">
                                                        <option value=""> --- Pilih --- </option>
                                                        @foreach ($departemen as $item)
                                                            <option value="{{ $item->departemen }}">
                                                                {{ $item->departemen }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Jabatan</label>
                                                    <select name="nama_lamaran" id="" class="form-control">
                                                        <option value=""> --- Pilih --- </option>
                                                        <option value="Karyawan"> Karyawan </option>
                                                        <option value="Dosen"> Dosen </option>
                                                    </select>
                                                </div>
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputPassword1">PiC</label>
                                                    <input type="text" class="form-control" readonly name="pic"
                                                        id="pic">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlFile1">Upload CV</label> <br>
                                                    <input type="file"
                                                        class="form-control-file @error('file') is-invalid @enderror"
                                                        id="exampleFormControlFile1" name="file" accept=".pdf">
                                                </div>
                                                @error('file')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Ajukan Lamaran</button>
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

        // function updateFields() {
        //         var selectedSupplier = document.getElementById("departemen").value;
        //         var url = document.getElementById("departemen").getAttribute("data-url");

        //         // Lakukan permintaan AJAX ke endpoint getDataBySupplier
        //         // var xhr = new XMLHttpRequest();
        //         // xhr.onreadystatechange = function() {
        //         //     if (xhr.readyState === XMLHttpRequest.DONE) {
        //         //         if (xhr.status === 200) {
        //         //             var response = JSON.parse(xhr.responseText);
        //         //             document.getElementById("pic").value = response.keterangan;
        //         //         } else {
        //         //             document.getElementById("pic").value = "";
        //         //         }
        //         //     }
        //         // };
        //         // xhr.open("GET", url + "?getPiC=" + selectedSupplier);
        //         // xhr.send();
        //         console.log(url);
        //     }
        function updateFields() {
            var selectedDepartemen = document.getElementById("departemen").value;
            var url = document.getElementById("departemen").getAttribute("data-url");

            // Memeriksa nilai yang dipilih di konsol (opsional)
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        document.getElementById("pic").value = response.keterangan;
                    } else {
                        document.getElementById("pemohon").value = "";
                        document.getElementById("menyetujui").value = "";
                    }
                }
            };
            xhr.open("GET", url + "?menyetujui=" + selectedDepartemen);
            xhr.send();
        }
    </script>
</body>

</html>
