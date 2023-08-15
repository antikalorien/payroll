@extends('dashboard.layout')

@section('page_menu')
    <li class="nav-item">
        <a href="{{ url(request()->segment(1).'/'.request()->segment(2).'/'.request()->segment(3)) }}" class="nav-link">Group Baru</a>
    </li>
    <li class="nav-item active">
        <a href="{{ url(request()->segment(1).'/'.request()->segment(2).'/'.request()->segment(3)) }}/list" class="nav-link">List Group</a>
    </li>
@endsection


@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>List Invoice</h4>
                    </div>
             
                    <div class="card-body">
                    <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                <label for="iNama">Tanggal Awal:</label>
                                <input type="text" class="form-control" id="iTanggalAwal" name="tanggalAwal">
                                </div>  
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                <label for="iNama">Tanggal Akhir:</label>
                                <input type="text" class="form-control" id="iTanggalAkhir" name="tanggalAkhir">
                                </div> 
                            </div>
                    </div>


                        <div class="form-group">
                            <div class="row justify-content-end">
                            <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                                    <button type="button" class="btn btn-block btn-info" id="iSearchAll"><i class="fas fa-search mr-2"></i>Tampilkan Semua</button>
                                </div>
                                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                                    <button type="button" class="btn btn-block btn-warning" id="iSearch"><i class="fas fa-search mr-2"></i>Search</button>
                                </div>
                                
                                </div>
                            </div>

                        <table id="listTable" class="table table-striped table-bordered display nowrap" style="width: 100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Dept</th>
                                    <th>Sub.Dept</th>
                                    <th>Pos</th>
                                    <th>Grade</th>
                                <th>ID Enroll Karyawan</th>
                                <th>Verikasi Absen</th>
                                <th>Verifikasi Kehadiran</th>
                                <th>Jam Absen</th>
                                <th>Tanggal Absen</th>
                                <th>Waktu Uplad Data</th>
                                <th>ID Mesin</th>
                                <th>Ip Mesin</th>
                              
                            </tr>
                            </thead>
                        </table>
                        <div class="card-footer bg-whitesmoke">
                            
                            <div class="row justify-content-end">

                            <div class="btn-group" >
                            <button type="button" class="btn btn-block btn-danger" class="fas fa-file-export mr-2">Export All</button>
                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" id="iExportRange">Export Range</a>
                                <a class="dropdown-item" id="iExportAll">Export All</a>
                            </div>
                            </div>
                        
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
       
        //declare
        const iSearch = $('#iSearch');
        const iSearchAll = $('#iSearchAll');
        const iExportRange = $('#iExportRange');
        const iExportAll = $('#iExportAll');

        let dataID;

        // set value
        const iTanggalAwal = $('#iTanggalAwal').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        const iTanggalAkhir = $('#iTanggalAkhir').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });


        $(document).ready(function () {
            getDataTable('today')
        });

            function getDataTable(tipeData){
            let listTable = $('#listTable').DataTable({
                "bDestroy": true,
          
            "scrollX": true,
               
                ajax: {
                    url: '{{ url('dashboard/master/absensi-mesin/list/data') }}/' + tipeData +'/'+ $("#iTanggalAwal").val() + '/'+ $("#iTanggalAkhir").val(),
                },
                columns: [
                    {data: 'id'},
                    {data: 'nip'},
                    {data: 'nama'},
                    {data: 'departemen'},
                    {data: 'sub_departemen'},
                    {data: 'pos'},
                    {data: 'grade'},
                    {data: 'id_enroll_karyawan'},
                    {data: 'verivikasi_absen'},
                    {data: 'verifikasi_kehadiran'},
                    {data: 'jam'},
                    {data: 'tanggal'},
                    {data: 'created_at'},
                    {data: 'id_mesin'},
                    {data: 'ip_mesin'},
              
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
                    dataID = data.idInvoice;
                }
            });
        }
        // end onDocument

        
            iSearch.click(function (e) {
                getDataTable('range')
            });

            iSearchAll.click(function (e) {
                getDataTable('all')
            });

            iExportRange.click(function (e) {
                e.preventDefault();
              window.location= '{{ url('laporan/absensi-mesin/exportRange') }}/'+ $("#iTanggalAwal").val()+"/"+ $("#iTanggalAkhir").val();
            });
            
            iExportAll.click(function (e) {
                e.preventDefault();
              window.location= '{{ url('laporan/absensi-mesin/exportAll') }}';
            });

    </script>
@endsection
