@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">

                <div class="card">
                <input type="text" id="iPic" name="pic" class="form-control" value="{{ request()->session()->get('name') }}" hidden>
                <div class="card text-center" style="width: 100%;">
                            <img src="{{ asset('assets/logo/BG-HeaderUpahKaryawan.jpg') }}" class="card-img">
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
                                <a class="dropdown-item" id="iAddKaryawan">Add Karyawan</a>
                                <hr>
                                <a class="dropdown-item" id="iRemoveSelectedCheckbox">Remove Selected Checkbox</a>
                            </div>
                            </div>
                        </ul>
              
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 px-2">
                            <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                Action Export
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" id="iExportSelectedCheckBox">Export Selected Checkbox</a>
                                <a class="dropdown-item" id="iExportAll">Export All</a>
                            </div>
                            </div>
                        </ul>                   
                    
                        </div>
                    </div>
                    </nav>

                    <div class="card-body">
                    <table id="listTable" class="table table-striped table-bordered display nowrap" style="width: 100%">
                            <thead>
                            <tr>
                            <th>ID</th>
                            <th>Status Karyawan</th>
                                <th>Departemen</th>
                                <th>Sub Departemen</th>
                                <th>Pos</th>
                                <th>Grade</th>
                                <th>ID Absen / Username</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Tipe Kontrak</th>
                                <th>Tanggal Bergabung</th>
                                <th>Masa Kerja</th>
                                <th>No Rekening</th>
                                <th>Skema BPJS</th>
                                <th>Skema Gaji</th>
                                <th>Updated At</th>
                                <th>Gaji Pokok</th>
                                <th>Jabatan</th>
                                <th>Keahlian</th>
                                <th>Transport</th>
                                <th>Komunikasi</th>
                                <th>Lembur</th>
                                <th>Tambahan Lainnya</th>
                            </tr>
                            <tfoot >
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total</th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotGajiPokok" type="text" name="totGajiPokok"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotJabatan" type="text" name="totJabatan"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotKeahlian" type="text" name="totKeahlian"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotTransport" type="text" name="totTransport"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotKomunikasi" type="text" name="totKomunikasi"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotLembur" type="text" name="totLembur"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotTambahanLainnya" type="text" name="totTambahanLainnya"  readonly></th>
                                    </tr>
                                    </tfoot>
                            </thead>
                        </table>
                       
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-end">
                            <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                                <button type="button" id="btnEdit" class="btn btn-block btn-primary" disabled>
                                    <i class="fas fa-pencil-alt mr-2"></i>Edit
                                </button>
                            </div>
                            <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                                <button type="button" id="btnSubmit" class="btn btn-block btn-success">
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
        let iPic = $('#iPic');

        const iAddKaryawan = $('#iAddKaryawan');
        const iRemoveSelectedCheckbox = $('#iRemoveSelectedCheckbox');
        const iExportAll = $('#iExportAll');
        const iExportSelectedCheckBox = $('#iExportSelectedCheckBox');
      
        let btnEdit = $('#btnEdit');
        let btnSubmit = $('#btnSubmit');
        let listTable;

        let iTotGajiPokok = document.getElementById("iTotGajiPokok");
        let iTotJabatan = document.getElementById("iTotJabatan");
        let iTotKeahlian = document.getElementById("iTotKeahlian");
        let iTotTransport = document.getElementById("iTotTransport");
        let iTotKomunikasi = document.getElementById("iTotKomunikasi");
        let iTotLembur = document.getElementById("iTotLembur");
        let iTotTambahanLainnya= document.getElementById("iTotTambahanLainnya");

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
            "bDestroy": true,
            "scrollY": 400,
            "scrollX": true,
            "ajax": {
                "method": "get",
                "url": "{{ url('dashboard/penggajian/upah-karyawan/data') }}",
                "header": {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
                "complete": function (xhr,responseText) {
                    if (responseText === 'error') {
                        console.log(xhr);
                        console.log(responseText);
                    }
                
                    iTotGajiPokok.value = xhr.responseJSON.total["iTotGajiPokok"];
                    iTotJabatan.value =  xhr.responseJSON.total["iTotJabatan"];
                    iTotKeahlian.value =  xhr.responseJSON.total["iTotKeahlian"];
                    iTotTransport.value =  xhr.responseJSON.total["iTotTransport"];
                    iTotKomunikasi.value =  xhr.responseJSON.total["iTotKomunikasi"];
                    iTotLembur.value = xhr.responseJSON.total["iTotLembur"];
                    iTotTambahanLainnya.value = xhr.responseJSON.total["iTotTambahanLainnya"];
                }
            },
            "columns": [
                    {data: 'id'},
                    {data: 'statusSkemaGaji',
                        render: function(data, type) {
                            let color;
                        if (data == '1') {
                            status = 'Aktif';
                            color = 'green';
                        }
                        
                        else if (data == '2') {
                            status = 'Non Aktif';
                            color = 'orange';
                        }
                        else
                        {
                            status = 'Error';
                            color = 'red';
                        }
                        return '<span style="color:' + color + '">' + status + '</span>';
                    }
                    },
                    {data: 'id_departemen'},
                    {data: 'subDepartemen'},
                    {data: 'pos'},
                    {data: 'grade'},
                    {data: 'id_absen'},
                    {data: 'username'},
                    {data: 'name'},
                    {data: 'tieKontrak'},
                    {data: 'doj'},
                    {data: 'masaKerja'},
                    {data: 'noRekening'},
                    {data: 'tipeBpjs',
                        render: function(data, type) {
                            let color;
                        if (data == '0') {
                            status = 'Normal';
                            color = 'green';
                        }
                        
                        else if (data == '1') {
                            status = 'Perusahaan';
                            color = 'blue';
                        }
                        else if (data == '2') {
                            status = 'Tidak Ikut';
                            color = 'orange';
                        }
                        else
                        {
                            status = 'Error';
                            color = 'red';
                        }
                        return '<span style="color:' + color + '">' + status + '</span>';
                    }
                    },
                    {data: 'skemaGaji',
                        render: function(data, type) {
                            let color;
                        if (data == '1') {
                            status = 'Normal';
                            color = 'green';
                        }
                        
                        else if (data == '2') {
                            status = 'Harian';
                            color = 'orange';
                        }
                        else if (data == '3') {
                            status = '50 %';
                            color = 'blue';
                        }
                        else
                        {
                            status = 'Error';
                            color = 'red';
                        }
                        return '<span style="color:' + color + '">' + status + '</span>';
                    }
                    },

                    {data: 'updatedAt'},
                    {data: 'gajiPokok',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'tunjanganJabatan',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'tunjanganKeahlian',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'tunjanganTransport',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'tunjanganKomunikasi',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'lembur',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'tambahanLainnya',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                ],
            });
            $('#listTable tbody').on('click','tr',function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    btnEdit.attr('disabled',true);
                   
                    dataID = null;
                } else {
                    listTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    btnEdit.removeAttr('disabled');
                   
                    let data = listTable.row('.selected').data();
                    dataID = data.id_absen;
                }
            });

            });

            btnEdit.click(function (e) {
                e.preventDefault();
                window.location = '{{ url('dashboard/penggajian/upah-karyawan/edit') }}/'+dataID;
            });

            btnSubmit.click(function (e) {
                e.preventDefault();
                let tables = $('#listTable').DataTable();
                    Swal.fire({
                    title: 'Upah Karyawan',
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
                            url: '{{ url('penggajian/upah-karyawan/submit') }}',
                            method: 'post',
                            data: {idModule: 'GG-002'},
                            success: function (response) {
                                if (response === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data Berhasil ditambahkan',
                                        onClose(modalElement) {
                                            window.location = '{{ url('dashboard/penggajian/generate-gaji') }}';
                                        }
                                    });
                                } else {
                                    console.log(response);
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Gagal',
                                        text: response,
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

             // Action Data ---------------------------------------------------------
             iAddKaryawan.click(function (e) {
                e.preventDefault();
                //  let id = listTable.getSelectedData()[0].id;
                window.location = '{{ url('penggajian/upah-karyawan-add') }}';
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
                    title: 'Hapus Data Karyawan Terpilih?',
                    text: "Semua Data Karyawan yang Terpilih Akan dihapus dari Periode Penggajian",
                    icon: 'warning',
                        input: 'password',
                        inputLabel: 'Password',
                        inputPlaceholder: 'Enter your password',
                        inputAttributes: {
                            maxlength: 10,
                            autocapitalize: 'off',
                            autocorrect: 'off'
                        },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('penggajian/upah-karyawan/action') }}',
                            method: 'post',
                            data: {typeActionData: 'removeCheckBox',idData: array_select,password:result.value},
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
                                        text: response,
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

            iExportAll.click(function (e) {
                e.preventDefault();
                window.open('{{ url('penggajian/upah-karyawan/actionExport') }}/' + 'exportAll/'+'-' );
            });
            
            iExportSelectedCheckBox.click(function (e) {
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
                
                window.open('{{ url('penggajian/upah-karyawan/actionExport') }}/' +'exportSelectedCheckBox/'+array_select);
            });
            // End Action Data ------------------------------------------------------
          
    
    </script>
@endsection
