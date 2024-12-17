@include('layouts.halaman_karyawan.header')

<body class="with-welcome-text">
    <div class="container-scroller">
        @include('layouts.halaman_karyawan.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts.halaman_karyawan.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="home-tab">
                                <div class="tab-content tab-content-basic">
                                    <div class="tab-pane fade show active" id="overview" role="tabpanel"
                                        aria-labelledby="overview">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="statistics-details d-flex align-items-center justify-content-between">
                                                    <div>
                                                        Apabila ada kendala dalam Mengajukan Proses Lamaran dapat menghubungi nomor di bawah ini dengan melampirkan <i>Screenshot</i> di bawah ini. <br>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="https://wa.me/628883200055"><i class="mdi mdi-whatsapp" style="font-size: 30px"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            
                                            <div>
    <h2 class='text-center mb-3'>Lowongan Tersedia</h2>
    <div class="row">
        @if($lowongan_pelamar->isEmpty())
            <div class="col-12 text-center">
                <p class="text-muted">Lowongan tidak tersedia saat ini.</p>
            </div>
        @else 
            @foreach($lowongan_pelamar as $item)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class='d-flex justify-content-center'>
                        <img src="data:image/jpeg;base64,{{ $item->img_base_64 }}" class="card-img-top" alt="Poster Lowongan" style="width:300px;height:300px; border-radius: 0%;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{$item->name_lowongan}}</h5>
                        <div class="mt-2 text-gray-600">
        <strong>Persyaratan:</strong>
        <ul class="list-decimal pl-5">
            {!! $item->description !!}
        </ul>
    </div>
                        <p class="card-text"><strong>Tanggal Lowongan:</strong> {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($item->expired_at)->translatedFormat('d F Y') }}</p>

                        @if(\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($item->expired_at)))
                            <!-- Lowongan sudah expired, tampilkan tombol disabled -->
                            <button class="btn btn-secondary" disabled id="expired-button-{{ $item->id }}">Lowongan Kadaluarsa</button>
                        @else
                            <!-- Lowongan masih tersedia, tampilkan tombol Ajukan Lamaran -->
                            <div class='d-flex justify-content-center'>
                                <a href="#" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#exampleModal{{ $item->id }}">Ajukan Lamaran</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal untuk setiap lowongan -->
            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel{{ $item->id }}">Proses Rekrutmen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Persyaratan: <p>{!! $item->description !!}</p>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <a href="{{route('pelamar.recruitment.create_quick_recruitment', $item->id)}}" class="btn btn-success btn-rounded">Ajukan Lamaran</a>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
        @endif
        
    </div>
</div>

                                        </div>
                @include('layouts.halaman_karyawan.footer')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.halaman_karyawan.script')
    @include('sweetalert::alert')
</body>
<script>
    // Menambahkan event listener untuk tombol kadaluarsa
    document.querySelectorAll('[id^="expired-button-"]').forEach(button => {
        button.addEventListener('click', function() {
            const name = this.previousElementSibling.querySelector('.card-title').textContent; // Ambil nama lowongan
            Swal.fire({
                icon: 'warning',
                title: 'Lowongan Kadaluarsa',
                text: `Lowongan ${name} sudah tidak tersedia karena melewati tanggal expired.`,
                showConfirmButton: true
            });
        });
    });
</script>



</html>
