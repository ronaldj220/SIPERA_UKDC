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
                                            <h4 class="card-title text-center">Daftar Posisi Lamaran</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada informasi pada penerimaan
                                            </p>
                                            <div class="table-responsive mt-5">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>@sortablelink('posisi', 'Posisi Lamaran')</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        @foreach ($pos_lamaran as $item)
                                                            <tr>
                                                             <td>{{ $no++ . '.' }}</td>
                                                             <td>{{$item->posisi}}</td>
                                                             <td>
                                                                <div class="d-flex justify-content-center">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#modalView{{ $item->id }}">
                View
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalView{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalLabel{{ $item->id }}">Detail Posisi Lamaran untuk {{$item->posisi}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Unit Kerja yang diajukan: </strong>{{ $item->unit_kerja ? $item->unit_kerja : 'Tidak tersedia' }}</p>
                            <p><strong>Status Pegawai yang diajukan: </strong>{{ $item->status_pegawai ? $item->status_pegawai : 'Tidak tersedia' }}</p>
                            <p><strong>Masa Percobaan: </strong>
                                @php
                                    $awal = $item->masa_percobaan_awal ? Carbon::parse($item->masa_percobaan_awal) : null;
                                    $akhir = $item->masa_percobaan_akhir ? Carbon::parse($item->masa_percobaan_akhir) : null;
                                    
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
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <a href="{{ route('admin.pos_lamaran.edit_pos_lamaran', $item->id) }}" class="btn btn-info btn-rounded">Edit</a>
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