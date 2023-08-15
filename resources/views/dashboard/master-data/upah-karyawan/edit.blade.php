@extends('dashboard.layout')

@section('content')
    <div class="section-body">
    <form id="formData">
    <input type="hidden" name="idKaryawan" value="{{$data['user']->idAbsen}}">
        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="{{ (isset($data['user']->idAbsen)) ? url('storage/'.$data['user']->idAbsen.'.jpg') : asset('assets/img/avatar/avatar-3.png') }}" class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">          
                                <div class="profile-widget-item-value">Data Karyawan</div>
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
                                <td>{{ $data['user']->username }}</td>
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
                        @if($data['profile'] !== null)
                            <div class="alert alert-info" >
                        <div class="profile-widget-item-label">Terdaftar sejak</div>
                        <h4>{{ date('d F Y', strtotime( $data['user']->created_at )) }}</h4>
                        </div>
                        @else
                            <div class="alert alert-danger" role="alert">
                                Silahkan lengkapi Data Profil Karyawan
                            </div>
                        @endif
                        </div>
       
                        <!-- <div class="card-body">
                            <div class="row">
                                <div class="col-6">

                                    <div class="form-group">
                                        <label for="iEmail">Email</label>
                                        <input type="email" id="iEmail" name="email" class="form-control" value="{{ $data['user']->email }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="iNoTelp">No Telp</label>
                                        <input type="text" id="iNoTelp" name="noHp" class="form-control" value="{{ $data['user']->noHp }}">
                                    </div>

                                 

                                    <div class="form-group">
                                        <label for="iTempatLahir">Tempat Lahir</label>
                                        <input type="text" id="iTempatLahir" name="tempatLahir" class="form-control" value="{{ $data['profile']->tempat_lahir ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="iTglLahir">Tanggal Lahir</label>
                                        <input type="text" id="iTglLahir" name="tanggalLahir" class="form-control" value="{{ $data['profile']->tgl_lahir ?? '' }}">
                                    </div>

                                    <div class="form-group" >
                                        <label for="iJenisKelamin">Jenis Kelamin</label>
                                        <select class="form-control" id="iJenisKelamin" name="jenisKelamin">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="l">Laki-laki</option>
                                            <option value="p">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="iAlamat">Alamat</label>
                                        <textarea class="form-control" id="iAlamat" name="alamat" rows="4" style="height: 137px"></textarea>
                                    </div>

                                </div>
                                <div class="col-6">
                

                                    <div class="form-group">
                                        <label for="iAgama">Agama</label>
                                        <select class="form-control" id="iAgama">
                                            <option value="">Pilih Agama</option>
                                            <option value="islam">Islam</option>
                                            <option value="kristen">Kristen</option>
                                            <option value="katolik">Katolik</option>
                                            <option value="hindu">Hindu</option>
                                            <option value="budha">Buddha</option>
                                            <option value="khonghucu">Khonghucu</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="iNoKtp">No KTP</label>
                                        <input type="text" id="iNoKtp" name="no_ktp" class="form-control" value="{{ $data['profile']->no_ktp ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="iTingkatPendidikan">Tingkat Pendidikan</label>
                                        <select class="form-control" id="iTingkatPendidikan">
                                            <option value="">Pilih Pendidikan Terakhir</option>
                                            <option value="sd">SD</option>
                                            <option value="smp">SMP</option>
                                            <option value="sma/smk">SMA / SMK</option>
                                            <option value="d3">D3</option>
                                            <option value="s1">S1</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="iJurusan">Jurusan</label>
                                        <input type="text" id="iJurusan" name="jurusan" class="form-control" value="{{ $data['profile']->jurusan ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="iKeterangan">Keterangan Tambahan</label>
                                        <input type="text" id="iKeterangan" name="keterangan" class="form-control" value="{{ $data['profile']->keterangan ?? '' }}">
                                    </div>
                                </div>
                            </div>

                        </div> -->
                        <!-- <div class="card-footer text-right">
             
                            <button type="button" id="btnEdit" class="btn btn-primary">
                                    <i class="fas fa-pencil-alt mr-2"></i>Simpan Data Karyawan
                                </button>
                        </div> -->   
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                        <div class="alert alert-info" >
                            <h4>Edit Upah Karyawan</h4>
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
                                            @if($i_ <= 7)  
                                            <input name="variabel[{{ $m['id_variable'] }}]" type="text" class="form-control" id="{{ $m['id_variable'] }}" value="{{ $m['nominal'] }}" >
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
                                    <button type="button" class="btn btn-block btn-outline-danger" onclick="window.location = '{{ url('master-data-upah-karyawan') }}'">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </button>
                                </div>
                                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                                    <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-check mr-2"></i>Simpan</button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>  -->
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
                url: "{{ url('dashboard/master-data/upah-karyawan/submit') }}",
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