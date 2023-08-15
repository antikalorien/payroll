@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ ucfirst(request()->segment(3)) }}</h4>
                    </div>
                    <form id="formData">
                        <input type="hidden" name="type" value="baru">
                        <input type="hidden" id="iUsername" name="username" value="{{ request()->session()->get('username') }}">
                        <div class="card-body">
                        <label for="provi">Group Rumus : </label>
                            <div class="form-group">
                      
                                <select style="width: 50%" id="idGroup" name="idGroup" required></select>
                            </div>
                            <label for="provi">Group-Sub : </label>
                            <div class="form-group">
                      
                                <select style="width: 50%" id="idSubGroup" name="idSubGroup" required></select>
                            </div>
                         
                            <div class="form-group">
                            <table id="tableIndex" class="table table-striped table-bordered display nowrap" style="width: 100%">
                                    <thead clas="bg-dark">
                                    <tr>
                                    <th>ID</th>
                                    <th>ID Variable</th>
                                    <th>Variable</th>
                                   
                                    </tr>
                                    </thead>
                                </table>
                              
                            </div>
                        </div>
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
        let idGroup = $('#idGroup');
        let idSubGroup = $('#idSubGroup');
        let iUsername = $('#iUsername');

        $(document).ready(function () {

            idGroup.select2({
                ajax: {
                    url: '{{ url('spGroup') }}',
                    dataType: 'json',

                    data: function (params) {
                        return {
                            search: params.term,
                        }
                    }
                }
            });


            idGroup.change(function(){
                var value = $(this).val();
                dataIdGroup = value;
            })

            idSubGroup.select2({
                ajax: {
                    url: '{{ url("spGroupSub") }}',
                    dataType: 'json',

                    data: function (params) {
                        return {
                            search: params.term,
                        }
                    }
                }
            });

            idSubGroup.change(function(){
                var value = $(this).val();
                dataIdSubGroup = value;
                getDataTable(); 
            })



            function getDataTable(){
                let tableIndex = $('#tableIndex').DataTable({
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
                "url": "{{ url('dashboard/system-utility/grouping-sub-variable/list/data') }}/"+ dataIdGroup +"/"+dataIdSubGroup,
                "header": {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
                "complete": function (xhr,responseText) {
                    if (responseText === 'error') {
                        console.log(xhr);
                        console.log(responseText);
                    }
                }
            },
            "columns": [
                {data: 'idVariable'},
                  {data: 'idVariable'},
                  {data: 'variable'},
            ],
        });

        $('#tableIndex tbody').on( 'click', 'tr', function () {
            let data = tableIndex.row( this ).data();
            
        });  
            }

            formData.submit(function (e) {
                e.preventDefault();
                let tables = $('#tableIndex').DataTable();
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

                    console.log(array_select);

                    Swal.fire({
                    title: "Apakah ingin menyimpan data ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Simpan'
                    }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('dashboard/system-utility/grouping-sub-variable/submit') }}',
                            method: 'post',
                            data: {id: array_select,id_group:dataIdGroup,id_sub_group:dataIdSubGroup},
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
           
            })
        });
    </script>
@endsection