@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                <input type="text" id="iPic" name="pic" class="form-control" value="{{ request()->session()->get('name') }}" hidden>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid col px-md-5">
                            <a class="navbar-brand">
                                <img src="{{ asset('assets/img/avatar/setting.png') }}"  width="30" height="30" class="d-inline-block align-top" alt="">
                                Control Data
                            </a>  
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
              
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 px-2">
                            <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                Action Export
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" id="iExportSelected">Export Selected (.pdf)</a>
                                <a class="dropdown-item" id="iExportSelectedCheckBox">Export CheckBox(.pdf)</a>
                                <a class="dropdown-item" id="iExportAll">Export All (.xls)</a>
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
                                <th>Status Check</th>
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
                                <th>Take Home Pay (THP)</th>
                                <th>Updated At</th>
                                <th>Gaji Pokok</th>
                                <th>Jabatan</th>
                                <th>Keahlian</th>
                                <th>Transport</th>
                                <th>Komunikasi</th>
                                <th>Lembur</th>
                                <th>Tambahan Lainnya</th>
                                <th>Alfa</th>
                                <th>Ijin</th>
                                <th>Potongan Lainnya</th>
                                <th>BPJS-Kesehatan</th>
                                <th>BPJS-TK</th>
                                <th>BPJS-JP</th>
                   
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
                                        <th>Total</th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotThp" type="text" name="totThp"  readonly></th>
                                        <th></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotGajiPokok" type="text" name="totGajiPokok"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotJabatan" type="text" name="totJabatan"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotKeahlian" type="text" name="totKeahlian"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotTransport" type="text" name="totTransport"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotKomunikasi" type="text" name="totKomunikasi"  readonly></th>
                                       
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iLembur" type="text" name="totLembur"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTambahanLainnya" type="text" name="totTambahanLainnya"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iAlfa" type="text" name="alfa"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iIjin" type="text" name="iIjin"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iPotonganLainnya" type="text" name="totPotonganLainnya"  readonly></th>

                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotBpjsKes" type="text" name="totBpjsKes"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotBpjsTk" type="text" name="totBpjsTk"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotBpjsJp" type="text" name="totBpjsJp"  readonly></th>
  
                                    </tr>
                                    </tfoot>
                            </thead>
                        </table>
                       
                    </div>
                    <div class="card-footer bg-whitesmoke">
       
                        <div class="row justify-content-end">
                            <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                                <button type="button" id="btnEdit" class="btn btn-block btn-primary" hidden>
                                    <i class="fas fa-pencil-alt mr-2"></i>Edit
                                </button>
                            </div>
                            <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                                <button type="button" id="btnCheckThp" class="btn btn-block btn-warning">
                                    <i class="fas fa-undo mr-2"></i>Cek THP
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
        const iExportAll = $('#iExportAll');
        const iExportSelected = $('#iExportSelected');
        const iExportSelectedCheckBox = $('#iExportSelectedCheckBox');
      
        let btnEdit = $('#btnEdit');
        let btnSubmit = $('#btnSubmit');
        let btnCekThp = $('#btnCheckThp');
        let listTable;

        let iTotThp = document.getElementById("iTotThp");
        let iTotGajiPokok = document.getElementById("iTotGajiPokok");
        let iTotJabatan = document.getElementById("iTotJabatan");
        let iTotKeahlian = document.getElementById("iTotKeahlian");
        let iTotTransport = document.getElementById("iTotTransport");
        let iTotKomunikasi = document.getElementById("iTotKomunikasi");

        let iTotLembur = document.getElementById("iTotLembur");
        let iTambahanLainnya = document.getElementById("iTambahanLainnya");
        let iAlfa = document.getElementById("iAlfa");
        let iIjin = document.getElementById("iIjin");
        let iPotonganLainnya = document.getElementById("iPotonganLainnya");

        let iTotBpjsKes = document.getElementById("iTotBpjsKes");
        let iTotBpjsTk = document.getElementById("iTotBpjsTk");
        let iTotBpjsJp = document.getElementById("iTotBpjsJp");

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
                "url": "{{ url('dashboard/penggajian/paycheck/data') }}",
                "header": {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
                "complete": function (xhr,responseText) {
                    if (responseText === 'error') {
                        console.log(xhr);
                        console.log(responseText);
                    }
                
                    iTotThp.value = xhr.responseJSON.thp['total'];
                    iTotGajiPokok.value = xhr.responseJSON.total["iTotGajiPokok"];
                    iTotJabatan.value =  xhr.responseJSON.total["iTotJabatan"];
                    iTotKeahlian.value =  xhr.responseJSON.total["iTotKeahlian"];
                    iTotTransport.value =  xhr.responseJSON.total["iTotTransport"];
                    iTotKomunikasi.value =  xhr.responseJSON.total["iTotKomunikasi"];

                    iLembur.value =  xhr.responseJSON.total["iLembur"];
                    iTambahanLainnya.value =  xhr.responseJSON.total["iTambahanLainnya"];
                    iAlfa.value =  xhr.responseJSON.total["iAlfa"];
                    iIjin.value =  xhr.responseJSON.total["iIjin"];
                    iPotonganLainnya.value =  xhr.responseJSON.total["iPotonganLainnya"];

                    iTotBpjsKes.value =  xhr.responseJSON.total["iTotBpjsKes"];
                    iTotBpjsTk.value =  xhr.responseJSON.total["iTotBpjsTk"];
                    iTotBpjsJp.value =  xhr.responseJSON.total["iTotBpjsJp"];
            
                }
            },
            "columns": [
                    {data: 'id'},
                    {data: 'reffPaycheck',
                        render: function(data, type) {
                            let color;
                        if (data == '-') {
                            status = 'Belum di Cek';
                            color = 'orange';
                        }
                        
                        else  {
                            status = data;
                            color = 'green';
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
                            color = 'orange';
                        }
                        else if (data == '2') {
                            status = 'Tikda Ikut';
                            color = 'red';
                        }
                        return '<span style="color:' + color + '">' + status + '</span>';
                    }
                    },
                    {data: 'thp',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
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
                    {data: 'alfa',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'ijin',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'potonganLainnya',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'bpjsKes',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'bpjsTk',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'bpjsJp',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )}
                
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
                    dataID = data.username;
                }
            });

            });



            btnCekThp.click(function (e){
                e.preventDefault();
   
                        Swal.fire({
                        title: 'Mohon Ditunggu !',
                        html: 'sedang memproses data...',// add html attribute if you want or remove
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                        });
                        $.ajax({
                            url: '{{ url('dashboard/penggajian/paycheck/cekThp') }}',
                            method: 'get',
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
            );

            btnSubmit.click(function (e) {
                e.preventDefault();
                let tables = $('#listTable').DataTable();
                    Swal.fire({
                    icon: 'warning',
                    title: 'Paycheck Penggajian',
                    inputLabel: 'Reff : '+ iPic.val(),
                    text: "Periode Penggajian Akan Terkunci dan Tidak Dapat di Edit Kembali",
                    input: 'password',
                        inputLabel: 'Password',
                        inputPlaceholder: 'Enter your password',
                        inputAttributes: {
                            maxlength: 15,
                            autocapitalize: 'off',
                            autocorrect: 'off'
                        },
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('penggajian/paycheck/submitModule') }}',
                            method: 'post',
                            data: {idModule: 'GG-006',password:result.value},
                            success: function (response) {
                                if (response === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data Berhasil ditambahkan',
                                        onClose(modalElement) {
                                            window.location = '{{ url('dashboard') }}';
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

            // Action Data
            iExportAll.click(function (e) {
                e.preventDefault();
                window.open('{{ url('dashboard/penggajian/paycheck/export-gaji') }}');
            });

            iExportSelected.click(function (e) {
                e.preventDefault();
                window.open('{{ url('dashboard/penggajian/paycheck/export-gaji/selected') }}/'+dataID);
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
                window.open('{{ url('dashboard/penggajian/paycheck/export-gaji/checkBox') }}/'+array_select);
            });
    
    </script>
@endsection
