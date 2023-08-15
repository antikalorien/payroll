@extends('dashboard.layout')

@php
$menu = \App\Http\Controllers\c_Dashboard::sidebar();
@endphp

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah User Baru</h4>
                </div>
                <form id="formData">
                    <input type="hidden" name="type" value="baru">
                    <div class="card-body">
                        <label for="provi">Departemen</label>
                        <div class="form-group">
                            <select style="width: 100%" id="iDepartemen" name="departemen" required></select>
                        </div>

                        <label for="provi">Sub Departemen</label>
                        <div class="form-group">

                            <select style="width: 100%" id="iSubDepartemen" name="subDepartemen" required></select>
                        </div>

                        <div class="form-group">
                            <label>Pos</label>
                            <input name="pos" type="text" class="form-control" autofocus>
                        </div>

                        <label for="provi">Grade</label>
                        <div class="form-group">
                            <select style="width: 100%" id="iGrade" name="grade" required></select>
                        </div>

                        <div class="form-group">
                            <label>ID Absen (4 digit)</label>
                            <input name="idAbsen" type="text" class="form-control" autofocus>

                        </div>

                        <div class="form-group">
                            <label>NIP</label>
                            <input name="username" type="text" class="form-control" autofocus>
                            <small>Password untuk user baru sama dengan NIP. Setiap user dapat mengganti password melalui menu User Profile.</small>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" type="text" class="form-control">
                        </div>

                        <label for="provi">Skema Hari Kerja</label>
                        <div class="form-group">
                            <select style="width: 100%" id="iSkemaHariKerja" name="skemaHariKerja" required></select>
                        </div>

                        <label for="provi">Tanggal Bergabung</label>
                        <div class="form-group">
                            <input type="text" id="iTanggalBergabung" name="tanggalBergabung" class="form-control">
                        </div>

                        <label for="provi">Tanggal Lahir</label>
                        <div class="form-group">
                        <input type="text" id="iTanggalLahir" name="tanggalLahir" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="iSystem">System</label>
                            <select class="form-control" id="iSystem" name="system">
                                <option value="1">Karyawan</option>
                                <option value="2">Super User</option>
                            </select>
                        </div>

                        <!-- Super User - Permission Access -->
                        @if(request()->session()->get('system')==2)
                        <hr>
                        <h5>Permission</h5>
                            @foreach($menu as $g)
                            <hr>
                            @if($g['group']['status'] !== 1)
                            <div class="row">
                                <div class="col-lg-3">
                                    <h6 class="ml-5">{{ $g['group']['name'] }}</h6>
                                </div>
                                <div class="col-lg-9">
                                    <div class="row">
                                        @foreach($g['menu'] as $m)
                                        <div class="col-lg-4">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="permission[]" class="custom-control-input" id="permission_{{ $m['id'] }}" value="{{ $m['id'] }}">
                                                <label class="custom-control-label" for="permission_{{ $m['id'] }}">{{ $m['name'] }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        @endif
                        <!-- end Permission Access -->
                        
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
    let iSubDepartemen = $('#iSubDepartemen');
    let iGrade = $('#iGrade');
    let iSkemaHariKerja = $('#iSkemaHariKerja');
    let dataID;

    const iTanggalBergabung = $('#iTanggalBergabung').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
    });

    const iTanggalLahir = $('#iTanggalLahir').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
    });

    $(document).ready(function() {

        iSkemaHariKerja.select2({
            ajax: {
                url: '{{ url("skema_hariKerja") }}',
                dataType: 'json',

                data: function(params) {
                    return {
                        search: params.term,
                    }
                }
            }
        });

        iDepartemen.select2({
            ajax: {
                url: '{{ url("list_departemen") }}',
                dataType: 'json',

                data: function(params) {
                    return {
                        search: params.term,
                    }
                }
            }
        });

        iDepartemen.change(function() {
            var value = $(this).val();
            dataID = value;

            iSubDepartemen.select2({
                ajax: {
                    url: '{{ url("list_subDepartemen") }}/' + dataID,
                    dataType: 'json',

                    data: function(params) {
                        return {
                            search: params.term,
                        }
                    }
                }
            });
        });

        
        iGrade.select2({
            ajax: {
                url: '{{ url("list_grade") }}',
                dataType: 'json',

                data: function(params) {
                    return {
                        search: params.term,
                    }
                }
            }
        });

        formData.submit(function(e) {

            e.preventDefault();
                    Swal.fire({
                    title: "Simpan Data?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Simpan',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                   
                    }).then((result) => { 
                    if (result.value) {
                        Swal.fire({
                        title: 'Mohon Ditunggu !',
                        html: 'sedang memproses data...',// add html attribute if you want or remove
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                        Swal.showLoading()
                        },
                        });
                        $.ajax({
                            url: '{{ url('dashboard/master/user-management/submit') }}',
                            method: 'post',
                            data: $(this).serialize(),
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