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
                                            <h4 class="card-title text-center">Tambah Surat Penerimaan (SP)</h4>
                                            <p class="card-description text-center">
                                                Digunakan setelah rekrutmen dibuat
                                            </p>
                                            <form action="{{ route('admin.hasil_tes.save_surat_penerimaan') }}"
                                                method="post" id="myForm">
                                                @csrf
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputEmail1">Nomor Dokumen (SP)</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                                        aria-describedby="emailHelp" readonly
                                                        value="{{ $no_doku }}" name="no_doku">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Tanggal Pengajuan
                                                        (SP)</label>
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
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="">Tempat Lahir</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Tempat Lahir" name="tempat_lahir">
                                                        </div>
                                                        <div class="col">
                                                            <label for="">Tanggal Lahir</label>
                                                            <input type="date" class="form-control"
                                                                placeholder="Last name" name="tgl_lahir">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control " id="floatingPassword"
                                                        placeholder="Masukkan Alamat" name="alamat">
                                                    <label for="floatingPassword">Alamat</label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Tanggal Kerja
                                                        (SP)</label>
                                                    <input type="date"
                                                        class="form-control @error('tgl_kerja') is-invalid @enderror"
                                                        id="exampleInputPassword1" name="tgl_kerja">
                                                </div>
                                                @error('tgl_kerja')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Ajukan Surat Penerimaan</button>
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
