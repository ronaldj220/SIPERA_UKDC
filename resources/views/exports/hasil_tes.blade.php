<table>
    <thead>
        <tr>
            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Nomor Dokumen</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Pemohon</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Tanggal Pengajuan</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Tanggal Kerja</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Lamaran</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Lama Posisi Lamaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($hasil_tes as $item)
        <tr>
            <td>{{ $item->no_doku_psikotes }}</td>
            <td>{{ $item->rekrutmen->user->nama }}</td>
            <td>{{ $item->tgl_pengajuan }}</td>
            <td>{{ $item->tgl_kerja }}</td>
            <td>{{ $item->PosisiLamaran->posisi }}</td>
            <td>{{ $item->PosisiLamaran->lama_posisi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>