@extends('dashboard.layout')

@section('page_menu')
    <li class="nav-item active">
        <a href="{{ url(request()->segment(1).'/'.request()->segment(2).'/'.request()->segment(3)) }}" class="nav-link">Tambah Menu</a>
    </li>
    <li class="nav-item">
        <a href="{{ url(request()->segment(1).'/'.request()->segment(2).'/'.request()->segment(3)) }}/list" class="nav-link">List Menu</a>
    </li>
@endsection

@section('title','System Utility - Menu')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Sub-Departemen Baru</h4>
                    </div>
                    <form id="formData">
                        <input type="hidden" name="type" value="baru">
                        <div class="card-body">
                        <label for="provi">Departemen</label>
                            <div class="form-group">
                                <select style="width: 100%" id="iDepartemen" name="departemen" required></select>
                            </div>  
                            <div class="form-group">
                                <label>ID Sub Departemen</label>
                                <input name="idSubDepartemen" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Sub-Departemen</label>
                                <input name="subDepartemen" type="text" class="form-control">
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
    <script type="text/javascript">
        let formData = $('#formData');
        let iDepartemen = $('#iDepartemen');

        $(document).ready(function () {

            
            iDepartemen.select2({
            ajax: {
            url: '{{ url('list_departemen') }}',
            dataType: 'json',

            data: function (params) {
                return {
                    search: params.term,
                }
            }
            } 
            });

            iDepartemen.change(function(){
                var value = $(this).val();
                dataID = value;   
            });

            
            $('#listTable').DataTable({
                responsive: true
            });

            formData.submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ url('dashboard/master/sub-departemen/submit') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Tersimpan',
                                showConfirmButton: false,
                                timer: 1000,
                                onClose: function () {
                                    window.location = '{{ url('dashboard/master/sub-departemen') }}';
                                }
                            });
                        } else {
                            console.log(response);
                            Swal.fire({
                                icon: 'error',
                                title: 'Data Gagal Tersimpan',
                                text: 'Silahkan coba lagi atau hubungi Developer',
                            });
                        }
                    },
                    error: function (response) {
                        console.log(response);
                    }
                })
            })
        });
    </script>
@endsection
