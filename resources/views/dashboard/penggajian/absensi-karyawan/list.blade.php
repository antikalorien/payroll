@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Penggajian-List Absensi Karyawan</h4>
                    </div>


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
                                <th>Gaji Pokok</th>
                                <th>Upah Harian</th>
                                <th>Total Masuk</th>
                                <th>Ph</th>
                                <th>Izin</th>
                                <th>Alfa</th>
                                <th>Sakit</th>      
                                <th>Reff</th>
                                <th>Updated At</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- <div class="card-footer bg-whitesmoke">
                    <div class="row justify-content-end">
          
                        <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                            <button type="button" id="btnKunciAbsensiKaryawan" class="btn btn-block btn-danger">
                                <i class="fas fa-undo mr-2"></i>Kunci
                            </button>
                        </div>
                    </div>
                    </div> -->


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
        const btnSyncronise = $('#btnSyncronise');
        const btnSimpan = $('#btnSimpan');
        const btnKunciAbsensiKaryawan = $('#btnKunciAbsensiKaryawan');


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
                    url: "{{ url('dashboard/penggajian/absensi-karyawan/listData') }}" 
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

                    {data: 'skema'},

                    {data: 'totHari'},
                    {data: 'gajiPokok',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
                    {data: 'upahHarian',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},

                    {data: 'totMasuk'},
                    {data: 'totPh'},
                    {data: 'totIzin'},
                    {data: 'totAlfa'},
                    {data: 'totSakit'},
                    {data: 'reff'},
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
                    title: "Apakah ingin Menyimpan data Absensi?",
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

            btnKunciAbsensiKaryawan.click(function (e) {
                e.preventDefault();
                    Swal.fire({
                    title: "Apakah anda sudah memastikan data Absensi benar?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
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

            // btnEdit.click(function (e) {
            //     e.preventDefault();
            //     //  let id = listTable.getSelectedData()[0].id;
           
            //     window.location = '{{ url('master-data-upah-karyawan-edit') }}-'+dataID;
            // });
    
    </script>
@endsection
