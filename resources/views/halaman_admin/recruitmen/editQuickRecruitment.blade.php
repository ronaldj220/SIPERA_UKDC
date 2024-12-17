@php
    date_default_timezone_set('Asia/Jakarta');
@endphp

@php
$existingDetails = [
            // Data jam_hadir, jam_selesai, kegiatan dari data rekrutmen yang ada
            ['jam_hadir' => $recruitmen->jam_hadir, 'jam_selesai' => $recruitmen->jam_selesai, 'kegiatan' => $recruitmen->kegiatan],
    
];
$countKegiatan = count($existingDetails[0]['kegiatan']);

@endphp

@include('layouts.halaman_admin.header')

<body class="with-welcome-text">
    <div class="container-scroller">
        @include('layouts.halaman_admin.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts.halaman_admin.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-10 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-lg-8 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="text-center">Ajukan Surat Pemanggilan Tes dan Wawancara</h4>
                                            <p class="card-description text-center">
                                                Digunakan pada saat pemanggilan tes dan wawancara
                                            </p>
                                            <form
                                                action="{{ route('admin.recruitment.updateQuickRecruitment', $recruitmen->id) }}"
                                                method="post" id="myForm">
                                                @csrf
                                                <div class="form-floating mb-3">
                                                    <input type="date" class="form-control" id="floatingInput"
                                                        placeholder="Masukkan Departemen" name="tgl_hadir"
                                                        value="{{ old('tgl_hadir',  $recruitmen->tgl_hadir) }}">
                                                    <label for="floatingInput">Tanggal Hadir</label>
                                                </div>
                                                @error('tgl_hadir')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="form-group mt-3">
                                                    <label for="exampleFormControlSelect1">Lokasi Wawancara</label>
                                                    <select name="lokasi_wawancara" id="lokasi_wawancara" class="form-control">
                                                        <option value=""> --- Pilih --- </option>
                                                        @foreach ($lokasiWawancara as $item)
                                                            <option value="{{ $item->id }}" {{ old('lokasi_wawancara', $recruitmen->id_lokasi_wawancara) == $item->id ? 'selected' : '' }}>{{ $item->lokasi }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('lokasi_wawancara')
                                                    <div class="alert alert-danger"><span class="mdi mdi-alert-circle">
                                                            &nbsp;{{ $message }}</span></div>
                                                @enderror
                                                <div class="row" id="detail">
                                                    @foreach($existingDetails as $index => $detail)
    <div class="form-group col-md-3">
        <label for="jam_hadir_{{$index}}">Jam Hadir</label>
        <input type="time" class="form-control" name="jam_hadir[]" value="{{ old('jam_hadir.' . $index, is_array($detail['jam_hadir']) ? $detail['jam_hadir'][0] : $detail['jam_hadir']) }}">
    </div>
    <div class="form-group col-md-3">
        <label for="jam_selesai_{{ $index }}">Jam Selesai</label>
        <input type="time" class="form-control" name="jam_selesai[]" value="{{ old('jam_selesai.' . $index, is_array($detail['jam_selesai']) ? $detail['jam_selesai'][0] : $detail['jam_selesai']) }}">
    </div>
    <div class="form-group col-md-3">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name='kegiatan[]' value="{{ str_replace(['[', ']', '"'], '', old('kegiatan.' . $index, is_array($detail['kegiatan']) ? $detail['kegiatan'][0] : $detail['kegiatan'])) }}">
            <label for="floatingInput kegiatan_{{ $index }}">Kegiatan</label>
        </div>
    </div>

    <div class="form-group col-md-3">
        @if ($index == 0)
            <a href="javascript:;" class="btn btn-info form-group btn-sm" style="margin-bottom: -50px;" onclick="addDetail()">Add Detail</a>
        @else
            <button name="delete{{ $index }}" id="delete{{ $index }}" class="btn btn-danger btn-sm" type="button" onclick="deleteRow(this);" style="margin-bottom: -50px;">Hapus</button>
        @endif
    </div>
@endforeach

                                                <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                                    <button class="btn btn-rounded btn-primary" id="submitBtn"
                                                        type="button">Simpan</button>
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
    <script>
        document.getElementById('submitBtn').addEventListener('click', function() {
            Swal.fire({
                title: "Do you want to save the changes?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    document.getElementById('myForm').submit();
                }
            });
        });
    </script>

    <script>
        let no = {{ $countKegiatan }};

        function addDetail() {
    var detail = document.getElementById('detail');
    var newRow = document.createElement('div');

    newRow.innerHTML = `
        <div class="row">
            <div class="form-group col-md-3">
                <label for="jam_hadir_${no}">Jam Hadir</label>
                <input type="time" class="form-control" name="jam_hadir[]" id="jam_hadir_${no}">
            </div>
            <div class="form-group col-md-3">
                <label for="jam_selesai_${no}">Jam Selesai</label>
                <input type="time" class="form-control" name="jam_selesai[]" id="jam_selesai_${no}">
            </div>
            <div class="form-group col-md-3">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="kegiatan[]" id="kegiatan_${no}">
                    <label for="kegiatan_${no}">Kegiatan</label>
                </div>
            </div>
            <div class="form-group col-md-3">
                <button name="delete${no}" id="delete${no}" class="btn btn-danger btn-sm" type="button" onclick="deleteRow(this);" style="margin-bottom: -50px;">Hapus</button>
            </div>
        </div>
    `;
    detail.appendChild(newRow);
    no++;  // Increment the counter after adding a new row
}

        function deleteRow(button) {
            // Dapatkan elemen induk dari tombol yang diklik (yaitu <tr>)
            let row = button.parentNode.parentNode;

            // Dapatkan elemen tabel yang berisi baris yang ingin dihapus
            let table = row.parentNode;

            // Hapus baris dari tabel
            table.removeChild(row);
        }
    </script>
</body>

</html>
