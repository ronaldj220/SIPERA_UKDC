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
                                <div class="col-lg-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Daftar Psikotes</h4>
                                            <p class="card-description text-center">
                                                Digunakan setelah rekrutmen dibuat
                                            </p>

                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            @if ($psikotes && count($psikotes) > 0)
                                                                @php
                                                                    $item = $psikotes[0];
                                                                @endphp
                                                                @if ($item->status_approval == 'approved')
                                                                    <th>Nomor Dokumen</th>
                                                                @endif
                                                            @endif
                                                            <th>Pemohon</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($psikotes as $item)
                                                            <tr>
                                                                @if ($item->status_approval == 'approved')
                                                                    <td><a
                                                                            href="{{ route('pelamar.psikotes.view_psikotes', $item->id) }}">{{ $item->no_doku_psikotes }}</a>
                                                                    </td>
                                                                @endif
                                                                <td> {{ Auth::user()->nama }} </td>
                                                                <td class="text-center">
                                                                    @if ($item->status_approval == 'submitted')
                                                                        <label class="badge badge-danger"
                                                                            style="font-size: 1.2em">Submitted</label>
                                                                    @elseif ($item->status_approval == 'pending')
                                                                        <label class="badge badge-warning"
                                                                            style="font-size: 1.2em">Pending</label>
                                                                    @elseif ($item->status_approval == 'approved')
                                                                        <label class="badge badge-success"
                                                                            style="font-size: 1.2em">Approved</label>
                                                                    @elseif ($item->status_approval == 'rejected')
                                                                        <label class="badge badge-danger"
                                                                            style="font-size: 1.2em">Rejected</label>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                                        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#modalView{{ $item->id }}">
    <span class="mdi mdi-eye"></span>
</button>

<!-- Modal -->
<div class="modal fade" id="modalView{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalLabel{{ $item->id }}">Pemberitahuan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Lowongan yang diajukan :</strong> {{$item->rekrutmen->lowongan->name_lowongan}}</p>
        @if($item->status_approval == 'approved')
            <p><strong>Jadwal Psikotes :</strong>
                @if ($item->tgl_hadir)
                    {{ \Carbon\Carbon::parse($item->tgl_hadir)->translatedFormat('d F Y') }}, {{ \Carbon\Carbon::parse($item->jam_hadir)->format('H:i') }} WIB
                @else
                    Belum dijadwalkan
                @endif
            </p>
            <p><strong>Lokasi Psikotes :</strong>
            {{$item->LokasiPsikotes->lokasi_psikotes}},<br> 
            {{$item->LokasiPsikotes->alamat_psikotes}}
            </p>
        @endif
      </div>
    </div>
  </div>
</div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
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
</body>
@include('sweetalert::alert')

</html>
