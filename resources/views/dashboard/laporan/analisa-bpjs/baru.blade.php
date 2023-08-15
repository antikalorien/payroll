@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                <div class="card text-center" style="width: 100%;">
                            <img src="{{ asset('assets/logo/Header-bpjs.jpg') }}" class="card-img">
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
                                <th>Skema BPJS</th>
                                <th>BPJS TK</th>
                                <th>BPJS JP</th>
                                <th>BPJS Kesehatan</th>
                                <th>BPJS TK-Perusahaan</th>
                                <th>BPJS JP-Perusahaan</th>
                                <th>BPJS Kesehatan-Perusahaan</th>
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
                                        <th>Total</th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsTk" type="text" name="totalBpjsTk"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsJp" type="text" name="totalBpjsJp"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsKesehatan" type="text" name="totalBpjsKes"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsTkPerusahaan" type="text" name="totBpjsTkPerusahaan"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsJpPerusahaan" type="text" name="totBpjsJpPerusahaan"  readonly></th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsKesPerusahaan" type="text" name="totBpjsKesPerusahaan"  readonly></th>
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

        let listTable;

        let iTotalBpjsTk = document.getElementById("iTotalBpjsTk");
        let iTotalBpjsJp = document.getElementById("iTotalBpjsJp");
        let iTotalBpjsKesehatan = document.getElementById("iTotalBpjsKesehatan");

        let iTotalBpjsTkPerusahaan = document.getElementById("iTotalBpjsTkPerusahaan");
        let iTotalBpjsJpPerusahaan = document.getElementById("iTotalBpjsJpPerusahaan");
        let iTotalBpjsKesPerusahaan = document.getElementById("iTotalBpjsKesPerusahaan");

        const iExportAll = $('#iExportAll');
        const iExportSelectedCheckBox = $('#iExportSelectedCheckBox');

        let iPeriode = $('#iPeriode');
        let _idPeriode;
      

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
                "url": "{{ url('laporan/analisa-bpjs/data') }}/" + idPeriode,
                "header": {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
                "complete": function (xhr,responseText) {
                    if (responseText === 'error') {
                        console.log(xhr);
                        console.log(responseText);
                    }
                
                    iTotalBpjsTk.value = xhr.responseJSON.total["iTotalBpjsTk"];
                    iTotalBpjsJp.value = xhr.responseJSON.total["iTotalBpjsJp"];
                    iTotalBpjsKesehatan.value = xhr.responseJSON.total["iTotalBpjsKesehatan"];

                    iTotalBpjsTkPerusahaan.value = xhr.responseJSON.total["iTotalBpjsTkPerusahaan"];
                    iTotalBpjsJpPerusahaan.value = xhr.responseJSON.total["iTotalBpjsJpPerusahaan"];
                    iTotalBpjsKesPerusahaan.value = xhr.responseJSON.total["iTotalBpjsKesPerusahaan"];
                }
            },
            "columns": [
                    {data: 'id'},
                    {data: 'id_departemen'},
                    {data: 'subDepartemen'},
                    {data: 'pos'},
                    {data: 'grade'},
                    {data: 'id_absen'},
                    {data: 'username'},
                    {data: 'name'},
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
                    {data: 'bpjsKes',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'bpjsTk',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'bpjsJp',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'bpjsKesPerusahaan',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'bpjsTkPerusahaan',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'bpjsJpPerusahaan',
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
                        dataID = data.id;
                    }
                });
            }

            iExportAll.click(function (e) {
                e.preventDefault();
                window.open('{{ url('laporan/bpjs-exportAll') }}');
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
                
                window.open('{{ url('laporan/analisa-bpjs/actionExport') }}/' +'exportSelectedCheckBox/'+array_select);
            });

    </script>
@endsection
