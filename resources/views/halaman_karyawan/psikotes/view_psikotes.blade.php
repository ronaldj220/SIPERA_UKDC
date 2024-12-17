<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Perekrutan Pegawai ({{ $karyawan->role_name }}) | {{ $title }}</title>
    <link rel="shortcut icon" href="https://ukdc.ac.id/wp-content/uploads/2022/07/cropped-logo-kecil-32x32.png" />
    
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
    </style>

</head>

<body>
    <div>
        <br><br><br><br><br><br><br>
        <table class="table-borderless" style="width: 100%">
            <tr>
                <td>Nomor<br>Hal</td>
                <td>: {{ $psikotes->no_doku_psikotes }}<br> : Pemberitahuan untuk mengikuti Psikotest
                </td>
                <td style="width: 25%; ">
                    <p>
                        Surabaya, {{ $tgl_pengajuan }}
                    </p>
                </td>
            </tr>
        </table>
        <br>
        <table class="table-borderless"
            style="">
            <tr>
                <td>Kepada Yth. <br>
<span style="font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;">
{{ $pemohon }} <br>di tempat,
</span></td>
            </tr>
        </table>
        <table class="table-borderless"
            style="margin-top: 10px;">
            <tr>
                <td>Dengan hormat,
                </td>
            </tr>
        </table>
        <table class="table-borderless"
            style="text-align: justify">
            <tr>
                <td> Berdasarkan hasil Evaluasi Panitia Seleksi Penerimaan Calon Dosen/Karyawan UKDC No. {{$psikotes->no_doku_rektor}}, dengan ini kami sampaikan bahwa anda telah lolos Tahap Tes Potensi Akademik dan Wawancara, dan dapat mengikuti tahap Psikotes.
                </td>
            </tr>
        </table>
        <table class="table-borderless table-sm"
            style="margin-top: 10px;">
            <tr>
                <td>Psikotes akan dilakukan pada:<br></td>
            </tr>
        </table>
        <table class="table-borderless"
            style="margin-top: 10px; width:100%">
            <tr>
                <td>Hari<br>Tanggal<br>Waktu<br>Tempat</td>
                <td>: {{ $hari_hadir }}<br> : {{ $tgl_hadir }} <br> :
                    {{ $jam_hadir }} <br> : {{ $lokasi_psikotes }} <br> {{$alamat_psikotes}} ({{$ruangan_psikotes}})
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style=" margin-top: 10px;">
            <tr>
                <td>Mohon anda hadir 15 menit sebelumnya dengan membawa KTP. Kondisi fisik yang baik akan menentukan keberhasilan anda. Mengingat saat ini dalam masa <i>pandemic Covid-19</i>, dimohon untuk mematuhi aturan protokol Kesehatan.</b>
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="margin-top: 10px;">
            <tr>
                <td>Demikian kami sampaikan, atas perhatiannya kami ucapkan terima kasih.
                </td>
            </tr>
        </table>
        <table class="table is-striped table-borderless " style="margin-top:30px">
            <tr>
                <td>

                    <div style="font-weight: bold; margin-top: 15px; font-size: 12px;">Kepala Biro Administrasi Umum</div>
                    <br> <br><br><br><br><br>
                    <div style=" margin-top: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                        <b><u>{{ $admin->nama }}</u></b><br>
                    </div>
                </td>
            </tr>
        </table>
        @if (!empty($psikotes->link_psikotes))
        <table class='table-borderless' style="margin-top:100px">
            <tr>
                <td>Note: Harap mengisi Google Form di {{ $psikotes->link_psikotes }}</td>
            </tr>
        </table>
        @endif
    </div>
</body>

</html>