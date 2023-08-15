@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                <div class="card-header">
                        <h4>Penggajian - Data Lembur</h4>
                    </div>
          

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
                              
                                <th>Jam Lembur</th>
                                <th>Total Upah</th>
                                <th>Total Jam</th>
                                <th>Nominal</th>
                          
                                <th>Pic</th>
                                <th>Updated At</th>
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
                                        <th>Total</th>
                                        <th><input style="text-align: right;width:150px" class="form-control" id="iNominal" type="text" name="nominal"  readonly></th>
                                
                                        <th></th>
                                        <th></th>
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
        let btnEdit = $('#btnEdit');

        let listTable;
        let iNominal = document.getElementById("iNominal");

        $(document).ready(function () {
               
            let listTable = $('#listTable').DataTable({
            "bDestroy": true,
            "scrollY": 400,
            "scrollX": true,
            "ajax": {
                "method": "get",
                "url": "{{ url('dashboard/penggajian/data-lembur/list/data') }}",
                "header": {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
                "complete": function (xhr,responseText) {
                    if (responseText === 'error') {
                        console.log(xhr);
                        console.log(responseText);
                    }
                     iNominal.value = xhr.responseJSON.total["nominal"];
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
                    {data: 'tieKontrak'},
                    {data: 'jamLembur'},
                    {data: 'totalUpah',
                    className: "text-right" },
                    {data: 'totalJam'},
                    {data: 'nominal',
                    className: "text-right" },
                    {data: 'pic'},
                    {data: 'updatedAt'},
                    
                
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

            iBtnExport.click(function (e) {
                e.preventDefault();
                window.open('{{ url('dashboard/master-data/upah-karyawan/export') }}');
            });

            iBtnExportUpah.click(function (e) {
                e.preventDefault();
                window.open('{{ url('dashboard/master-data/upah-karyawan/export-gaji') }}');
            });

            btnEdit.click(function (e) {
                e.preventDefault();
                //  let id = listTable.getSelectedData()[0].id;
           
                window.location = '{{ url('master-data-upah-karyawan-edit') }}-'+dataID;
            });
    
    </script>
@endsection
