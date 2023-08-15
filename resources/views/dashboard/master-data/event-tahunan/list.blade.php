@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar {{ ucfirst(request()->segment(3)) }}</h4>
                    </div>
            

                    <div class="card-body">
           
                    
                    <table id="listTable" class="table table-striped table-bordered display nowrap" style="width: 100%">
                            <thead>
                            <tr>
                            <th>ID</th>
                            <th>ID Event</th>
                                <th>Tanggal</th>
                                <th>Event</th>
                                <th>Reff</th>
                            </tr>
                            </thead>
                        </table>
                     
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-end">
                        <div class="col-sm-12 col-lg-3 mt-2 mt-lg-0">
                                <div class="btn-group btn-block mb-3" role="group" aria-label="Basic example">
                                    <button type="button" id="btnDisable" class="btn btn-danger ">
                                        <i class="fas fa-times mr-2"></i>Disable
                                    </button>
                                    <button type="button" id="btnActivate" class="btn btn-success ">
                                        <i class="fas fa-check mr-2"></i>Activate
                                    </button>
                                </div>
                            </div>
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
      
        let btnEdit = $('#btnEdit');
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
                scrollX: true,
                bDestroy: true,
                order: [
                    [ 0, 'asc' ],
                ],
               ajax: {
                    url: "{{ url('dashboard/master/event-tahunan/data') }}" 
                },
                columns: [
                    
                    {data: 'id'},
                    {data: 'id_event'}, 
                    {data: 'tanggal'},              
                    {data: 'event'},
                    {data: 'reff'},
                   
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
                console.log(dataID);
            });

            });

            btnEdit.click(function (e) {
                e.preventDefault();
                //  let id = listTable.getSelectedData()[0].id;
           
                window.location = '{{ url('dashboard/master/input-jadwal/edit') }}/'+dataID;
            });

    
    </script>
@endsection
