@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Upah Karyawan</h4>
                    </div>
                    <div class="row justify-content-end">
                    <div class="card-body pt-0 pb-0">
                    <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                        
                            </div>
                            
                            <div class="modal-body">
                            <form method="post" action="/dashboard/master-data/upah-karyawan/import-user" enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="file" name="file" class="form-control">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>

                            <div class="btn-group" >
                                <button type="button" class="btn btn-block btn-danger" class="fas fa-file-export mr-2"><i class="fas fa-file-export mr-2"></i>Export</button>
                                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" id="iBtnExportUpah">(1) Data Upah</a>
                                    <a class="dropdown-item" id="iBtnExport">(2) Data User</a>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>
                    </div>


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
                                <th>DOJ</th>
                                <th>Masa Kerja</th>
                                <th>No Rekening</th>
                                <th>Skema BPJS</th>
                                <th>Tipe Penggajian</th>
                                <th>Updated At</th>
                                <th>Gaji Pokok</th>
                                <th>Jabatan</th>
                                <th>Keahlian</th>
                                <th>Transport</th>
                                <th>Komunikasi</th>
                                <th>Tambahan Lainnya</th>
                                <th>BPJS-Kesehatan</th>
                                <th>BPJS-TK</th>
                                <th>BPJS-JP</th>
                                <!-- <th>Simpanan Koperasi</th>
                                <th>Hutang Karyawan</th> -->
                            </tr>
                            </thead>
                        </table>
                        <div class="thead-dark table-sm table-striped" id="listTable" style="width: 100%"></div>
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
        const btnClearFilter = $('#btnClearFilter');
        let btnEdit = $('#btnEdit');
        const btnDisable = $('#btnDisable');
        const btnActivate = $('#btnActivate');
        let iProvider = $('#iProvider');
        let username = $('#iProvider');
        let listTable;

        const iBtnExport = $('#iBtnExport');
        const iBtnExportUpah = $('#iBtnExportUpah');
        


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
                    url: "{{ url('dashboard/master-data/upah-karyawan/data') }}" 
                },
                columns: [
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
                    {data: 'statusSkemaGaji',
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
                    {data: 'tambahanLainnya',
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
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    // {data: 'simpananKoperasi',
                    // className: "text-right" ,
                    // render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    // {data: 'hutangKaryawan',
                    // className: "text-right" ,
                    // render: $.fn.dataTable.render.number( ',', '.', 2 )},
                
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
