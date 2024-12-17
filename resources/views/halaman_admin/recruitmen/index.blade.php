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
                                <div class="col-lg-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Daftar Rekrutmen</h4>
                                            <p class="card-description text-center">
                                                Daftar proses pelamar kerja
                                            </p>
                                            <div class="mb-3 d-flex justify-content-between">
                                                <a class="btn btn-rounded btn-success" href="{{route('admin.export_recruitmen')}}">Export Data Pelamar</a>
                                                
                                                <div class="d-flex">
                                                    <input type='search' class="form-control" placeholder="Search Document Here" name='q' id='search' />
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                @include('halaman_admin.recruitmen.tableRecrutment', $recruitmen)
                                                
                                                @if($recruitmen->count() > 0)
                                                    <div class="row">
                                                        <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                                            <div>
                                                                Showing {{ $recruitmen->firstItem() }} to {{ $recruitmen->lastItem() }} of {{ $recruitmen->total() }} entries
                                                            </div>
                                                            {!! $recruitmen->appends(Request::except('page'))->render() !!}
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center mt-4 mb-4">
                                                            <p>No entries found.</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
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
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
        
        $(document).ready(function(){
    $('#search').on('keyup', function(){
        let result = $(this).val();
        $.ajax({
            url: "{{ route('admin.recruitment.search') }}",
            type: "GET",
            data: {
                r: result
            },
            success: function(data) {
                // Clear existing results
                $('#search-results tbody').empty();
                
                // Append new results
                if (data.data.length > 0) {
                    data.data.forEach(function(item, index) {
                        // Format tanggal pengajuan menggunakan JavaScript
                        let tgl_pengajuan = new Date(item.tgl_pengajuan);
                        let formattedDate = tgl_pengajuan.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        
                        // Menentukan status approval
                        let statusBadge = '';
                        if(item.status_approval === 'submitted'){
                            statusBadge = '<label class="badge badge-danger" style="font-size: 1.2em">Submitted</label>';
                        } else if(item.status_approval === 'pending'){
                            statusBadge = '<label class="badge badge-warning" style="font-size: 1.2em">Pending</label>';
                        } else if(item.status_approval){
                            statusBadge = '<label class="badge badge-success" style="font-size: 1.2em">Approved</label>';
                        } else if(item.status_approval === 'rejected'){
                            statusBadge = '<label class="badge badge-danger" style="font-size: 1.2em">Rejected</label>';
                        }
                        
                        $('#search-results tbody').append(`
                            <tr>
                                <td>
                                    <a href="{{url('admin/recruitmen/view_recruitmen')}}/${item.id}">${item.no_doku}</a>
                                </td>
                                <td>${item.user.nama}</td>
                                <td>${formattedDate}</td>
                                <td>${statusBadge}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        ${generateActionButtons(item)}
                                    </div>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    $('#search-results tbody').append('<tr><td colspan="5" class="text-center">No entries found.</td></tr>');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Display the error in the console
                console.log("AJAX Error: ", textStatus, errorThrown);
                console.log("Response Text: ", jqXHR.responseText);
                
                // Optionally, show a user-friendly message in the UI
                $('#search-results tbody').empty();
                $('#search-results tbody').append('<tr><td colspan="5" class="text-center">Error retrieving results. Check console for details.</td></tr>');
            }
        });
    });
    
    function generateActionButtons(item){
        let actionButtons = '';
        if(item.status_approval === 'submitted'){
            actionButtons = `
                <a href="{{ url('admin/recruitmen/view_transkrip') }}/${item.id}" class="btn btn-rounded btn-success"><span class='mdi mdi-eye'></span></a>
                &nbsp;
                <a href="{{ url('admin/recruitmen/verify_recruitmen') }}/${item.id}" class="btn btn-rounded btn-success"><span class='mdi mdi-check'></span></a>
                &nbsp;
                <a href="{{ url('admin/recruitmen/tolak_recruitmen') }}/${item.id}" class="btn btn-rounded btn-danger"><span class='mdi mdi-filter-remove'></span></a>
            `;
        } else if(item.status_approval === 'pending'){
            if(item.is_edited === 'true'){
                actionButtons = `
                    <a href="{{ url('admin/recruitmen/view_transkrip') }}/${item.id}" class="btn btn-rounded btn-success"><span class='mdi mdi-eye'></span></a>
                    &nbsp;
                    <a href="{{ url('/admin/recruitmen/edit_rekrutmen') }}/${item.id}" class="btn btn-rounded btn-info">Edit</a>
                `;
            } else if (item.is_edited === 'false') {
                actionButtons = `
                    <a href="{{ url('admin/recruitmen/view_transkrip') }}/${item.id}" class="btn btn-rounded btn-success"><span class='mdi mdi-eye'></span></a>
                    &nbsp;
                    <a href="{{ url('admin/recruitmen/verify_recruitmen') }}/${item.id}" class="btn btn-rounded btn-warning">Setujui</a>
                `;
            }
        } else if (item.status_approval === 'approved') {
            actionButtons = `<a href="{{ url('admin/recruitmen/send_doc') }}/${item.id}" class="btn btn-rounded btn-warning">Kirim Email</a>`;
        } else if (item.status_approval === 'rejected') {
            actionButtons = `<a href="{{ url('admin/recruitmen/send_doc') }}/${item.id}" class="btn btn-rounded btn-warning">Kirim Email</a>`;
        }
        return actionButtons;
    }
});

    </script>
</body>
@include('sweetalert::alert')

</html>