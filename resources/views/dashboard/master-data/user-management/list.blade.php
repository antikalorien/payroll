@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar {{ ucfirst(request()->segment(3)) }}</h4>
                    </div>
                    <div class="row justify-content-end">
                    <div class="card-body pt-0 pb-0">
                    <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                        
                            </div>
                            
                            <div class="modal-body">
                                <form method="post" action="/dashboard/master/user-management/import-user" enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="file" name="file" class="form-control">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>
               
                                    <button type="button" onclick="location.href='{{ asset('assets/excel/sample-userManagement.xls') }}'" id="iBtnExportSample" class="btn btn-danger disabled">
                                        <i class="fas fa-file-export mr-2"></i>Download Sample
                                    </button>
                                    <button type="button" id="iBtnExport" class="btn btn-danger ">
                                        <i class="fas fa-file-export mr-2"></i>EXPORT
                                    </button>
                            </div>
          
                        </div>
                    </div>
                    </div>


                    <div class="card-body">
                    <table id="listTable" class="table table-striped table-bordered display nowrap" style="width: 100%">
                            <thead>
                            <tr>
                            <th>ID</th>
                                <th>Status</th>
                                <th>Departemen</th>
                                <th>Sub Departemen</th>
                                <th>Pos</th>
                                <th>Grade</th>
                                <th>ID Absen / Username</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Skema Hari Kerja</th>
                                <th>Total hari Kerja</th>
                                <th>Jam Kerja</th>
                                <th>Tanggal Bergabung</th>
                                <th>Masa Kerja</th>
                                <th>Tanggal Lahir</th>
                                <th>Usia</th>
                                <th>System</th>
                            </tr>
                            </thead>
                        </table>
                        <div class="thead-dark table-sm table-striped" id="listTable" style="width: 100%"></div>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-end">
                        <div class="col-sm-12 col-lg-3 mt-2 mt-lg-0">
                                <div class="btn-group btn-block mb-3" role="group" aria-label="Basic example">
                                    <button type="button" id="btnDisable" class="btn btn-danger ">
                                        <i class="fas fa-times mr-2"></i>Disable
                                    </button>
                                    <button type="button" id="btnActivate" class="btn btn-success ">
                                        <i class="fas fa-check mr-2"></i>Activate
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                                <button type="button" id="btnReset" class="btn btn-block btn-warning" disabled>
                                    <i class="fas fa-undo mr-2"></i>Reset Password
                                </button>
                            </div>
                            <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                                <button type="button" id="btnEdit" class="btn btn-block btn-primary" disabled>
                                    <i class="fas fa-pencil-alt mr-2"></i>Edit
                                </button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<link type="text/css" href="{{ asset('assets/jquery-datatables-checkboxes/css/dataTables.checkboxes.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{ asset('assets/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js')}}"></script>

