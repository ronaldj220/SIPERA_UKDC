@include('layouts.halaman_admin.header')

<body class="with-welcome-text">
    <div class="container-scroller">
        @include('layouts.halaman_admin.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts.halaman_admin.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-lg-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Edit Lowongan</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada saat lowongan dibuka di halaman pelamar
                                            </p>
                                            <form action="{{ route('admin.lowongan.update_lowongan', $lowongan->id) }}"
                                                method="post" id="myForm">
                                                @csrf
<div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name='name_lowongan' value="{{ old('name_lowongan', $lowongan->name_lowongan) }}">
  <label for="floatingInput">Name Lowongan</label>
</div>
<div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name='link_lowongan' value="{{ old('link_lowongan', $lowongan->link_lowongan) }}">
  <label for="floatingInput">Link Lowongan</label>
</div>
<div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name='lokasi_lowongan' value="{{ old('lokasi_lowongan', $lowongan->lokasi_lowongan) }}">
  <label for="floatingInput">Lokasi Lowongan</label>
</div>
                                            <div class="">
                                                 <label for="">Description</label>
                                                <textarea class="form-control" placeholder="Leave a comment here" name='desc_lowongan' id="desc_lowongan">
                                            {!! $lowongan->description !!}
                                                </textarea>
                                            </div>
                                            <div class='row g-2'>
                                                <div class="form-floating mt-3 @error('created_at') is-invalid @enderror">
    <input type="date" class="form-control" id="createdDate" name='created_at' value="{{ old('created_at', $lowongan->created_at) }}">
    <label for="createdDate">Created Date</label>
</div>
                                        @error('created_at')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                        @enderror
                                                
<div class="form-floating mt-3">
    <input type="date" class="form-control @error('expired_at') is-invalid @enderror" id="expiredDate" name='expired_at' value="{{ old('expired_at', $lowongan->expired_at) }}">
    <label for="expiredDate">Expired Date</label>
</div>
                                            </div>
                                            @error('expired_at')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                        @enderror
                                            <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Perbarui Lowongan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                @include('layouts.halaman_admin.footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    @include('layouts.halaman_admin.script')
    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#desc_lowongan').summernote({
                height: 200, // Set editor height
                placeholder: 'Description about job...',
                toolbar: [
                    // Customize your toolbar
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', [ 'ol', 'paragraph']],
                    ['insert', ['link']],
                ]
            });

            document.getElementById('submitBtn').addEventListener('click', function() {
                Swal.fire({
                    title: "Do you want to save the changes?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    denyButtonText: `Don't save`
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('myForm').submit();
                    }
                });
            });
        });
    </script>
</body>

</html>
