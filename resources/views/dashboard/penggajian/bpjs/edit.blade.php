@extends('dashboard.layout')

@section('content')
    <div class="section-body">
    <form id="formData">
    <input type="hidden" name="idKaryawan" value="{{$data['user']->idAbsen}}">
            <div class="card text-center" style="width: 100%;">
                <img src="{{ asset('assets/logo/Header-bpjs.jpg') }}" class="card-img">
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
                                <input type="hidden" id="idPeriode" name="idPeriode" value="{{$periode->idPeriode}}">
                                <input type="hidden" id="idKaryawan" name="idKaryawan" value="{{$data['user']->idAbsen}}">
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
                                <td>{{ $data['user']->doj }}</td>
                            </tr>

                            <tr>
                                <th>No Rekening</th>
                                <td>{{ $data['user']->noRekening }}</td>
                            </tr>

                            <tr>
                                <th>Tipe Kontrak</th>
                                <td>{{ $data['user']->tipeKontrak }}</td> 
                            </tr>

                            <tr>
                                <th>Skema Hari Kerja</th>
                                <td>{{ $data['user']->skema }}</td> 
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
                                @if($data['user']->statusSkemaGaji==1)
                                <td>Aktif</td> 
                                @elseif($data['user']->statusSkemaGaji==2)
                                <td>Tidak Aktif</td> 
                                @endif
                            </tr>

                            <tr>
                                <th>Skema Penggajian</th>
                                @if($data['user']->skemaGaji==1)
                                <td>Normal</td> 
                                @elseif($data['user']->skemaGaji==2)
                                <td>Harian</td> 
                                @elseif($data['user']->skemaGaji==3)
                                <td>50%</td> 
                                @endif 
                            </tr>
                            </tbody>
                        </table>
                        
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        <hr>                       
                        </div>
                        
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                        <div class="alert alert-info" >
                            <h4>Penggajian - Tipe BPJS</h4>
                        </div>
                        
                        <div class="card-body">

                        @php($i_=1)
                        @foreach($permison as $g)     
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
                                        
                                            <input name="variabels[{{ $m['id_variable'] }}]" type="text" class="form-control" id="{{ $m['id_variable'] }}" value="{{ number_format($m['nominal']) }}"readOnly >
                                         
                                        </div>
                                    </div>
                                    @php($i_++)
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        <hr>
                        <div class="row justify-content-end">
                        <h5>Skema Normal : 0 <span class="badge bg-submit">-</span></h5>
                        <h5>Skema Full Perusahaan : 1 <span class="badge bg-submit">-</span></h5>
                        <h5>Tidak Ikut : 2 <span class="badge bg-submit"> </span></h5>
                        </div>
                            <div class="card-body p-0">
                                <div class="thead-dark table-sm table-striped" id="listTable" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke">
                            <div class="row justify-content-end">
                                
                                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                                    <button type="button" class="btn btn-block btn-outline-danger" onclick="window.location = '{{ url('dashboard/penggajian/bpjs') }}'">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </button>
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
<script type="text/javascript">
        let formData = $('#formData');

        function updateVariable(table,cell) {
            let data = cell.getData();
            $.ajax({
                url: '{{ url('dashboard/penggajian/bpjs/updateVariable') }}',
                method: 'post',
                data: {id:data.id, tipePotongan:data.tipePotongan, idPeriode:idPeriode.val()},
                success: function(response) {
                    if (response === 'success') {

                        window.location.reload();
                    } else {
                        console.log(response);
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            })
        }

        let btnEdit = $('#btnEdit');
        let idKaryawan = $('#idKaryawan');
        let idPeriode = $('#idPeriode');

        $(document).ready(function () {
            let listTable = new Tabulator("#listTable", {
                resizableColumns: false,
                layout: "fitDataStretch",
                selectable: 1,
                placeholder: 'No Data Available',
                ajaxURL: "{{ url('dashboard/penggajian/bpjs/data-karyawan') }}/"+idKaryawan.val(),
                ajaxConfig: {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    }
                },
                columns: [
                    {title:"Tipe Potongan",field:"tipePotongan",editor:"input"},
                    {title:"Variable",field:"variable"},
                    {title:"Presentase",field:"presentasi"},
                    {title:"Nominal",field:"nominal"},
                    {title:"Max Value",field:"maxValue"},
                    {title:"Max Value Nominal",field:"maxValueNominal"},
                ],
                cellEdited: function(cell) {
                    updateVariable(listTable,cell);
                }
            });
        });

        formData.submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('dashboard/penggajian/bpjs/submit') }}",
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
                                window.location.reload();
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