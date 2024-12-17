<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sistem Informasi Perekrutan Pegawai (UKDC) | {{ $title }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="shortcut icon" href="https://ukdc.ac.id/wp-content/uploads/2022/07/cropped-logo-kecil-32x32.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset2') }}/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('asset2') }}/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('asset2') }}/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset2') }}/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset2') }}/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset2') }}/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset2') }}/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset2') }}/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset2') }}/css/util.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset2') }}/css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{ asset('asset2') }}/images/bg-01.jpg');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form class="login100-form validate-form" method="POST" action="{{ route('aksilupapass') }}">
                    @csrf
                    <span class="login100-form-title" style="margin-bottom: 50px">
                        <p style="text-transform: uppercase; font-weight: bold; font-size: 17px">
                            Sistem Informasi Perekrutan Pegawai</p>
                        <p style="font-size: 14px; margin-top: 10px;">Silakan login untuk melanjutkan atau kembali ke <a href="{{ route('home') }}">Beranda</a></p>

                    </span>

                    <div class="wrap-input100 validate-input m-b-23" data-validate = "Email is required">
                        <span class="label-input100">Email</span>
                        <input class="input100" type="email" name="email" placeholder="Type your email">
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
                    </div>

                    <div class="container-login100-form-btn" style="margin-top: 20px">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn">
                                Reset Password
                            </button>
                        </div>
                    </div>
                    <div class="container-login100-form-btn" style="margin-top: 20px">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <a href={{route('login')}} class="login100-form-btn">
                                Login
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="{{ asset('asset2') }}/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('asset2') }}/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('asset2') }}/vendor/bootstrap/js/popper.js"></script>
    <script src="{{ asset('asset2') }}/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('asset2') }}/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('asset2') }}/vendor/daterangepicker/moment.min.js"></script>
    <script src="{{ asset('asset2') }}/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('asset2') }}/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('asset2') }}/js/main.js"></script>

    @include('sweetalert::alert')
</body>

</html>
