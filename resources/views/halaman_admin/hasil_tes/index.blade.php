<?php
    use Carbon\Carbon;
?>

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
                                <div class="col-lg-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Daftar Surat Penerimaan</h4>
                                            <p class="card-description text-center">
                                                Digunakan setelah rekrutmen dan psikotes dibuat (Hasil Akhir)
                                            </p>
                                            <a href="{{ route('admin.hasil_tes.add_surat_penerimaan') }}"
                                                class="btn btn-rounded btn-primary"><span
                                                    class="mdi mdi-eye-plus"></span> Ajukan Hasil Tes</a>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>Nomor Dokumen (SP)</th>
                                                            <th>Dokumen</th>
                                                            <th>Pemohon</th>
                                                            @if ($hasil_tes && count($hasil_tes) > 0)
                                                                @php
                                                                    $item = $hasil_tes[0];
                                                                @endphp
                                                                @if ($item->status_approval == 'pending')
                                                                    <th>Status</th>
                                                                @elseif ($item->status_approval == 'approved')
                                                                    <th>Tanggal Kirim</th>
                                                                @elseif ($item->status_approval == 'rejected')
                                                                    <th>Tanggal Kirim</th>
                                                                @endif
                                                            @endif
                                                            @if ($hasil_tes && count($hasil_tes) > 0)
                                                                @php
                                                                    $item = $hasil_tes[0];
                                                                @endphp
                                                                @if ($item->status_approval == 'pending')
                                                                    <th>Aksi</th>
                                                                @elseif ($item->status_approval == 'approved')
                                                                    <th>Aksi</th>
                                                                @elseif ($item->status_approval == 'rejected')
                                                                    <th>Aksi</th>
                                                                @endif
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        @foreach ($hasil_tes as $item)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{route('admin.hasil_tes.view_surat_penerimaan', $item->id)}}">{{$item->no_doku}}</a>
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
            <p><strong>Status Pegawai :</strong> {{$item->PosisiLamaran->status_pegawai}}</p>
        <p><strong>Unit Kerja :</strong> {{$item->PosisiLamaran->unit_kerja}}</p>
        <p><strong>Masa Percobaan :</strong> 
            @php
                $awal = $item->PosisiLamaran->masa_percobaan_awal ? Carbon::parse($item->PosisiLamaran->masa_percobaan_awal) : null;
                $akhir = $item->PosisiLamaran->masa_percobaan_akhir ? Carbon::parse($item->PosisiLamaran->masa_percobaan_akhir) : null;
                                    
                if ($awal && $akhir) {
                    // Menampilkan tanggal awal dan akhir
                    echo $awal->format('d M Y') . ' - ' . $akhir->format('d M Y') . ' ';
                                        
                    // Menghitung selisih masa percobaan
                    $selisih = $awal->diff($akhir);
                    $tahun = $selisih->y;
                    $bulan = $selisih->m;
                                        
                    // Menampilkan hasil dalam format tahun dan bulan
                    if ($tahun > 0) {
                        echo "({$tahun} tahun";
                        echo $bulan > 0 ? " {$bulan} bulan" : "";
                        echo ")";
                    } elseif ($bulan > 0) {
                        echo "({$bulan} bulan)";
                    }
                } else {
                    echo 'Tidak tersedia';
                }
            @endphp
        </p>
        @endif
        
      </div>
    </div>
  </div>
</div>
                                                                    </div>
                                                                </td>
                                                                <td> {{ $item->rekrutmen->user->nama }} </td>
                                                                <td class="text-center">
                                                                    @if ($item->status_approval == 'pending')
                                                                        <label class="badge badge-warning"
                                                                            style="font-size: 1.2em">Pending</label>
                                                                    @elseif ($item->status_approval == 'approved')
                                                                        {{ $item->tgl_kirim ? \Carbon\Carbon::parse($item->tgl_kirim)->translatedFormat('d F Y') : 'Email belum dikirim' }}
                                                                    @elseif ($item->status_approval == 'rejected')
                                                                        {{ $item->tgl_kirim ? \Carbon\Carbon::parse($item->tgl_kirim)->translatedFormat('d F Y') : 'Email belum dikirim' }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                                        @if ($item->status_approval == 'pending')
                                                                            <a href="{{ route('admin.hasil_tes.acc_surat_penerimaan', $item->id) }}"
                                                                                class="btn btn-rounded btn-warning">Setujui</a>
                                                                                &nbsp;
                                                                            <a href="{{ route('admin.hasil_tes.tolak_surat_penerimaan', $item->id) }}"
                                                                                class="btn btn-rounded btn-danger">Tolak</a>
                                                                        @elseif ($item->status_approval == 'approved')
                                                                            <a href="{{ route('admin.hasil_tes.send_surat_penerimaan', $item->id) }}"
                                                                                class="btn btn-rounded btn-warning">Kirim</a>
                                                                        @elseif ($item->status_approval == 'rejected')
                                                                            <a href="{{ route('admin.hasil_tes.send_surat_penerimaan', $item->id) }}"
                                                                                class="btn btn-rounded btn-warning">Kirim</a>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                
                                                @if($hasil_tes->count() > 0)
                                                    <div class="row">
                                                        <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                                            <div>
                                                                Showing {{ $hasil_tes->firstItem() }} to {{ $hasil_tes->lastItem() }} of {{ $hasil_tes->total() }} entries
                                                            </div>
                                                            {!! $hasil_tes->appends(Request::except('page'))->render() !!}
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center mt-4 mb-4">
                                                            <p>No entries found.</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
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
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>
@include('sweetalert::alert')

</html>
