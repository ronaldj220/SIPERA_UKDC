<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SILAMAR (UKDC) ({{ $admin->role_name }}) | {{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="shortcut icon" href="https://ukdc.ac.id/wp-content/uploads/2022/07/cropped-logo-kecil-32x32.png" />

</head>

<body>
    <div class="container">
        <br><br><br><br><br>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px;">
            <tr>
                <td>Nomor<br>Hal<br>Lamp.</td>
                <td>: {{ $recruitmen->no_doku }}<br> : Panggilan Tes dan Wawancara <br> : -
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px;">
            <tr>
                <td>Kepada Yth. <br>
                    Sdr/Sdri {{ $recruitmen->pemohon }} <br> Di tempat,
                </td>

            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -10px;">
            <tr>
                <td>Dengan Hormat,
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -10px;">
            <tr>
                <td>Menanggapi surat lamaran kerja Saudara/Saudari, maka dengan ini kami mengharap kedatangan
                    Saudara/Saudari pada:
                </td>
            </tr>
        </table>
        <table class="table is-striped table-bordered border-dark table-sm">
            <thead style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
                <tr>
                    <th class="text-center">Hari</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Jam</th>
                    <th class="text-center">Keterangan</th>
                </tr>
            </thead>
            @foreach ($jamHadirArray as $key => $jamData)
                <tr style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
                    @if ($key === 0)
                        <!-- Hanya tampilkan tgl_hadir di baris pertama -->
                        <td rowspan="{{ count($jamHadirArray) }}" style="vertical-align: middle; width: 5px">
                            {{ \Carbon\Carbon::parse($recruitmen->tgl_hadir)->locale('id')->translatedFormat('l') }}
                        </td>
                    @endif
                    @if ($key === 0)
                        <!-- Hanya tampilkan tgl_hadir di baris pertama -->
                        <td rowspan="{{ count($jamHadirArray) }}" style="vertical-align: middle; width: 10px">
                            {{ $tgl_hadir }}
                        </td>
                    @endif
                    <td style="width: 50px">
                        {{ $jamData }} -
                        {{ $jamSelesaiArray[$key] }}
                    </td>
                    <td style="width: 75%">
                        {{ $kegiatanArray[$key] }} *
                    </td>
                </tr>
            @endforeach
            <tr style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
                <td colspan="{{ count($jamHadirArray) }}">
                    Tempat: <b>Lantai 7</b> Ruang Biro Administrasi Umum <br><br>
                    *) <i>Jadwal yang tertera bersifat fleksibel</i>
                </td>
            </tr>
        </table>
        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
            Demikian surat panggilan ini kami sampaikan, atas perhatiannya kami ucapkan terima kasih.
        </p>
        <div class="col" style="margin-left: 1000px; margin-top: -10px;">
            <div>
                <table class="table is-striped table-borderless "
                    style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
                    <tr>

                        <td style="width: 50%; ">
                            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
                                Surabaya,
                                {{ $tgl_pengajuan }}</p>

                            <div style="font-weight: bold; margin-top: -15px;">Pembuat,</div>
                            <div style="margin-top: 100px"></div>

                            <div
                                style=" margin-top: -10px; font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
                                <b><u>{{ $admin->nama }}</u></b><br>
                                <b>NIP. {{ $admin->NIP }}</b>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
