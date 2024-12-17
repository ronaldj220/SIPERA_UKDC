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
                                            <h4 class="card-title text-center">Edit Surat Psikotes</h4>
                                            <p class="card-description text-center">
                                                Digunakan setelah rekrutmen dijalankan
                                            </p>
                                            <form action="{{ route('admin.psikotes.update_psikotes',$psikotes->id) }}" method="post"
                                                id="myForm">
                                                @csrf
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputEmail1">Nomor Dokumen Psikotes</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                                        aria-describedby="emailHelp" readonly
                                                        value="{{ $psikotes->no_doku_psikotes }}" name="no_doku_psikotes">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Tanggal Pengajuan Psikotes</label>
                                                    <input type="date" class="form-control" id="exampleInputPassword1" name="tgl_ajukan" value="{{old('tgl_ajukan', $psikotes->tgl_pengajuan)}}">
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('no_doku_rektor') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Role" name="no_doku_rektor"
                                                        value="{{ old('no_doku_rektor', $psikotes->no_doku_rektor) }}">
                                                    <label for="floatingInput">Nomor Dokumen Rektor</label>
                                                </div>
                                                @error('no_doku_rektor')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                    &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Pemohon</label>
                                                    <select name="pemohon" id="pemohon" class="form-control">
                                                        <option value=""> --- Pilih --- </option>
                                                        @foreach ($pemohon as $item)
                                                            <option value="{{ $item->user->id }}" {{ (old('pemohon') == $item->user->id || $psikotes->rekrutmen->user->id == $item->user->id) ? 'selected' : '' }}>{{ $item->user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Tanggal Hadir
                                                        Psikotes</label>
                                                    <input type="date" class="form-control" id="exampleInputPassword1" name="tgl_hadir" value="{{old('tgl_hadir', $psikotes->tgl_hadir)}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Jam Hadir
                                                        Psikotes</label>
                                                    <input type="time" class="form-control"
                                                        id="exampleInputPassword1" name="jam_hadir" value="{{old('jam_hadir', $psikotes->jam_hadir)}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Lokasi Psikotes</label>
                                                    <select name="lokasi_hadir" required>
    <option value="">Pilih Lokasi Psikotes</option>
    @foreach ($lokasi_psikotes as $lokasi)
        <option value="{{ $lokasi->id }}" {{ $psikotes->lokasi_psikotes_id == $lokasi->id ? 'selected' : '' }}>{{ $lokasi->lokasi_psikotes }}</option>
    @endforeach
</select>   
                                                </div>
                                                @error('lokasi_psikotes')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                        <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('link_psikotes') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Masukkan Role" name="link_psikotes"
                                                        value="{{old('link_psikotes', $psikotes->link_psikotes)}}">
                                                    <label for="floatingInput">Link Psikotes</label>
                                                </div>
                                                @error('link_psikotes')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
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
