@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">

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
                            </tr>
                            </thead>
                    </table>
                    </div>
                    <form id="formData">
                        <div class="card-footer bg-whitesmoke">
                            <div class="row justify-content-end">
                                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                                    <button type="submit" class="btn btn-block btn-success"><i class="fas fa-check mr-2"></i>Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
        let formData = $('#formData');
        let listTable;

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
                "url": "{{ url('penggajian/upah-karyawan/listDataTidakTerdaftar') }}",
                "header": {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
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
            formData.submit(function (e) {
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
                    title: 'Tambah Data Karyawan?',
                    text: "Data Karyawan yang Terpilih Akan ditambahkan ke Periode Penggajian",
                    icon: 'question',
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
                    confirmButtonText: 'Tambah'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('penggajian/upah-karyawan/action') }}',
                            method: 'post',
                            data: {typeActionData: 'addKaryawan',idData: array_select,password:result.value},
                            success: function (response) {
                                if (response === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data Berhasil ditambahkan',
                                        onClose(modalElement) {
                                            window.location = '{{ url()->previous() }}';
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
            })
    </script>
@endsection
