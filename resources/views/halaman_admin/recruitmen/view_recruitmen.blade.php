<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Perekrutan Pegawai ({{ $admin->role_name }}) | {{ $title }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table-borderless td {
            border: none;
        }

        .table-bordered, .table-bordered th, .table-bordered td {
            border: 1px solid black;
        }

        th, td {
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

    </style>
</head>

<body>

    <div style="margin-left:3px;">
        <br><br><br><br><br><br><br><br>
        <table class="table-borderless" style="width: 100%;">
            <tr>
                <td style="width: 10%">Nomor<br>Hal<br>Lamp.</td>
                <td>: {{ $recruitmen->no_doku }}<br> : Panggilan Tes dan Wawancara <br> : - </td>
            </tr>
        </table>

        <table class="table-borderless" style="width: 100%;">
            <tr>
                <td>Kepada Yth. <br>
                    @if($recruitmen->user->gender == 'P')
                        Sdr.
                    @elseif($recruitmen->user->gender == 'W')
                        Sdri.
                    @endif
                    {{ $recruitmen->user->nama }} <br> Di tempat,
                </td>
            </tr>
        </table>

        <table class="table-borderless" style="width: 100%;">
            <tr>
                <td>Dengan Hormat,</td>
            </tr>
        </table>

        <table class="table-borderless" style="width: 100%;">
            <tr>
                <td>Menanggapi surat lamaran kerja 
                    @if($recruitmen->user->gender == 'P')
                        Saudara,
                    @elseif($recruitmen->user->gender == 'W')
                        Saudari,
                    @endif maka dengan ini kami mengharap kedatangan
                    @if($recruitmen->user->gender == 'P')
                        Saudara
                    @elseif($recruitmen->user->gender == 'W')
                        Saudari
                    @endif
                    pada:
                </td>
            </tr>
        </table>

        <!-- Tabel Jadwal -->
        <table class="table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center">Hari</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Jam</th>
                    <th class="text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
@if(!empty($jamHadirArray) && count($jamHadirArray) > 0)
        @foreach($jamHadirArray as $key => $jamHadir)
            <tr>
                @if($key === 0)
                    <td rowspan="{{ count($jamHadirArray) }}">
                        {{ \Carbon\Carbon::parse($recruitmen->tgl_hadir)->locale('id')->translatedFormat('l') }}
                    </td>
                    <td rowspan="{{ count($jamHadirArray) }}">
                        {{ $tgl_hadir }}
                    </td>
                @endif
                <td>{{ $jamHadir }} - {{ $jamSelesaiArray[$key] }} WIB</td>
                <td>{{ str_replace('"', '', trim($kegiatanArray[$key], '[]')) }} *</td>
            </tr>
        @endforeach
    @endif
    </tbody>
        </table>

        <!-- Catatan jadwal fleksibel dan tempat -->
        <div class="table-bordered">
            <p>Tempat: <b>{{$ruangan}}</b> {{$lokasi}} <br> 
               *) <i>Jadwal yang tertera bersifat fleksibel</i>
            </p>
        </div>

        <!-- Penutup dan tanda tangan -->
        <p>Demikian surat panggilan ini kami sampaikan, atas perhatiannya kami ucapkan terima kasih.</p>

        <div class="col" style="margin-left: 450px; margin-top: 30px;">
            <div>
                <table class="table is-striped table-borderless "
                    style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
                    <tr>

                        <td style="width: 50%; ">
                            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                Surabaya, {{$tgl_pengajuan}}</p>

                            <div style="font-weight: bold; margin-top: 15px;font-size:12px">Hormat Kami,</div>
                            <br>                            <br>                            <br>                            <br>                            <br>

                            <div
                                style=" margin-top: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                <b><u>{{ $admin->nama }}</u></b><br>
                                <b>NIP. {{ $admin->NIP }}</b>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
