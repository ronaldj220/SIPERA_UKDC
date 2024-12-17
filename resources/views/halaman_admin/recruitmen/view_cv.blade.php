<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Perekrutan Pegawai UKDC ({{ $admin->role_name }}) | {{ $title }} </title>
    <link rel="shortcut icon" href="https://ukdc.ac.id/wp-content/uploads/2022/07/cropped-logo-kecil-32x32.png" />
</head>
<body>
    @if($fileType == 'image')
    <img src="{{ $cvDataUrl }}" alt="CV Image" />
@elseif($fileType == 'pdf')
    <iframe src="{{ $cvDataUrl }}" width="800" height="400"></iframe>
@else
    <p>Format file tidak dikenali.</p>
@endif

</body>
</html>
