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
                        <h4>Tambah Departemen Baru</h4>
                    </div>
                    <form id="formData">
                            <div class="modal-body">
                                <label for="provi">Nama Karyawan</label>
                                <div class="form-group">
                                    <select style="width: 100%" id="iNamaKaryawan" name="idKaryawan" required></select>
                                </div>
                                
                                <div class="form-group">
                                <label for="iTglLahir">Tanggal Lembur</label>
                                        <input type="text" id="iTanggalLembur" name="tglLembur" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Jam Lembur</label>
                                    <input name="jamLembur" type="text" class="form-control" autofocus>
                                    <small>*Untuk penulisan tanda koma wajib menggunakan tanda titik (.)</small>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input name="keterangan" type="text" class="form-control" autofocus>
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

        
        let iNamaKaryawan = $('#iNamaKaryawan');
        let iTanggalLembur = $('#iTanggalLembur');

        $(document).ready(function () {

            iNamaKaryawan.select2({
                ajax: {
                url: '{{ url("namaKaryawanPeriode") }}',
                dataType: 'json',

                data: function(params) {
                    return {
                        search: params.term,
                    }
                }
                }
            });

            iTanggalLembur.daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD MMMM YYYY'
                }
            });

          formData.submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('dashboard/penggajian/data-lembur/submit') }}",
                method: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Tersimpan',
                            showConfirmButton: false,
                            timer: 1000,
                            onClose: function() {
                                window.location = "{{ url('dashboard/penggajian/data-lembur') }}";
                            }
                        });
                    } else {
                        console.log(response);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Gagal Tersimpan',
                            text: response,
                        });
                    }
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Data Gagal Tersimpan',
                        text: response,
                    });
                }
            })
        })
        });
    </script>
@endsection
