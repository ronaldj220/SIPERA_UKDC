<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Perekrutan Pegawai UKDC | Beranda</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="https://ukdc.ac.id/wp-content/uploads/2022/07/cropped-logo-kecil-32x32.png" />
    
    <!-- SweetAlert CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        /* Smooth scrolling for the entire page */
        html {
            scroll-behavior: smooth;
        }
        
        /* General padding for the mobile view */
        @media (max-width: 768px) {
            body, .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            /* Adjust header and footer padding */
            header .container, footer .container {
                padding-left: 0;
                padding-right: 0;
            }
    
            /* Add space around mobile menu items */
            #mobile-menu a {
                padding: 1rem 0;
            }
    
            /* Adjust card margins for smaller screens */
            .card {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>
<body class="bg-light">

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="container py-3 d-flex justify-content-between align-items-center">
            <h1 class="text-primary fw-bold mb-0" style="font-size:24px">Perekrutan Pegawai</h1>
            <nav class="d-none d-md-flex gap-3">
                <a href="" class="text-dark">Beranda</a>
                <a href="#about_us" class="text-dark">Tentang Kami</a>
                <a href="#how_to_use" class="text-dark">Cara Kerja</a>
                <a href="#lowongan" class="text-dark">Lowongan</a>
                <a href="{{route('login')}}" class="text-dark">Login</a>
                <a href="{{route('sign_up')}}" class="text-dark">Buat Akun</a>
            </nav>
            <button class="btn btn-light d-md-none" id="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <nav id="mobile-menu" class="d-md-none d-none bg-light py-3 px-3">
            <a href="#" class="d-block text-dark py-3">Beranda</a>
            <a href="#lowongan" class="d-block text-dark py-3">Lowongan</a>
            <a href="{{route('login')}}" class="d-block text-dark py-3">Login</a>
            <a href="{{route('sign_up')}}" class="d-block text-dark py-3">Buat Akun</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Temukan Karier Impian Anda dengan Mudah</h1>
            <p class="lead">Bergabunglah dengan kami dan wujudkan karier impian Anda bersama sistem perekrutan yang mudah dan transparan!</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#lowongan" class="btn btn-secondary">Lihat Lowongan</a>
                <a href="{{route('sign_up')}}" class="btn btn-light text-primary">Daftar Sekarang</a>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="py-5" id="about_us">
        <div class="container">
            <h2 class="display-5 text-center fw-bold">Mengapa Memilih Sistem Kami?</h2>
            <div class="row text-center mt-4">
                <div class="col-md-3">
                    <div class="card p-3 shadow-sm">
                        <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                        <h5>Proses Cepat dan Mudah</h5>
                        <p>Lamaran bisa diajukan dalam beberapa langkah mudah dan cepat.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 shadow-sm">
                        <i class="fas fa-eye fa-3x text-primary mb-3"></i>
                        <h5>Transparansi Proses</h5>
                        <p>Pantau status lamaran Anda secara real-time.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 shadow-sm">
                        <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                        <h5>Keamanan Data Terjamin</h5>
                        <p>Data Anda aman dengan enkripsi terbaru.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 shadow-sm">
                        <i class="fas fa-globe fa-3x text-primary mb-3"></i>
                        <h5>Akses dari Mana Saja</h5>
                        <p>Lamaran bisa dilakukan kapan saja dan di mana saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5 bg-light" id="how_to_use">
        <div class="container">
            <h2 class="display-5 text-center fw-bold">Cara Kerja Kami</h2>
            <div class="row text-center mt-4">
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                        <h5>Daftar Akun</h5>
                        <p>Buat akun dan lengkapi profil Anda.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>
                        <h5>Lengkapi Dokumen</h5>
                        <p>Unggah CV, transkrip, dan dokumen lainnya.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <i class="fas fa-check fa-3x text-primary mb-3"></i>
                        <h5>Proses Seleksi</h5>
                        <p>Ikuti proses seleksi sesuai dengan tahapan yang ada.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Back to Top Button -->
    <a href="" class="btn btn-primary position-fixed bottom-0 end-0 m-4" id="back-to-top" style="display: none;">
        <i class="fas fa-arrow-up"></i>
    </a>
    
    <!-- Lowongan Section -->
    <section class="py-5" id="lowongan">
        <div class="container text-center">
            <h2 class="display-5 fw-bold">Lowongan</h2>
        </div>
        @if($lowongan->isEmpty())
            <div class="container mt-4 mb-4">
                <p>Tidak ada lowongan terbaru saat ini.</p>
            </div>
        @else
            <div class="container">
                <div class="row">
                    @foreach($lowongan as $index => $item)
                        <div class="col-md-4 mb-4">
                            <div class="card" style="width: 100%;">
                                <div style="position:relative; display:inline-block">
                                    <img src="data:image/jpeg;base64,{{ $item->img_base_64 }}" class="card-img-top" alt="Lowongan {{ $item->name_lowongan }}" height="500">
                                    @if($item->link_lowongan)
                                        <div style="position: absolute; top: 375px; left: 20px;">
                                            {!! DNS2D::getBarcodeHTML($item->link_lowongan, "QRCODE", 4, 4) !!}
                                        </div>

                                    @endif
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->name_lowongan }}</h5>
                                    <strong>Kualifikasi:</strong> <br>
                                    <ol>
                                        @foreach($item->descriptionPart1 as $part)
                                            <li>{{ $part }}</li>
                                        @endforeach
                                    </ol>
                                    <div class="d-flex justify-content-center">
                                        <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalView{{ $item->id }}">
                                              Lihat Selengkapnya
                                            </button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="modalView{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalLabel{{ $item->id }}">Deskripsi Lowongan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <strong>Batas Waktu:</strong> {{ \Carbon\Carbon::parse($item->expired_at)->translatedFormat('d F Y') }}<br>
                                                    <strong>Kualifikasi:</strong> {!! $item->description !!}
                                                  </div>
                                                  <div class="modal-footer d-flex justify-content-center">
                                                      <button class="btn btn-danger" onclick="checkExpired('{{ $item->expired_at }}', '{{ $item->id }}', '{{$item->name_lowongan}}')">Ajukan Lamaran</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @if(($index + 1) % 3 == 0)
                            </div><div class="row mt-4">
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
    </section>
    
    <footer class="bg-dark text-light py-4">
        <div class="container text-center">
            <p class="mb-1">© <?php echo date("Y"); ?> Sistem Informasi Perekrutan Pegawai UKDC. All rights reserved.</p>
            <div class="mt-3">
                <a href="https://wa.me/628883200055" target="_blank" class="d-inline-flex align-items-center text-success">
                    <i class="fab fa-whatsapp fs-4"></i>
                    <span class="ms-2">Hubungi Kami via WhatsApp</span>
                </a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
     <script>
        // Show the Back to Top button when scrolling down
        const backToTopBtn = document.getElementById('back-to-top');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 200) {
                backToTopBtn.style.display = 'block';
            } else {
                backToTopBtn.style.display = 'none';
            }
        });
        
        // Smooth scroll to the top when clicking the Back to Top button
        backToTopBtn.addEventListener('click', (event) => {
            event.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
    
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('d-none'); // Toggle visibility
        });
        
        const checkExpired = (expiredAt, lowonganId, nameLowongan) => {
            const currentDate = new Date();
            const expiredDate = new Date(expiredAt);
            const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

            
            if(currentDate > expiredDate){
                swal({
                    title: "Mohon Maaf",
                    text: `Lowongan untuk ${nameLowongan} telah berakhir!`,
                    icon: "error",
                    buttons: {
                        confirm: {
                            text: "Tutup",
                            value: true,
                            visible: true,
                            className: "bg-indigo-600 text-white rounded-md px-4 py-2",
                            closeModal: true // jika diinginkan, ini akan menutup modal
                        }
                    },
                });
            } else if(!isLoggedIn){
                swal({
                    title: "Perhatian",
                    text: "Anda harus login terlebih dahulu untuk mengajukan lamaran.",
                    icon: "warning",
                    buttons: false, // Tidak ada tombol
                    timer: 2000, // Waktu dalam milidetik sebelum otomatis redirect ke login (3 detik),
                }).then(() => {
                    window.location.href = "{{ route('login') }}"; // Ganti dengan URL login yang sesuai
                });
            }
        }


    </script>
</body>
</html>