<link href="{{ asset('assets/dist/css/select2.min.css')}}" rel="stylesheet" />
<script src="{{ asset('assets/dist/js/select2.min.js')}}"></script>
    <script type="text/javascript">
        const formFilter = $('#formFilter');
        const btnClearFilter = $('#btnClearFilter');
        const btnReset = $('#btnReset');
        let btnEdit = $('#btnEdit');
        const btnDisable = $('#btnDisable');
        const btnActivate = $('#btnActivate');
        let iProvider = $('#iProvider');
        let username = $('#iProvider');
        let listTable;

        const iBtnExport = $('#iBtnExport');


        $(document).ready(function () {
               
            let listTable = $('#listTable').DataTable({
                'columnDefs': [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                }
            ],
            'select': {
                'style': 'multi'
            },
                scrollX: true,
                bDestroy: true,
                order: [
                    [ 0, 'asc' ],
                ],
               ajax: {
                    url: "{{ url('dashboard/master/user-management/data') }}" 
                },
                columns: [
                    {data: 'id'},
                  
                    {data: 'status',
                        render: function(data, type) {
                            let color;
                        if (data == '1') {
                            status = 'ACTIVE';
                            color = 'green';
                        }
                        
                        else if (data == '2') {
                            status = 'NON ACTIVE';
                            color = 'red';
                        }
                        else {
                            status = 'Error Status';
                            color = 'orange';
                        }
                        return '<span style="color:' + color + '">' + status + '</span>';
                    }
                    },
                    {data: 'departemen'},
                    {data: 'subDepartemen'},
                    {data: 'pos'},
                    {data: 'grade'},
                    {data: 'idAbsen'},
                    {data: 'nip'},
                    {data: 'name'},
                    {data: 'idSkemaHariKerja'},
                    {data: 'jmlHari'},
                    {data: 'jamKerja'},
                    {data: 'doj'},
                    {data: 'masaKerja'},
                    {data: 'dob'},
                    {data: 'usia'},
                    {data: 'system',
                        render: function(data, type) {
                            let color;
                        if (data == '0') {
                            status = 'Karyawan & Super User';
                            color = 'green';
                        }
                        
                        else if (data == '1') {
                            status = 'Karyawan';
                            color = 'green';
                        }

                        else if (data == '2') {
                            status = 'Super User';
                            color = 'green';
                        }
                        return '<span style="color:' + color + '">' + status + '</span>';
                    }

                    },
                   
                ],
            });
            $('#listTable tbody').on('click','tr',function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    btnEdit.attr('disabled',true);
                    btnReset.attr('disabled',true);
                    dataID = null;
                } else {
                    listTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    btnEdit.removeAttr('disabled');
                    btnReset.removeAttr('disabled');
                    let data = listTable.row('.selected').data();
                    dataID = data.nip;
                }
             
            });

            });

            iBtnExport.click(function (e) {
                e.preventDefault();
                window.open('{{ url('dashboard/master-data/user-management/export') }}');
            });

            btnEdit.click(function (e) {
                e.preventDefault();
                //  let id = listTable.getSelectedData()[0].id;
           
                window.location = '{{ url('dashboard/master/user-management/edit') }}/'+dataID;
            });

            btnDisable.click(function (e) {
                e.preventDefault();
                let tables = $('#listTable').DataTable();
                    // Handle form submission event
                    var form = this;
                 
                    var rows_selected = tables.column(0).checkboxes.selected();
                    var array_select = [];
                    // Iterate over all selected checkboxes
                    $.each(rows_selected, function(tables, rowId){
                        // Create a hidden element
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', 'id[]')
                                .val(rowId)
                        );
                    array_select.push(rowId);
                    });
                    Swal.fire({
                    title: "Apakah ingin Disable data ini",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Disable'
                    }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('dashboard/master/user-management/disable') }}',
                            method: 'post',
                            data: {id: array_select},
                            success: function (response) {
                                console.log(response);
                                if (response === 'success') {
                                    Swal.fire({
                                        title: 'Data tersimpan!',
                                        type: 'success',
                                        onClose: function () {
                                              window.location.reload();
                                        }
                                    })
                                } else {
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: 'Silahkan coba lagi',
                                        type: 'error',
                                    })
                                }
                            }
                        });
                    }
                    });
            });

            btnReset.click(function (e) {
                e.preventDefault();
                // let username = listTable.getSelectedData()[0].username;
                Swal.fire({
                    title: 'Reset password?',
                    text: "Password akan sama seperti NIK",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Reset Password'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('dashboard/master/user-management/reset-password') }}',
                            method: 'post',
                            data: {username: dataID},
                            success: function (response) {
                                if (response === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Password berhasil direset',
                                        onClose(modalElement) {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    console.log(response);
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Gagal',
                                        text: 'Gagal reset Password, silahkan coba lagi.',
                                    });
                                }
                            },
                            error: function (response) {
                                console.log(response);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'System Error',
                                    text: 'Silahkan hubungi Developerf',
                                });
                            }
                        });
                    }
                })
            });



            btnActivate.click(function (e) {
                e.preventDefault();
                let tables = $('#listTable').DataTable();
                    // Handle form submission event
                    var form = this;
                 
                    var rows_selected = tables.column(0).checkboxes.selected();
                    var array_select = [];
                    // Iterate over all selected checkboxes
                    $.each(rows_selected, function(tables, rowId){
                        // Create a hidden element
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', 'id[]')
                                .val(rowId)
                        );
                    array_select.push(rowId);
                    });

                    console.log(array_select);

                    Swal.fire({
                    title: "Apakah ingin MengAktifkan data ini",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Active'
                    }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('dashboard/master/user-management/activate') }}',
                            method: 'post',
                            data: {id: array_select},
                            success: function (response) {
                                console.log(response);
                                if (response === 'success') {
                                    Swal.fire({
                                        title: 'Data tersimpan!',
                                        type: 'success',
                                        onClose: function () {
                                              window.location.reload();
                                        }
                                    })
                                } else {
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: 'Silahkan coba lagi',
                                        type: 'error',
                                    })
                                }
                            }
                        });
                    }
                    });
            });
    
    </script>
@endsection
