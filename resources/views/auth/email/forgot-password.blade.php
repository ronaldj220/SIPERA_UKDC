<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            width: 80%;
            font-family:'Raleway', sans-serif;
            color: black;
            background-color:#e9cfff;
            background-attachment:fixed;
            background-position:center;
            background-size:cover;
            font-weight: 300;
        }

        h1,h2,h3,h4,h5,h6{
            font-family:'Raleway', sans-serif;
            padding: 0.25px;
            margin: 0.25px;
        }

        button{
            font-weight: 400;
            text-align: center;
            vertical-align: middle; 
            background-color:#ddc2ff;
            border: 1px solid transparent;
            padding: 1rem 6rem;
            font-size: 1.25rem;
            line-height: 1;
            border-radius: 0.1875rem;
        }
    </style>
</head>
<body>
    <center>
        <div id="bodyEmail">
            <h2>Hi, {{ $users->nama }}</h3>
            <h3>Ada laporan pada website kami jika Anda lupa password akun Anda</h3>
            <h3>Silahkan klik tombol dibawah ini jika Anda melakukan permintaan untuk mereset password</h3>
            
            <br>
            <hr>

            <a href="{{ route('resetPassword') }}?{{ $data }}">
                <button type="button" class="btn btn-primary">Ganti Password</button>
            </a>

            <hr>
            <br>

            <h4>
                PERHATIAN!!!
            </h4>
            <h5>JANGAN SEBARKAN EMAIL INI KEPADA ORANG LAIN</h5>
            <br>
            <h5>
                SILAHKAN ABAIKAN EMAIL INI JIKA ANDA TIDAK MELAKUKAN PERMINTAAN INI
            </h5>
            <small>{{ $date }}</small>
            <br>
            <small>Copyright © Developer SIPERA (Sistem Informasi Perekrutan Pegawai)</small>
            <br>
        </div>
    </center>
</body>
</html>