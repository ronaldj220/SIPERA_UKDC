<table>
    <thead>
        <tr>
            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Nama Lengkap dan Gelar</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Tanggal dan Tempat Lahir</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Umur</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Agama</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Pendidikan</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Jurusan/Fakultas</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; height: 200%; ">Uraikan alasan anda memutuskan untuk mengirimkan lamaran di Universitas kami, dan mengapa kami harus memilih anda.</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Email</th>
                                                            <th style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; width: 200%; ">Nomor Handphone</th>
        </tr>
    </thead>
    <tbody>
        @foreach($recruitmen as $item)
        <tr>
            <td>{{ $item->user->nama }}</td>
            <td>
                @php
                    $tempatLahir = str_replace(['Kota ', 'Kabupaten '], '', $item->user->tempat_lahir);
                @endphp
                {{ $tempatLahir }}, {{ \Carbon\Carbon::parse($item->user->tgl_lahir)->translatedFormat('d F Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($item->user->tgl_lahir)->age }} tahun</td>
            <td>{{ $item->user->agama->agama ?? 'Tidak diketahui' }}</td>
            <td>{{ $item->user->pendidikan }}</td>
            <td>{{ $item->user->jurusan }}</td>
            <td>{{ $item->alasan_penerimaan }}</td>
            <td>{{ $item->user->email }}</td>
            <td>{{ $item->user->phone_number }}</td>
        </tr>
        @endforeach
    </tbody>
</table>