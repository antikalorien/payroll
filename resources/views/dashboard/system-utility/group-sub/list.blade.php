@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Group-Sub Menu</h4>
                    </div>
                    <div class="card-body">
                        <table id="listTable" class="table table-striped table-bordered display nowrap" style="width: 100%">
                            <thead>
                            <tr>
                            <th>Status</th>
                            <th>Ord</th>
                                <th>ID Group Sub</th>
                                <th>Group Sub</th>
                                <th>Updated At</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-end">
                            <div class="col-sm-12 col-lg-3 mt-2 mt-lg-0">
                                    <div class="btn-group btn-block mb-3" role="group" aria-label="Basic example">
                                        <button type="button" id="btnDisable" class="btn btn-danger" disabled>
                                            <i class="fas fa-times mr-2"></i>Disable
                                        </button>
                                        <button type="button" id="btnActivate" class="btn btn-success" disabled>
                                            <i class="fas fa-check mr-2"></i>Activate
                                        </button>
                                    </div>
                            </div>
                            <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                                <button type="button" id="btnEdit" class="btn btn-block btn-outline-info" disabled>
                                    <i class="fas fa-pencil-alt mr-2"></i>Edit
                                </button>
                            </div>
                            <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                                <a href="{{ url('system-utility/menu-group/baru') }}" class="btn btn-block btn-primary">
                                    <i class="fas fa-plus mr-2"></i>Tambah
                                </a>
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
        let btnEdit = $('#btnEdit');
        const btnDisable = $('#btnDisable');
        const btnActivate = $('#btnActivate');
        let dataID;

        $(document).ready(function () {
            let listTable = $('#listTable').DataTable({
                scrollX: true,
                order: [
                    [ 1, 'asc' ],
                ],
                ajax: {
                    url: '{{ url('dashboard/system-utility/group-sub/list/data') }}'
                },
                columns: [
                    {data: 'status',
                        render: function(data, type) {
                            let color;
                        if (data == '1') {
                            status = 'ACTIVE';
                            color = 'green';
                        }
                        
                        else if (data == '2') {
                            status = 'NON ACTIVE';
                            color = 'red';
                        }
                        return '<span style="color:' + color + '">' + status + '</span>';
                    }

                    },
                    {data: 'ord'},
                    {data: 'idSubGroup'},
                    {data: 'subGroup'},
                    {data: 'updatedAt'},
                ],
            });
            $('#listTable tbody').on('click','tr',function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    btnEdit.attr('disabled',true);
                    btnDisable.attr('disabled',true);
                    btnActivate.attr('disabled',true);

                    dataID = null;
                } else {
                    listTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    btnEdit.removeAttr('disabled');
                    btnDisable.removeAttr('disabled');
                    btnActivate.removeAttr('disabled');

                    let data = listTable.row('.selected').data();
                    dataID = data.idSubGroup;
                }
            });

            btnEdit.click(function (e) {
                e.preventDefault();
                window.location = '{{ url('dashboard/system-utility/group-sub/edit') }}/'+dataID;
            })
        });


        btnDisable.click(function (e) {
                e.preventDefault();
                    Swal.fire({
                    title: "Apakah ingin Disable data ini",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Disable'
                    }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('dashboard/system-utility/group-sub/disable') }}',
                            method: 'post',
                            data: {id_sub_group: dataID},
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

            btnActivate.click(function (e) {
                e.preventDefault();
                    Swal.fire({
                    title: "Apakah ingin Activate data ini",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Activate'
                    }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('dashboard/system-utility/group-sub/activate') }}',
                            method: 'post',
                            data: {id_sub_group: dataID},
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
    </script>
@endsection
