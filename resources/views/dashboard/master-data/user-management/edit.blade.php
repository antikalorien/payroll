@extends('dashboard.layout')

@section('page_menu')
<li class="nav-item {{ (request()->segment(4) == null) ? 'active' : '' }}">
    <a href="{{ url(request()->segment(1).'/'.request()->segment(2).'/'.request()->segment(3)) }}" class="nav-link">
        <i class="fas fa-plus-circle mr-2" style="font-size: x-large; vertical-align: middle;"></i>
        <div class="d-none d-lg-inline-block d-xl-inline-block">Tambah User</div>
    </a>
</li>
<li class="nav-item {{ (request()->segment(4) == 'list') ? 'active' : '' }}">
    <a href="{{ url(request()->segment(1).'/'.request()->segment(2).'/'.request()->segment(3)) }}/list" class="nav-link">
        <i class="fas fa-table mr-2" style="font-size: x-large; vertical-align: middle;"></i>
        <span class="d-none d-lg-inline-block d-xl-inline-block">
            Daftar User
        </span>
    </a>
</li>
@endsection

@section('title','Master User')

@php
$menu = \App\Http\Controllers\c_Dashboard::sidebar();
@endphp

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit User</h4>
                </div>
                <form id="formData">
                    <input type="hidden" name="type" value="edit">
                    <div class="card-body">

                        <label for="provi">Departemen</label>
                        <div class="form-group">
                            <select style="width: 100%" id="iDepartemen" name="departemen">
                                <option value="{{ $data->idDepartemen }}" selected="selected">{{ $data->departemen }}</option>
                            </select>
                        </div>

                        <label for="provi">Sub Departemen</label>
                        <div class="form-group">
                            <select style="width: 100%" id="iSubDepartemen" name="subDepartemen" required>
                                <option value="{{ $data->idDepartemenSub }}" selected="selected">{{ $data->subDepartemen }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Pos</label>
                            <input name="pos" type="text" class="form-control" value="{{ $data->pos }}">
                        </div>

                        <label for="provi">Grade</label>
                        <div class="form-group">
                            <select style="width: 100%" id="iGrade" name="grade" required>
                            <option value="{{ $data->idGrade }}" selected="selected">{{ $data->grade }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>NIP</label>
                            <input name="username" type="text" class="form-control" value="{{ $data->nip }}" >
                        </div>

                        <div class="form-group">
                            <label>ID Absen</label>
                            <input name="idAbsen" type="text" class="form-control" value="{{ $data->idAbsen }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="name" type="text" class="form-control" value="{{ $data->name }}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" type="text" class="form-control" value="{{ $data->email }}">
                            <small>
                                Anda tidak harus mengisi email.
                            </small>
                        </div>

                        <label for="provi">Skema Hari Kerja</label>
                        <div class="form-group">
                            <select style="width: 100%" id="iSkemaHariKerja" name="skemaHariKerja" required>
                                <option value="{{ $data->idSkemaHariKerja }}" selected="selected">{{ $data->skema }}</option>
                            </select>
                        </div>

                        <label for="provi">Tanggal Bergabung</label>
                        <div class="form-group">
                            <input type="text"  id="iTanggalBergabung" name="tanggalBergabung" class="form-control" value="{{ $data->doj }}">
                        </div>

                        <label for="provi">Tanggal Lahir</label>
                        <div class="form-group">
                        <input type="text"  id="iTanggalLahir"  name="tanggalLahir" class="form-control" value="{{ $data->dob }}">
                        </div>

                        <div class="form-group">
                            <label for="iSystem">System</label>
                            <select class="form-control" id="iSystem" name="system">
                            <option value="{{ $data->system }}" selected="selected">{{ $data->system }}</option>
                                <option value="1">(1) Karyawan</option>
                                <option value="2">(2) Super User</option>
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
                                            @if(in_array($m['id'],$check))
                                            <input type="checkbox" name="permission[]" class="custom-control-input" id="permission_{{ $m['id'] }}" value="{{ $m['id'] }}" checked>
                                            @else
                                            <input type="checkbox" name="permission[]" class="custom-control-input" id="permission_{{ $m['id'] }}" value="{{ $m['id'] }}">
                                            @endif
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
                                <button type="button" class="btn btn-block btn-outline-danger" onclick="window.location = '{{ url()->previous() }}'">
                                    <i class="fas fa-times mr-2"></i>Cancel
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
    let iDepartemen = $('#iDepartemen');
    let iSubDepartemen = $('#iSubDepartemen');
    let iGrade = $('#iGrade');
    let iSkemaHariKerja = $('#iSkemaHariKerja');

    const iSystem = $('#iSystem');

    const iTanggalBergabung = $('#iTanggalBergabung').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
    });

    const iTanggalLahir = $('#iTanggalLahir').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
    });



    $(document).ready(function() {


        iSkemaHariKerja.select2({
            ajax: {
                url: "{{ url('skema_hariKerja') }}",
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
                url: "{{ url('list_departemen') }}",
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
                    url: "{{ url('list_subDepartemen') }}/" + dataID,
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
            $.ajax({
                url: "{{ url('dashboard/master/user-management/submit') }}",
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
                                window.location = "{{ url('dashboard/master/user-management/list') }}";
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