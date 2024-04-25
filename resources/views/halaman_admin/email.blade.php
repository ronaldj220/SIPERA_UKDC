<!DOCTYPE html>
<html>

<head>
    <title>Hasil Rekrutmen</title>
</head>

<body>
    <div style="border : 2px solid black; margin : 20px auto; width: 500px">
        <p style='font-size : 25px; font-family : sans-serif;text-align : center;'>
            Pemberitahuan</p><br>
        <p style="text-align: justify; margin-top: 20px; font-size: 16px;">
            Halo, {{ $namaPelamar }} <br><br>
            @if ($statusPelamar == 'approved')
                Kami dengan senang hati memberitahu Anda bahwa Anda telah berhasil melanjutkan ke tahap berikutnya dalam
                proses seleksi rekrutmen kami. <br><br>
                Tahap selanjutnya akan melibatkan serangkaian evaluasi tambahan untuk menilai kemampuan dan kualifikasi
                Anda
                lebih lanjut. Kami sangat menghargai partisipasi Anda dan berharap Anda dapat memberikan penampilan
                terbaik
                selama proses ini. <br><br>
                Untuk informasi lebih lanjut mengenai tahap selanjutnya dan instruksi yang diperlukan, silakan periksa
                email
                resmi kami. Pastikan untuk memeriksa folder "Promosi" atau "Spam" jika email tidak terlihat pada kotak
                masuk
                utama Anda. <br><br>
                <a href="{{ route('karyawan.beranda') }}" style="color: #3490dc;">Lihat Informasi Lebih Lanjut</a><br>
            @elseif ($statusPelamar == 'rejected')
                Kami ingin memberitahu Anda bahwa setelah pertimbangan yang cermat, kami memutuskan untuk tidak
                melanjutkan proses seleksi dengan Anda pada tahap ini. <br><br>
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
					text-align : center;'> &copy; SILAMAR (Sistem
            Informasi Pelamar)
            {{ date('Y') }}
        </p>
    </div>
</body>

</html>
