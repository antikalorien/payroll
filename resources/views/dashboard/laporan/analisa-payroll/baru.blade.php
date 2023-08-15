@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid col px-md-5">
                            <a class="navbar-brand">
                                <img src="{{ asset('assets/img/avatar/setting.png') }}"  width="30" height="30" class="d-inline-block align-top" alt="">
                                Control Data
                            </a>  
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
              
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 px-2">
                            <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" >
                                Action Export
                            </button>
                            <div class="dropdown-menu">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="fw-bold">
                                    <a id="iExportSelected" >Exp Selected </h6></a>
                                    </div>
                                    <span class="badge bg-danger rounded-pill">.pdf</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="fw-bold">
                                    <a id="iExportSelectedCheckBox">Exp CheckBox</h6></a>
                                    </div>
                                    <span class="badge text bg-success rounded-pill">.xls</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="fw-bold">
                                    <a class="dropdown-item" id="iExportAll">Exp All</a>
                                    </div>
                                    <span class="badge text bg-success rounded-pill">.xls</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="fw-bold">
                                    <a id="iExportAllCsv">Exp BCA Format</a>
                                    </div>
                                    <span class="badge text bg-warning rounded-pill">.csv</span>
                                </li>
                            </div>
                            </div>
                        </ul>
                        </div>
                            <select style="width: 20%" id="iPeriode" name="periode" required></select>
                    </div>
                    </nav>

                    <div class="card-body">
                    <table id="listTable" class="table table-striped table-bordered display nowrap" style="width: 100%">
                            <thead>
                            <tr>
                                <th>ID</th>
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
                                <th>Updated At</th>
                                <th>Gaji Diterima</th>
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
                                <th>Simpanan Koperasi</th>
                                <th>Hutang Karyawan</th>
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
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iThp" type="text" name="totThp"  readonly></th>
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
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotSimpananKoperasi" type="text" name="totSimpananKoperasi"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotHutangKaryawan" type="text" name="totHutangKaryawan"  readonly></th>
                                    </tr>
                                    </tfoot>
                            </thead>
                        </table>
                       
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
        let dataID;
        let idPeriode;
        let _idPeriode;
        let _typeActionExport;
        let listTable;

        let iPeriode = $('#iPeriode');

        let iThp = document.getElementById("iThp");
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
        let iTotSimpananKoperasi = document.getElementById("iTotSimpananKoperasi");
        let iTotHutangKaryawan = document.getElementById("iTotHutangKaryawan");

        const iExportAll = $('#iExportAll');
        const iExportSelected = $('#iExportSelected');
        const iExportSelectedCheckBox = $('#iExportSelectedCheckBox');
        const iExportAllCsv = $('#iExportAllCsv');

        $(document).ready(function () {

            iPeriode.select2({
            ajax: {
                url: '{{ url("list_periode_success") }}',
                dataType: 'json',

                data: function(params) {
                    return {
                        search: params.term,
                    }
                }
            }
            });

            iPeriode.change(function() {
                var value = $(this).val();
                idPeriode = value;
                getDataTable(idPeriode);
            });
                getDataTable(99);

            });

            function getDataTable(idPeriode){
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
                "url": "{{ url('laporan/analisa-payroll/data') }}/"+idPeriode,
                "header": {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
                "complete": function (xhr,responseText) {
                    if (responseText === 'error') {
                        console.log(xhr);
                        console.log(responseText);
                    }

                    idPeriode = xhr.responseJSON.idPeriode;
                    _idPeriode =  xhr.responseJSON.idPeriode;
                    iThp.value = xhr.responseJSON.thp['total'];
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
                    iTotSimpananKoperasi.value =  xhr.responseJSON.total["iTotSimpananKoperasi"];
                    iTotHutangKaryawan.value =  xhr.responseJSON.total["iTotHutangKaryawan"];
                }
            },
            "columns": [
                    {data: 'id_absen'},
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
                    {data: 'updatedAt'},
                    {data: 'thp',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
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
                    {data: 'lembur'},
                    {data: 'tambahanLainnya'},
                    {data: 'alfa'},
                    {data: 'ijin'},
                    {data: 'potonganLainnya'},
                    {data: 'bpjsKes',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'bpjsTk',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'bpjsJp',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'simpananKoperasi',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'hutangKaryawan',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                
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
                    dataID = data.id_absen;
                }
            });
            }

            // Action Data
            iExportAll.click(function (e) {
                e.preventDefault();
                _typeActionExport = 'exportAll';
                dataID='-';
                 window.open('{{ url('laporan/analisa-payroll/actionExport') }}/' +_typeActionExport+'/'+_idPeriode+'/'+dataID);
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
                 _typeActionExport = 'exportSelectedCheckBox';
                // _typeActionExport='exportSelected';
                dataID=array_select;
                window.open('{{ url('laporan/analisa-payroll/actionExport') }}/' +_typeActionExport+'/'+_idPeriode+'/'+dataID);              
            });

         
            iExportAllCsv.click(function (e) {
                e.preventDefault();
                _typeActionExport = 'exportBCAFormat';
                dataID='-';
                window.open('{{ url('laporan/analisa-payroll/actionExport') }}/' +_typeActionExport+'/'+_idPeriode+'/'+dataID);
            });

            iExportSelected.click(function (e) {
                e.preventDefault();
                _typeActionExport = 'exportSelected';
                window.open('{{ url('laporan/analisa-payroll/actionExport') }}/' +_typeActionExport+'/'+_idPeriode+'/'+dataID);
            });
            // End Action Data

    </script>
@endsection
