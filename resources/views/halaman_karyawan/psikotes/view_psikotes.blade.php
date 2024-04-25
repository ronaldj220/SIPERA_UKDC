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
                <td>Nomor<br>Hal</td>
                <td>: {{ $psikotes->no_doku_psikotes }}<br> : Pemberitahuan untuk Mengikuti Psikotes
                </td>
            </tr>
        </table>
        <div class="col" style="margin-left: 1000px; margin-top: -60px;">
            <div>
                <table class="table is-striped table-borderless "
                    style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
                    <tr>

                        <td style="width: 25%; ">
                            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">

                                {{ $tgl_pengajuan }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px;">
            <tr>
                <td>Kepada Yth. <br>
                    {{ $psikotes->rekrutmen->pemohon }} <br> di tempat,
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -10px;">
            <tr>
                <td>Dengan hormat,
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -10px; text-align: justify">
            <tr>
                <td> Berdasarkan hasil Evaluasi Panitia Seleksi Penerimaan Calon Dosen/Karyawan UKDC No.
                    {{ $psikotes->no_doku_rektor }}, dengan ini kami sampaikan bahwa anda telah lolos Tahap Tes
                    Potensi Akademik dan Wawancara, dan dapat mengikuti tahap Psikotest.
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -10px; text-align: justify">
            <tr>
                <td> Psikotes akan dilakukan pada :
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -10px;">
            <tr>
                <td>Hari<br>Tanggal<br>Waktu<br>Tempat</td>
                <td>: {{ $psikotes->rekrutmen->pemohon }}<br> : {{ $tgl_hadir }} <br> :
                    {{ substr($psikotes->jam_hadir, 0, 5) }} WIB<br> : {{ $psikotes->lokasi_hadir }}
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -10px;">
            <tr>
                <td>Mohon anda hadir 15 menit sebelumnya dengan membawa KTP. Kondisi fisik yang baik akan
                    menentukan keberhasilan anda. Mengingat saat ini dalam masa pandemi <i>Covid-19</i>, dimohon
                    untuk mematuhi aturan protokol Kesehatan.
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -10px;">
            <tr>
                <td>Demikian kami sampaikan, atas perhatiannya kami ucapkan terima kasih.
                </td>
            </tr>
        </table>
        <br>
        <table class="table is-striped table-borderless "
            style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; margin-left: -10px; ">
            <tr>

                <td>

                    <div style="font-weight: bold; margin-top: -15px;">Kepala Biro Administrasi Umum</div>
                    <div style="margin-top: 100px"></div>

                    <div style=" margin-top: -10px; font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
                        <b><u>{{ $admin->nama }}</u></b><br>
                        <b>NIP. {{ $admin->NIP }}</b>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
