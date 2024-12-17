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
                <td>: {{ $hasil_tes->no_doku }}<br> : Pemberitahuan Penerimaan Tenaga Kependidikan
                </td>
                <td style="width: 25%; margin-top:-20px">
                    <p>
                        {{ $tgl_pengajuan }}
                    </p>
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;margin-top:10px">
            <tr>
                <td>Kepada Yth. <br>
                    @if($hasil_tes->rekrutmen->user->gender=='P')
                        Sdr. {{$pemohon}}
                    @elseif($hasil_tes->rekrutmen->user->gender=='W')
                        Sdri. {{$pemohon}}
                    @endif
                    <br> di tempat,
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm"
            style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin-top: 10px;">
            <tr>
                <td>Dengan hormat,
                </td>
            </tr>
        </table>
        
        <table class="table table-borderless table-sm"
            style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin-left: 30px; margin-top: 10px; text-align: justify">
            <tr>
                <td> Berdasarkan hasil psikotes dan wawancara yang telah 
                    @if($hasil_tes->rekrutmen->user->gender=='P')
                        Saudara
                    @elseif($hasil_tes->rekrutmen->user->gender=='W')
                        Saudari
                    @endif
                ikuti.
                </td>
            </tr>
        </table>

        <table class="table table-borderless table-sm"
            style="width: 50%; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin-top: 10px;">
            <tr>
                <td>Nama<br>Tempat/Tgl. Lahir<br>Alamat</td>
                <td>: {{ $pemohon }}<br> : {{ $tempat_lahir }}, {{$tgl_lahir}} 
                    <br>: {{ $hasil_tes->rekrutmen->user->alamat }}
                </td>
            </tr>
        </table>

        <table class="table table-borderless table-sm"
            style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin-top: 10px; text-align:justify">
            <tr>
                <td>Dengan ini kami nyatakan bahwa 
                    @if($hasil_tes->rekrutmen->user->gender=='P')
                        Saudara
                    @elseif($hasil_tes->rekrutmen->user->gender=='W')
                        Saudari
                    @endif
                dapat bergabung di Universitas Katolik Darma Cendika
                    mulai tanggal <b>{{ $tgl_kerja }}</b>. 
                        @if($hasil_tes->rekrutmen->user->gender=='P')
                            Saudara
                        @elseif($hasil_tes->rekrutmen->user->gender=='W')
                            Saudari
                        @endif
                    diterima sebagai {{$statusPegawai}} yang ditempatkan sebagai {{$unitKerja}} pada {{$lowongan}}, dengan masa percobaan {{$lamaPosisiLamaran}} dan selanjutnya akan dilakukan penilaian.
                </td>
            </tr>
        </table>
        
        <table class="table table-borderless table-sm"
            style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin-top: 10px">
            <tr>
                <td>
                    Adapun rincian tugas dapat dikomunikasikan dengan Kepala Unit Kerja BAA UKDC tempat 
                        @if($hasil_tes->rekrutmen->user->gender=='P')
                            Saudara
                        @elseif($hasil_tes->rekrutmen->user->gender=='W')
                            Saudari
                        @endif
                    bertugas. Atas perhatian serta kerjasamanya kami ucapkan terimakasih.
                </td>
            </tr>
        </table>
        
        <div class="col" style="margin-left: 500px; margin-top: 30px;">
            <div>
                <table class="table is-striped table-borderless "
                    style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
                    <tr>

                        <td style="width: 50%; ">
                            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
                                Hormat kami,</p>

                            <div style="font-weight: bold; margin-top: -15px;">Ka. Biro Administrasi Umum</div>
                            <br>                            <br>                            <br>                            <br>                            <br>

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
</body>

</html>
