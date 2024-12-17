<table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            @if ($recruitmen && count($recruitmen) > 0)
                                                                @php
                                                                    $item = $recruitmen[0];
                                                                @endphp
                                                                @if ($item->status_approval == 'approved')
                                                                    <th>Nomor Dokumen</th>
                                                                @endif
                                                            @endif
                                                            <th>Pemohon</th>
                                                            <th>Tanggal Pengajuan</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($recruitmen as $item)
                                                            <tr>
                                                                @if ($item->status_approval == 'approved')
                                                                    <td><a
                                                                            href="{{ route('karyawan.recruitmen.view_doc', $item->id) }}">{{ $item->no_doku }}</a>
                                                                    </td>
                                                                @endif
                                                                <td> {{ Auth::user()->nama }} </td>
                                                                <td> {{ date('d F Y', strtotime($item->tgl_pengajuan)) }}
                                                                </td>
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
        <p><strong>Lowongan yang Dilamar: </strong>{{ $item->lowongan ? $item->lowongan->name_lowongan : 'Tidak tersedia' }}</p>
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