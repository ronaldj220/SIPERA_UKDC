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
                                            <h4 class="card-title text-center">Ajukan Lamaran</h4>
                                            <p class="card-description text-center">
                                                Daftar lamaran kerja
                                            </p>
                                            <form action="{{ route('pelamar.recruitment.save_quick_recruitment') }}"
                                                method="post" id="myForm" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputEmail1">Nomor Dokumen</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                                        aria-describedby="emailHelp" readonly
                                                        value="{{ $no_doku }}" name="no_doku">
                                                </div>
                                                
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputPassword1">Tanggal Pengajuan</label>
                                                    <input type="text" class="form-control"
                                                        id="exampleInputPassword1" value="{{ date('d/m/Y') }}" readonly
                                                        name="tgl_ajukan">
                                                </div>
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputPassword1">Id Lowongan</label>
                                                    <input type="text" class="form-control"
                                                        id="exampleInputPassword1" value="{{$lowongan->id}}"
                                                        readonly name="id_lowongan">
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="exampleFormControlFile1">Upload CV anda</label> <br>
                                                    <input type="file"
                                                        class="form-control-file @error('file') is-invalid @enderror"
                                                        id="exampleFormControlFile1" name="file">
                                                </div>
                                                @error('file')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="form-group">
                                                    <label for="exampleFormControlFile1">Upload Transkrip Nilai dan Ijazah</label> <br>
                                                    <input type="file"
                                                        class="form-control-file @error('transkrip') is-invalid @enderror"
                                                        id="exampleFormControlFile1" name="transkrip">
                                                </div>
                                                @error('transkrip')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="form-floating mb-3">
                                                    @if(session()->has('alasan_penerimaan'))
    <textarea class="form-control @error('alasan') is-invalid @enderror" placeholder="Leave a comment here" name="alasan" id="floatingTextarea2" style="height: 100px">{{ session('alasan_penerimaan') }}</textarea>
@else
    <textarea class="form-control @error('alasan') is-invalid @enderror" placeholder="Leave a comment here" name="alasan" id="floatingTextarea2" style="height: 100px"></textarea>
@endif
<label for="floatingTextarea2">Uraikan alasan anda untuk melamar di Universitas Kami.</label>

@error('alasan')
    <div class="alert alert-danger">
        <span class="mdi mdi-alert-circle">* {{ $message }}</span>
    </div>
@enderror
                                                
                                                <div class="form-group">
    <label for="kenalan_rekrutmen">Dari mana Anda mengenal lowongan ini?</label><br>
    <div>
        <input type="radio" id="teman" name="kenalan_rekrutmen" value="teman"
        @if(session('kenalan') == 'teman') checked @endif>
        <label for="teman">Teman</label>
    </div>
    <div>
        <input type="radio" id="keluarga" name="kenalan_rekrutmen" value="keluarga"
            @if(session('kenalan') == 'keluarga') checked @endif>
        <label for="keluarga">Keluarga</label>
    </div>
    <div>
        <input type="radio" id="media_sosial" name="kenalan_rekrutmen" value="media_sosial"
        @if(session('kenalan') == 'media_sosial') checked @endif>
        <label for="media_sosial">Media Sosial</label>
    </div>
    <div>
        <input type="radio" id="job_fair" name="kenalan_rekrutmen" value="job_fair"
        @if(session('kenalan') == 'job_fair') checked @endif>
        <label for="job_fair">Job Fair</label>
    </div>
    <div>
        <input type="radio" id="website_perusahaan" name="kenalan_rekrutmen" value="website_perusahaan" @if(session('kenalan') == 'website_perusahaan') checked @endif>
        <label for="website_perusahaan">Website Perusahaan</label>
    </div>
    <div>
        <input type="radio" id="lainnya" name="kenalan_rekrutmen" value="lainnya" @if(session('kenalan') == 'lainnya') checked @endif>
        <label for="lainnya">Lainnya:</label>
        <input type="text" name="kenalan_rekrutmen_lainnya" id="kenalanLainnya" placeholder="Sebutkan" value="{{ session('kenalan_lainnya') }}" style="display:  @if(session('kenalan') == 'lainnya') block @else none @endif;">
    </div>
</div>

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
    @include('sweetalert::alert')

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
        
        // Dapatkan elemen input dan radio
        const radioLainnya = document.getElementById('lainnya');
        const inputLainnya = document.getElementById('kenalanLainnya');
    
        // Tambahkan event listener untuk radio button "Lainnya"
        radioLainnya.addEventListener('change', function() {
            if (radioLainnya.checked) {
                inputLainnya.style.display = 'flex'; // Tampilkan input jika "Lainnya" dipilih
            } else {
                inputLainnya.style.display = 'none'; // Sembunyikan input jika tidak dipilih
            }
        });
    
        // Event listener untuk menyembunyikan input saat radio selain "Lainnya" dipilih
        document.querySelectorAll('input[name="kenalan_rekrutmen"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                if (!radioLainnya.checked) {
                    inputLainnya.style.display = 'none'; // Sembunyikan input
                }
            });
        });
    </script>
</body>

</html>
