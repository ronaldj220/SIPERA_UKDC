<table class="table table-hover" id="search-results">
    <thead class="text-center">
        <tr>
            <th>@sortablelink('no_doku', 'Nomor Dokumen')</th>
            <th>Dokumen</th>
            <th>
                @sortablelink('user.nama', 'Pemohon')
                @if(request()->get('sort') == 'user.nama')
                    <i class="mdi {{ request()->get('order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                @endif
            </th>
            @if ($recruitmen && $recruitmen->isNotEmpty())
    @php $item = $recruitmen->first(); @endphp
    <th>
        @sortablelink(
            $item->status_approval == 'approved' || $item->status_approval == 'rejected' ? 'tgl_kirim' : 'tgl_pengajuan', 
            $item->status_approval == 'approved' || $item->status_approval == 'rejected' ? 'Tanggal Kirim' : 'Tanggal Pengajuan'
        )
    </th>
    @if($item->status_approval !== 'approved' && $item->status_approval !== 'rejected')
        <th>Status</th>
    @endif
    <th>Aksi</th>
@endif

        </tr>
    </thead>

    <tbody>
        @foreach($recruitmen as $item)
            <tr>
                <td>
                    @if($item->status_approval == 'approved')
                        <a href="{{ route('admin.recruitmen.view_recruitmen', $item->id) }}">{{ $item->no_doku }}</a>
                    @else
                        {{ $item->no_doku }}
                    @endif
                </td>
                <td style="width:20px">
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#modalView{{ $item->id }}">
                            <span class="mdi mdi-eye"></span>
                        </button>

                        <div class="modal fade" id="modalView{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="modalLabel{{ $item->id }}">Lihat Dokumen</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Lowongan yang Dilamar: </strong>{{ $item->lowongan ? $item->lowongan->name_lowongan : 'Tidak tersedia' }}</p>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <a href="{{ route('admin.recruitmen.view_cv', $item->id) }}" class="btn btn-rounded btn-success">View CV</a>
                                        <a href="{{ route('admin.recruitmen.view_transkrip', $item->id) }}" class="btn btn-rounded btn-danger">View Transkrip dan Ijazah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>{{ $item->user->nama }}</td>
                <td style="width:20px">
                    {{ 
                        $item->status_approval == 'approved' 
                            ? ($item->tgl_kirim ? \Carbon\Carbon::parse($item->tgl_kirim)->translatedFormat('d F Y') : 'Dokumen belum dikirim') 
                            : ($item->status_approval == 'rejected' 
                                ? ($item->tgl_kirim ? \Carbon\Carbon::parse($item->tgl_kirim)->translatedFormat('d F Y') : 'Dokumen belum dikirim')
                                : \Carbon\Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y')
                              )
                    }}
                </td>

                <td class="text-center">
                    @switch($item->status_approval)
                        @case('submitted')
                            <label class="badge badge-danger" style="font-size: 1.2em">Submitted</label>
                            @break
                        @case('pending')
                            <label class="badge {{ $item->is_edited == 'true' ? 'badge-info' : 'badge-warning' }}" style="font-size: 1.2em">
                                {{ $item->is_edited == 'true' ? 'Pending (Revised)' : 'Pending' }}
                            </label>
                            @break
                        @case('rejected')
                            <a href="{{ route('admin.recruitmen.send_recruitmen', $item->id) }}" class="btn btn-rounded btn-warning">Kirim</a>
                            @break
                        @case('approved')
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.recruitment.editQuickRecruitment', $item->id) }}" class="btn btn-rounded btn-info">Edit</a>
                                <a href="{{ route('admin.recruitmen.send_recruitmen', $item->id) }}" class="btn btn-rounded btn-warning">Kirim</a>
                            </div>
                            @break
                    @endswitch
                </td>
                <td>
                    <div class="d-flex justify-content-center">
                        @if($item->status_approval == 'submitted')
                            <button type="button" class="btn btn-info btn-rounded" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $item->id }}">
                                Pilih Status Dokumen
                            </button>

                            <div class="modal fade" id="staticBackdrop{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel{{ $item->id }}">Pilih Status Dokumen</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah anda ingin mengubah status dokumen?
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('admin.recruitmen.verify_recruitmen', $item->id) }}" class="btn btn-rounded btn-warning">Proses</a>
                                            <a href="{{ route('admin.recruitmen.tolak_doc', $item->id) }}" class="btn btn-rounded btn-danger">Tolak</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($item->status_approval == 'pending' && $item->is_edited == 'true')
                            <a href="{{ route('admin.recruitmen.edit_rekrutmen', $item->id) }}" class="btn btn-rounded btn-info">Ajukan Surat Panggilan</a>
                        @elseif($item->status_approval == 'pending' && $item->is_edited == 'false')
                            <a href="{{ route('admin.recruitmen.verify_recruitmen', $item->id) }}" class="btn btn-rounded btn-warning">Setujui</a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
