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
                        <div class="col-lg-12 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-lg-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Tambah Data Psikotes</h4>
                                            <p class="card-description text-center">
                                                Digunakan setelah rekrutmen dijalankan
                                            </p>
                                            <form action="{{ route('admin.psikotes.save_psikotes') }}" method="post"
                                                id="myForm">
                                                @csrf
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputEmail1">Nomor Dokumen Psikotes</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                                        aria-describedby="emailHelp" readonly
                                                        value="{{ $no_doku }}" name="no_doku_psikotes">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nomor Dokumen Rektor</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                                        aria-describedby="emailHelp" name="no_doku_rektor">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Tanggal Pengajuan
                                                        Psikotes</label>
                                                    <input type="date" class="form-control"
                                                        id="exampleInputPassword1" name="tgl_ajukan">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Pemohon</label>
                                                    <select name="pemohon" id="" class="form-control">
                                                        <option value=""> --- Pilih --- </option>
                                                        @foreach ($pemohon as $item)
                                                            <option value="{{ $item->pemohon }}">{{ $item->pemohon }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Tanggal Hadir
                                                        Psikotes</label>
                                                    <input type="date" class="form-control"
                                                        id="exampleInputPassword1" name="tgl_hadir">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Jam Hadir
                                                        Psikotes</label>
                                                    <input type="time" class="form-control"
                                                        id="exampleInputPassword1" name="jam_hadir">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Lokasi Psikotes</label>
                                                    <input type="text"
                                                        class="form-control @error('lokasi_hadir') is-invalid @enderror"
                                                        name="lokasi_hadir">
                                                </div>
                                                @error('lokasi_hadir')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror

                                                <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Ajukan Surat Psikotes</button>
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
