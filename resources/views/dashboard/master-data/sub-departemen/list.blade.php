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
                        <h4>List Departemen</h4>
                    </div>
                    <div class="card-body">
                        <table id="listTable" class="table table-striped table-bordered display nowrap" style="width: 100%">
                            <thead>
                             <tr>
                                <th>Status</th>
                                <th>Departemen</th>
                                <th>ID Sub Departemen</th>
                                <th>Sub Departemen</th>  
                                <th>Updated At</th>                   
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
                                <a href="{{ url('dashboard/master/sub-departemen') }}" class="btn btn-block btn-primary">
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
               
                ajax: {
                    url: '{{ url('dashboard/master/sub-departemen/data') }}'
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
                        else {
                            status = 'Error';
                            color = 'orange';
                        }
                        return '<span style="color:' + color + '">' + status + '</span>';
                    }
                    },
                    {data: 'departemen'},
                    {data: 'id_subDepartemen'},
                    {data: 'sub_departemen'},
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
                    dataID = data.id;
                }
            });

            btnEdit.click(function (e) {
                e.preventDefault();
                window.location = '{{ url('dashboard/master/sub-departemen/edit') }}/'+dataID;
            })
        });
    </script>
@endsection
