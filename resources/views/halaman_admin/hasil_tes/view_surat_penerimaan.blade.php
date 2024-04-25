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
                <td>: {{ $hasil_tes->no_doku }}<br> : Pemberitahuan Penerimaan Tenaga Kependidikan
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
                    Sdr/Sdri {{ $hasil_tes->rekrutmen->pemohon }} <br> di tempat,
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
                <td> Berdasarkan hasil psikotes dan wawancara yang telah Saudara ikuti.
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -10px;">
            <tr>
                <td>Nama<br>Tempat/Tgl. Lahir<br>Alamat</td>
                <td>: {{ $hasil_tes->rekrutmen->pemohon }}<br> : {{ $hasil_tes->tempat_lahir }}, {{ $tgl_lahir }}
                    <br>: {{ $hasil_tes->alamat }}
                </td>
            </tr>

        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -25px;">
            <tr>

            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -5px;">
            <tr>
                <td>Dengan ini kami nyatakan bahwa Saudara/Saudari dapat bergabung di Universitas Katolik Darma Cendika
                    mulai tanggal {{ $tgl_kerja }}. Saudara/Saudari diterima sebagai @if ($hasil_tes->rekrutmen->jabatan_pelamar == 'Karyawan')
                        tenaga kependidikan yang ditempatkan pada {{ $hasil_tes->rekrutmen->departemen }} dengan masa
                        percobaan 3 bulan dan selanjutnya akan dilakukan penilaian.
                    @elseif ($hasil_tes->rekrutmen->jabatan_pelamar == 'Dosen')
                        tenaga kependidikan yang ditempatkan pada {{ $hasil_tes->rekrutmen->departemen }} dengan masa
                        percobaan 6 bulan dan selanjutnya akan dilakukan penilaian.
                    @endif
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="width: auto; font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin-left: -5px; margin-top: -10px;">
            <tr>
                <td>Adapun rincian tugas dapat dikomunikasikan dengan Kepala Unit Kerja BAA UKDC
                    tempat Saudara/Saudari bertugas. Atas perhatian serta kerjasamanya kami ucapkan terimakasih.
                </td>
            </tr>
        </table>
        <div class="col" style="margin-left: 1000px; margin-top: -10px;">
            <div>
                <table class="table is-striped table-borderless "
                    style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
                    <tr>

                        <td style="width: 50%; ">
                            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
                                Hormat kami,</p>

                            <div style="font-weight: bold; margin-top: -15px;">Ka. Biro Administrasi Umum</div>
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
