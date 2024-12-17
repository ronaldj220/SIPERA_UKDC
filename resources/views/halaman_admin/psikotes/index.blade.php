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
                                            <h4 class="card-title text-center">Daftar Psikotes</h4>
                                            <p class="card-description text-center">
                                                Digunakan setelah rekrutmen terpenuhi
                                            </p>
                                            <div class='d-flex justify-content-between'>
                                                <a href="{{ route('admin.psikotes.add_psikotes') }}" class="btn btn-rounded btn-primary"><span class="mdi mdi-eye-plus"></span> Ajukan Surat Psikotes
                                                </a>
                                                <div class="d-flex justify-content-end">
                                                    <input type='search' class="form-control" placeholder="Search Document Here" name='q' id='search' />
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="search-results">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>@sortablelink('no_doku_psikotes', 'Nomor Dokumen')</th>
                                                            <th>Dokumen</th>
                                                            <th>Pemohon</th>
                                                            @if ($psikotes && count($psikotes) > 0)
                                                                @php
                                                                    $item = $psikotes[0];
                                                                @endphp
                                                                @if ($item->status_approval == 'submitted')
                                                                    <th>@sortablelink('status_approval', 'Status')</th>
                                                                @elseif ($item->status_approval == 'pending')
                                                                    <th>@sortablelink('status_approval', 'Status')</th>
                                                                @elseif ($item->status_approval == 'approved')
                                                                    <th>@sortablelink('tgl_kirim', 'Tanggal Kirim')</th>
                                                                @elseif ($item->status_approval == 'rejected')
                                                                    <th>@sortablelink('tgl_kirim', 'Tanggal Kirim')</th>
                                                                @endif
                                                            @endif
                                                            @if ($psikotes && count($psikotes) > 0)
                                                                @php
                                                                    $item = $psikotes[0];
                                                                @endphp
                                                                @if ($item->status_approval == 'submitted')
                                                                    <th>Aksi</th>
                                                                @elseif ($item->status_approval == 'pending')
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
                                                        @foreach ($psikotes as $item)
                                                            <tr>
                                                                <td><a
                                                                            href="{{ route('admin.psikotes.view_psikotes', $item->id) }}">{{ $item->no_doku_psikotes }}</a>
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
                                <p><strong>Lowongan yang diajukan :</strong>
                                    {{$item->rekrutmen->lowongan->name_lowongan}}
                                </p>
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
                                @if($item->status_approval == 'approved')
                                    <div class="d-flex justify-content-center mt-4">
                                        <a href="{{ route('admin.psikotes.view_psikotes', $item->id) }}" class="btn btn-rounded btn-info">View Surat Psikotes</a>
                                    </div>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                                                                </td>
                                                                <td> {{ $item->rekrutmen->user->nama }} </td>
                                                                <td style="width:20px">
    @if ($item->status_approval == 'submitted')
        <label class="badge badge-danger" style="font-size: 1.2em">Submitted</label>
    @elseif ($item->status_approval == 'pending')
        <label class="badge badge-warning" style="font-size: 1.2em">Pending</label>
    @elseif ($item->status_approval == 'approved' || $item->status_approval == 'rejected')
        <label class="badge badge-success" style="font-size: 1.2em">
            {{ $item->tgl_kirim ? \Carbon\Carbon::parse($item->tgl_kirim)->translatedFormat('d F Y') : 'Email belum dikirim' }}
        </label>
    @endif
</td>

                                                                <td>
                                                                    <div class="d-flex justify-content-center">

                                                                        @if ($item->status_approval == 'pending')
                                                                    <a href="{{ route('admin.psikotes.edit_psikotes', $item->id) }}" class="btn btn-rounded btn-info">Edit</a>
                                                                    &nbsp;
                                                                    <a href="{{ route('admin.psikotes.acc_psikotes', $item->id) }}"
                                                                                class="btn btn-rounded btn-warning">Setujui</a>
                                                                                &nbsp;
                                                                                            <a href="{{ route('admin.psikotes.reject_psikotes', $item->id) }}" class="btn btn-rounded btn-danger">Tolak</a> <!-- Reject button -->

                                                                        @elseif ($item->status_approval == 'approved')
                                              <a href="{{ route('admin.psikotes.editQuickPsikotes', $item->id) }}" class="btn btn-rounded btn-info">Edit</a>                              &nbsp;
                                                                            <a href="{{ route('admin.psikotes.send_psikotes', $item->id) }}"
                                                                                class="btn btn-rounded btn-warning">Kirim</a>
                                                                        @elseif ($item->status_approval == 'rejected')
                                                                            <a href="{{ route('admin.psikotes.send_psikotes', $item->id) }}"
                                                                                class="btn btn-rounded btn-warning">Kirim</a>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                
                                                @if($psikotes->count() > 0)
                                                    <div class="row">
                                                        <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                                            <div>
                                                                Showing {{ $psikotes->firstItem() }} to {{ $psikotes->lastItem() }} of {{ $psikotes->total() }} entries
                                                            </div>
                                                            {!! $psikotes->appends(Request::except('page'))->render() !!}
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
        
        $(document).ready(function(){
    $('#search').on('keyup', function(){
        let result = $(this).val();
        $.ajax({
            url: "{{ route('admin.psikotes.search') }}",
            type: "GET",
            data: {
                r: result
            },
            success: function(data) {
                // Clear existing results
                $('#search-results tbody').empty();
                
                // Append new results
                if (data.data.length > 0) {
                    data.data.forEach(function(item, index) {
                        // Format tanggal pengajuan menggunakan JavaScript
                        let tgl_pengajuan = new Date(item.tgl_pengajuan);
                        let formattedDate = tgl_pengajuan.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        
                        // Menentukan status approval
                        let statusBadge = '';
                        if(item.status_approval === 'pending'){
                            statusBadge = '<label class="badge badge-warning" style="font-size: 1.2em">Pending</label>';
                        } else if(item.status_approval === 'approved'){
                            statusBadge = '<label class="badge badge-success" style="font-size: 1.2em">Approved</label>';
                        } else if(item.status_approval === 'rejected'){
                            statusBadge = '<label class="badge badge-danger" style="font-size: 1.2em">Rejected</label>';
                        }
                        
                        $('#search-results tbody').append(`
                            <tr>
                                <td>
                                    <a href="{{url('admin/recruitmen/view_recruitmen')}}/${item.id}">${item.no_doku_psikotes}</a>
                                </td>
                                <td>${item?.rekrutmen?.user?.nama}</td>
                                <td>${formattedDate}</td>
                                <td>${statusBadge}</td>
                            </tr>
                        `);
                    });
                } else {
                    $('#search-results tbody').append('<tr><td colspan="5" class="text-center">No entries found.</td></tr>');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Display the error in the console
                console.log("AJAX Error: ", textStatus, errorThrown);
                console.log("Response Text: ", jqXHR.responseText);
                
                // Optionally, show a user-friendly message in the UI
                $('#search-results tbody').empty();
                $('#search-results tbody').append('<tr><td colspan="5" class="text-center">Error retrieving results. Check console for details.</td></tr>');
            }
        });
    });
});
    
    </script>
</body>
@include('sweetalert::alert')

</html>
