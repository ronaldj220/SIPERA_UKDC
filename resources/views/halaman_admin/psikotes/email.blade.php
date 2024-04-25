<!DOCTYPE html>
<html>

<head>
    <title>Pemberitahuan Hasil Psikotes</title>
</head>

<body>
    <div style="border : 2px solid black; margin : 20px auto; width: 500px">
        <p style='font-size : 25px; font-family : sans-serif;text-align : center;'>
            Pemberitahuan</p><br>
        <p style="text-align: justify; margin-top: 20px; font-size: 16px;">
            Hai, {{ $namaPelamar }} <br><br>
            @if ($statusPelamar == 'approved')
                <p>Selamat! Hasil Psikotes anda telah diterima dalam proses lamaran.</p> <br>
                <a href="{{ route('karyawan.beranda') }}" style="color: #3490dc;">Lihat Informasi Lebih Lanjut</a><br>
            @elseif ($statusPelamar == 'rejected')
                <p>Maaf, Hasil Psikotes anda ditolak. Kami menyarankan Anda untuk mempersiapkan diri lebih baik untuk
                    peluang
                    lainnya.</p> <br>
            @endif

            @if ($statusPelamar == 'approved')
                Terima kasih atas ketertarikan dan partisipasi Anda dalam proses seleksi kami. Kami berharap dapat
                bermitra dengan Anda dalam perjalanan ini. <br><br>
            @elseif ($statusPelamar == 'rejected')
                Kami mengucapkan terima kasih atas partisipasi Anda dan kami menghargai waktu yang Anda luangkan untuk
                melamar. Semoga Anda sukses dalam perjalanan karir Anda yang lain. <br><br>
            @endif
            Salam, <br>
            Tim Rekrutmen Perusahaan

        </p>

        <p style='font-size : 12px;
					font-family : sans-serif;
					text-align : center;'> &copy; SIPERA (Sistem
            Informasi Perekrutan Pelamar)
            {{ date('Y') }}
        </p>
    </div>
</body>

</html>
