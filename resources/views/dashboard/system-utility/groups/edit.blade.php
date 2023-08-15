@extends('dashboard.layout')

@section('title','System Utility - Group Menu')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Group Menu</h4>
                    </div>
                    <form id="formData">
                        <input type="hidden" name="type" value="edit">
                        <div class="card-body">
                            <div class="form-group">
                                <label>ID Group</label>
                                <input name="id_group" type="text" class="form-control" value="{{ $data->idGroup }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Ord</label>
                                <input name="ord" type="text" class="form-control" value="{{ $data->ord }}">
                            </div>
                            <div class="form-group">
                                <label>Group Name</label>
                                <input name="group" type="text" class="form-control" value="{{ $data->group }}">
                            </div>
                           
                        </div>
                        <div class="card-footer bg-whitesmoke">
                            <div class="row justify-content-end">
                                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                                    <button type="button" class="btn btn-block btn-outline-danger" onclick="window.location = '{{ url()->previous() }}'">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </button>
                                </div>
                                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                                    <button type="submit" id="btnBaru" class="btn btn-block btn-success">
                                        <i class="fas fa-check mr-2"></i>Simpan
                                    </button>
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

        $(document).ready(function () {
            $('#listTable').DataTable({
                responsive: true
            });

            formData.submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ url('dashboard/system-utility/group/submit') }}',
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
                                    window.location = '{{ url('dashboard/system-utility/group/list') }}';
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
                    }
                })
            })
        });
    </script>
@endsection
