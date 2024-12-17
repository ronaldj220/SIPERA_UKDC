<table>
    <thead>
        <tr>
            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Nomor Dokumen Psikotes</th>
            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Nomor Dokumen Rektor</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Pemohon</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Tanggal Pengajuan</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Lokasi Psikotes</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Alamat Psikotes</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Ruangan Psikotes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($psikotes as $item)
        <tr>
            <td>{{ $item->no_doku_psikotes }}</td>
            <td>{{ $item->no_doku_rektor }}</td>
            <td>{{ $item->rekrutmen->user->nama }}</td>
            <td>{{ $item->tgl_pengajuan }}</td>
            <td>{{ $item->lokasiPsikotes->lokasi_psikotes ?? 'Tidak Ada Lokasi' }}</td>
            <td>{{ $item->lokasiPsikotes->alamat_psikotes ?? 'Tidak Ada Lokasi' }}</td>
            <td>{{ $item->lokasiPsikotes->ruangan_psikotes ?? 'Tidak Ada Lokasi' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>