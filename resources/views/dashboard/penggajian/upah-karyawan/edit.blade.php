@extends('dashboard.layout')

@section('content')
    <div class="section-body">
    <form id="formData">
    <input type="hidden" name="idKaryawan" value="{{$data['user']->idAbsen}}">
    <div class="card text-center" style="width: 100%;">
                            <img src="{{ asset('assets/logo/BG-HeaderUpahKaryawan.jpg') }}" class="card-img">
                    </div>
        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="{{ (isset($data['user']->idAbsen)) ? url('storage/'.$data['user']->idAbsen.'.jpg') : asset('assets/img/avatar/avatar-3.png') }}" class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">          
                                <div class="profile-widget-item-value">Data Karyawan</div>
                                <div class="profile-widget-item-value">{{$periode->periode}}</div>
                                <input type="hidden" name="idPeriode" value="{{$periode->idPeriode}}">
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <table class="table table-sm table-striped table-borderless">
                            <tbody>
                            <tr>
                                <th>Departemen</th>
                                <td>{{ $data['user']->departemen }}</td>
                            </tr>
                            <tr>
                                <th>Sub-Departemen</th>
                                <td>{{ $data['user']->subDepartemen }}</td>
                            </tr>
                            <tr>
                                <th>Pos</th>
                                <td>{{ $data['user']->pos }}</td>
                            </tr>
                            <tr>
                                <th>Grade</th>
                                <td>{{ $data['user']->grade }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $data['user']->name }}</td>
                            </tr>
                            <tr>
                                <th>ID Karyawan</th>
                                <td>{{ $data['user']->idAbsen }}</td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td>{{ $data['user']->nik }}</td>
                            </tr>
                            <tr>
                                <th>Masa Kerja</th>
                                <td>{{ $data['user']->masaKerja }} (bulan)</td>
                            </tr>
                            <tr>
                                <th>Usia</th>
                                <td>{{ $data['user']->usia }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Bergabung</th>
                                <td> <div class="form-group">
                                        <input type="text" id="iTglBergabung" name="tanggalBergabung" class="form-control" value="{{ $data['user']->doj }}">
                                    </div></td>
                            </tr>

                            <tr>
                                <th>No Rekening</th>
                                <td>
                                <div class="form-group">
                          
                                        <input type="text" id="iNoRekening" name="noRekening" class="form-control" value="{{ $data['user']->noRekening }}">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th>Tipe Kontrak</th>
                                <td>
                                    <select class="form-control" id="iTipeKontrak" name="tipeKontrak">  
                                        <option value="{{ $data['user']->tipeKontrak }}" selected="selected">{{ $data['user']->tipeKontrak }}</option>
                                            <option value="PKWT">PKWT</option>
                                            <option value="PKWTT">PKWTT</option>
                                        </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Skema Hari Kerja</th>
                                <td>
                                        <select class="form-control" id="iSkemaHariKerja" name="skemaHariKerja">  
                                        <option value="{{ $data['user']->skema }}" selected="selected">{{ $data['user']->skema }}</option>
                                            <option value="SK001">5-2</option>
                                            <option value="SK002">5-1</option>
                                            <option value="SK003">6-1</option>
                                        </select>
                               </td>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>Tipe BPJS</th>
                                <td>
                                        <select class="form-control" id="iTipeBpjs" name="tipeBpjs">
                                        <option value="{{ $data['user']->tipeBpjs }}" selected="selected">{{ $data['user']->tipeBpjs }}</option>
                                            <option value="0">(0) Normal</option>
                                            <option value="1">(1) Perusahaan</option>
                                            <option value="2">(2) Tidak Ikut</option>
                                        </select>
                               </td>
                            </tr>

                            <tr>
                                <th>Status Karyawan</th>
                                <td>
                                        <select class="form-control" id="iStatusSkemaGaji" name="statusSkemaGaji">
                                        <option value="{{ $data['user']->statusSkemaGaji }}" selected="selected">{{ $data['user']->statusSkemaGaji }}</option>
                                      
                                            <option value="1">(1) Aktif</option>
                                            <option value="2">(2) Non Aktif</option>
                                            
                                        </select>
                               </td>
                            </tr>

                            <tr>
                                <th>Skema Penggajian</th>
                                <td>
                                        <select class="form-control" id="iSkemaGaji" name="skemaGaji">
                                        <option value="{{ $data['user']->skemaGaji }}" selected="selected">{{ $data['user']->skemaGaji }}</option>
                                  
                                            <option value="1">(1) Normal</option>
                                            <option value="2">(2) Harian</option>
                                            <option value="3">(3) Setengah (50%)</option>
                                        </select>
                               </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- <div class="card-footer text-center">
                            <button type="submit" class="btn btn-warning">Edit Profile</button>
                        </div> -->
                        <hr>                       
                        </div>
                        
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                        <div class="alert alert-info" >
                            <h4>Penggajian - Edit Upah Karyawan</h4>
                        </div>
                        <div class="card-body">
                        @php($i_=1)
                        @foreach($permison as $g)
                        <hr>
                        @if($g['group']['status'] != 0)
                        <div class="row">
                            <div class="col-lg-3">
                                <h6 class="ml-5">{{ $g['group']['name'] }}</h6>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">  
                                    @foreach($g['menu'] as $m)
                                    <div class="col-lg-12">
                                        <div class="custom-control custom-checkbox">
                                            @if(in_array($m['id_variable'],$check))
                                            <input type="checkbox" name="permission[]" class="custom-control-input" id="permission_{{ $m['id'] }}" value="{{ $m['id'] }}" checked>
                                            @else
                                            <input type="checkbox" name="permission[]" class="custom-control-input" id="permission_{{ $m['id'] }}" value="{{ $m['id'] }}">
                                            @endif
                                            <label class="custom-control-label" >{{ $m['variable'] }}</label>
                                            @if($i_ <= 10)  
                                            <input name="variabel[{{ $m['id_variable'] }}]" type="text" class="form-control" id="{{ $m['id_variable'] }}" value="{{ $m['nominal'] }}" >
                                            @if($m['id_variable']=='VR-007' || $m['id_variable']=='VR-012')
                                            <textarea name="variabel[ket-{{ $m['id_variable'] }}]" class="form-control" id="ket-{{ $m['id_variable'] }}" style="height: 137px" placeholder="Keterangan...">{{ $m['keterangan'] }}</textarea>
                                            @endif
                                            @else
                                            <input name="variabels[{{ $m['id_variable'] }}]" type="text" class="form-control" id="{{ $m['id_variable'] }}" value="{{ number_format($m['nominal']) }}"readOnly >
                                            @endif
                                        </div>
                                    </div>
                                    @php($i_++)
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        </div>
                        <div class="card-footer bg-whitesmoke">
                            <div class="row justify-content-end">
                                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                                    <button type="button" class="btn btn-block btn-outline-danger" onclick="window.location = '{{ url('dashboard/penggajian/upah-karyawan') }}'">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </button>
                                </div>
                                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                                    <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-check mr-2"></i>Simpan</button>
                                </div>
                            </div>
                        </div>
                   
                </div>
                
            </div>
        </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        let formData = $('#formData');

        $(document).ready(function () {
           
        });
        formData.submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('dashboard/penggajian/upah-karyawan/submit') }}",
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
                                window.location = '{{ url()->previous() }}';
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
    </script>
@endsection