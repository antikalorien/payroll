@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                <input type="text" id="iPic" name="pic" class="form-control" value="{{ request()->session()->get('name') }}" hidden>
                    <div class="card text-center" style="width: 100%;">
                            <img src="{{ asset('assets/logo/BG-HeaderAbsensi.jpg') }}" class="card-img">
                            <div class="card-img-overlay">
                                <h5 class="card-title">Syncronise Data Absen</h5>
                                <p class="card-text">---digunakan untuk mengambil data absensi dari Aplikasi LokaHR---</p>
                                
                            </div>        
                    </div>

                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid col px-md-5">
                            <a class="navbar-brand">
                                <img src="{{ asset('assets/img/avatar/setting.png') }}"  width="30" height="30" class="d-inline-block align-top" alt="">
                                Control Data
                            </a>  
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">

                  
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 px-2">
                            <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
                                Action Data
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" id="iRemoveSelectedCheckbox">Remove Selected Checkbox</a>
                                <a class="dropdown-item" id="iRemoveAll">Remove All</a>
                            </div>
                            </div>
                           
                        </ul>
              
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 px-2">
                        <button type="button"  id="btnSyncronise" class="btn btn-primary"><i class="fas fa-undo mr-2"></i>Get Data</button>
                        </ul>
                        </div>
                    </div>
                    </nav>

                    <div class="card-body">
                    <table id="listTable" class="table table-striped table-bordered display nowrap" style="width: 100%">
                            <thead>
                            <tr>
                            <th>ID</th>
                                <th>ID Periode</th>
                                <th>Departemen</th>
                                <th>Sub Departemen</th>
                                <th>Pos</th>
                                <th>Grade</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Tipe Kontrak</th>
                                <th>Skema</th>
                                <th>Total Hari</th>
                                <th>Total Masuk</th>
                                <th>Libur</th>
                                <th>Ph</th>
                                <th>Izin</th>
                                <th>Alfa</th>
                                <th>Sakit</th>
                                <th>Terlambat</th>
                                <th>Terlambat dgn Form</th>
                                <th>Reff</th>
                                <th>Updated At</th>
                            </tr>
                            </thead>
                        </table>
                    </div>


                    <!--  -->
                    <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-end">
                            <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                            <button type="button" id="btnSimpan" class="btn btn-block btn-success">
                                <i class="fas fa-check-circle"></i> Submit
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
        let listTable;
        let iPic = $('#iPic');

        const iRemoveSelectedCheckbox = $('#iRemoveSelectedCheckbox');
        const iRemoveAll = $('#iRemoveAll');

        const btnSyncronise = $('#btnSyncronise');
        const btnSimpan = $('#btnSimpan');
        


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
                processing: true,
                order: [
                    [ 6, 'asc' ],
                ],
                ajax: {
                    url: "{{ url('dashboard/penggajian/absensi-karyawan/data') }}" 
                },
                columns: [
                    {data: 'id'},
                    {data: 'idPeriode'},
                    {data: 'departemen'},
                    {data: 'subDepartemen'},
                    {data: 'pos'},
                    {data: 'grade'},
                    {data: 'nik'},
                    {data: 'name'},
                    {data: 'tipeKontrak'},
                    {data: 'idSkema'},
                    {data: 'totHari'},
                    {data: 'totMasuk'},
                    {data: 'totLibur'},
                    {data: 'totPh'},
                    {data: 'totIzin'},
                    {data: 'totAlfa'},
                    {data: 'totSakit'},
                    {data: 'totTerlambat'},
                    {data: 'totTerlambatDgnForm'},
                    {data: 'reff'},
                    {data: 'updatedAt'},
                
                ],
            });
            $('#listTable tbody').on('click','tr',function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                   
                    dataID = null;
                } else {
                    listTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                   
                    let data = listTable.row('.selected').data();
                    dataID = data.username;
                }
            });

            });

            btnSyncronise.click(function (e) {
                e.preventDefault();
                    Swal.fire({
                    title: "Apakah ingin Syncronise Absensi?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Generate',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                   
                    }).then((result) => { 
                    if (result.value) {
                        Swal.fire({
                        title: 'Mohon Ditunggu !',
                        html: 'sedang memproses data...',// add html attribute if you want or remove
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                        Swal.showLoading()
                        },
                        });
                        $.ajax({
                            url: '{{ url('GetPivotPeriode') }}',
                            method: 'post',
                            data: $(this).serialize(),
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

            btnSimpan.click(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Data Absensi',
                    text: 'Reff : '+ iPic.val(),
                    input: 'checkbox',
                    inputValue:0,
                    icon: 'question',
                    inputPlaceholder:
                        'Saya Sudah Memastikan Data Benar.',
                    confirmButtonText:
                        'Continue <i class="fa fa-arrow-right"></i>',
                    inputValidator: (result) => {
                        return !result && 'You need to agree with T&C'
                    }
                   
                    }).then((result) => { 
                    if (result.value) {
                        Swal.fire({
                        title: 'Mohon Ditunggu !',
                        html: 'sedang memproses data...',// add html attribute if you want or remove
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                        Swal.showLoading()
                        },
                        });
                        $.ajax({
                            url: '{{ url('dashboard/penggajian/absensi-karyawan/submit') }}',
                            method: 'post',
                            data: $(this).serialize(),
                            success: function (response) {
                                console.log(response);
                                if (response === 'success') {
                                    Swal.fire({
                                        title: 'Data tersimpan!',
                                        type: 'success',
                                        onClose: function () {
                                            window.location = '{{ url('dashboard/penggajian/generate-gaji') }}';
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

            // Action Data ---------------------------------------------------------
            iRemoveAll.click(function (e) {
                e.preventDefault();
                // let username = listTable.getSelectedData()[0].username;
                Swal.fire({
                    title: 'Hapus Semua Data?',
                    text: "Semua Data Absensi Akan dihapus",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('penggajian/absensi-karyawan/action') }}',
                            method: 'post',
                            data: {typeActionData: 'removeAll'},
                            success: function (response) {
                                if (response === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data Berhasil dihapus',
                                        onClose(modalElement) {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    console.log(response);
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Gagal',
                                        text: 'Gagal Menghapus Data, silahkan coba lagi.',
                                    });
                                }
                            },
                            error: function (response) {
                                console.log(response);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'System Error',
                                    text: 'Silahkan hubungi Developer',
                                });
                            }
                        });
                    }
                })
            });

            iRemoveSelectedCheckbox.click(function (e) {
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
                    title: 'Hapus Data Terpilih?',
                    text: "Semua Data Absensi yang Terpilih Akan dihapus",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('penggajian/absensi-karyawan/action') }}',
                            method: 'post',
                            data: {typeActionData: 'removeCheckBox',idData: array_select},
                            success: function (response) {
                                if (response === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data Berhasil dihapus',
                                        onClose(modalElement) {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    console.log(response);
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Gagal',
                                        text: 'Gagal Menghapus Data, silahkan coba lagi.',
                                    });
                                }
                            },
                            error: function (response) {
                                console.log(response);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'System Error',
                                    text: 'Silahkan hubungi Developer',
                                });
                            }
                        });
                    }
                })
            });
            // End Action Data ------------------------------------------------------
            
    
    </script>
@endsection
