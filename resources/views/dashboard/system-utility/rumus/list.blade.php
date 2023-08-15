@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Grouping Rumus</h4>
                    </div>
                    <div class="card-body">
                        <table id="listTable" class="table table-striped table-bordered display nowrap" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Status</th>
                                <th>ID Rumus</th>
                                <th>ID Group</th>
                                <th>Group Rumus</th>
                                <th>Keterangan</th>
                                <th>UpdatedAt</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-end">
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

        let dataID;

        $(document).ready(function () {
            let listTable = $('#listTable').DataTable({
                scrollX: true,
                order: [
                    [ 0, 'asc' ],
                ],
                ajax: {
                    url: '{{ url('dashboard/system-utility/group-rumus/list/data') }}' 
                },
                columns: [
                    {data: 'status',
                        render: function(data, type) {
                            let color;
                        if (data == '1') {
                            status = 'ACTIVE';
                            color = 'green';
                        }
                        
                        else if (data == '0') {
                            status = 'NON ACTIVE';
                            color = 'red';
                        }
                        return '<span style="color:' + color + '">' + status + '</span>';
                    }

                    },
                    {data: 'idRumus'},
                    {data: 'idGroup'},
                    {data: 'groupRumus'},
                    {data: 'keterangan'},
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
                    dataID = data.idVariable;
                }
            });

            btnEdit.click(function (e) {
                e.preventDefault();
                window.location = '{{ url('dashboard/system-utility/group-sub-variable/edit') }}/'+dataID;
            })
        });
    </script>
@endsection
