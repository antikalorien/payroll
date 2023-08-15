@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar {{ ucfirst(request()->segment(3)) }}</h4>
                    </div>
                    <div class="card-body pt-0 pb-0">
                       
                    </div>



                    <div class="card-body">
                    <table id="listTable" class="table table-striped table-bordered display nowrap" style="width: 100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipe</th>
                                <th>Menu</th>
                                <th>Module</th>
                                <th>Pic</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                             
                            </tr>
                            </thead>
                        </table>
                        <div class="thead-dark table-sm table-striped" id="listTable" style="width: 100%"></div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        const formFilter = $('#formFilter');
        const btnClearFilter = $('#btnClearFilter');
        let btnEdit = $('#btnEdit');
        const btnDisable = $('#btnDisable');
        const btnActivate = $('#btnActivate');
        let iProvider = $('#iProvider');
        let username = $('#iProvider');
        let listTable;

        const btnExportDetail = $('#btnExportDetail');


        $(document).ready(function () {
               
            let listTable = $('#listTable').DataTable({
                scrollX: true,
                bDestroy: true,
        
               ajax: {
                    url: "{{ url('dashboard/system-utility/activity-history/list/data') }}" 
                },
                columns: [
                    {data: 'id'},
                    
                    {data: 'tipe',
                        render: function(data, type) {
                            let color;
                        if (data == '0') {
                            status = 'CREATED';
                            color = 'green';
                        }
                        
                        else if (data == '1') {
                            status = 'UPDATE';
                            color = 'blue';
                        }
                        else if (data == '2') {
                            status = 'DELETE';
                            color = 'red';
                        }
                        else
                        {
                            status = 'ERROR';
                            color = 'red';
                        }
                        return '<span style="color:' + color + '">' + status + '</span>';
                    }

                    },
                    {data: 'menu'},
                   
                    {data: 'module'},
                    {data: 'pic'},
                    {data: 'created_at'},
                    {data: 'keterangan'},
                 
                ],
            });
            $('#listTable tbody').on('click','tr',function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    btnEdit.attr('disabled',true);
                    btnExportDetail.attr('disabled',true);
                    dataID = null;
                } else {
                    listTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    btnEdit.removeAttr('disabled');
                    btnExportDetail.removeAttr('disabled');
                    let data = listTable.row('.selected').data();
                    dataID = data.id;
                }
            });
           

            });

            btnExportDetail.click(function (e) {
                e.preventDefault();
                window.open('{{ url('injetAdmin/expotPDF') }}/'+ username.val());
            });

            btnEdit.click(function (e) {
                e.preventDefault();
                window.location = '{{ url('dashboard/master-data/ms-kasir/edit') }}/'+dataID;
            });

            btnDisable.click(function (e) {
                e.preventDefault();
                let id = listTable.getSelectedData()[0].id;
                Swal.fire({
                    title: 'Nonaktifkan koridor ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Nonaktifkan Koridor'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('dashboard/master/shelter/disable') }}',
                            method: 'post',
                            data: {id: id},
                            success: function (response) {
                                if (response === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Koridor nonaktif',
                                        onClose(modalElement) {
                                            listTable.setData();
                                        }
                                    });
                                } else {
                                    console.log(response);
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Gagal',
                                        text: 'Gagal reset Password, silahkan coba lagi.',
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
                });
            });
            btnActivate.click(function (e) {
                e.preventDefault();
                let id = listTable.getSelectedData()[0].id;
                Swal.fire({
                    title: 'Aktifkan koridor ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aktifkan Koridor'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('dashboard/master/shelter/activate') }}',
                            method: 'post',
                            data: {id: id},
                            success: function (response) {
                                if (response === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Koridor telah aktif',
                                        onClose(modalElement) {
                                            listTable.setData();
                                        }
                                    });
                                } else {
                                    console.log(response);
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Gagal',
                                        text: 'Gagal reset Password, silahkan coba lagi.',
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
                });
            });
    
    </script>
@endsection
