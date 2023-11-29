@extends('dashboard.layout')

@section('content')
<div class="section-body">

        <!-- Main Content -->
        <section class="section">
          <!-- Header Dashboard -->
          <div class="card-header">
          <h4>Informasi Karyawan</h4>
          <td>Tanggal ( {{ date('d F Y ') }})</td>
          </div>
          <div class="row">
            <!-- Total Karyawan Aktif -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Karyawan (Active)</h4>
                  </div>
                
                  <div class="card-body">
                   <a href="dashboard-total-karyawan-aktif">{{ $totalKaryawanAktif }} Orang</a>
                  </div>
                 
                </div>
              </div>
            </div>

            <!-- Total Karyawan Non Aktif -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Karyawan (Non Active)</h4>
                  </div>
                 
                  <div class="card-body">
                  <a href="dashboard-total-karyawan-nonAktif">{{ $totalKaryawanNonAktif }} Orang</a>
                  
                  </div>
              
                </div>
              </div>
            </div>
     
          </div>
          <!-- end Dashboard -->
          @if( $periode !='')
             <!-- Header Dashboard -->
             <div class="card-header">
          <h4>Informasi Penggajian Periode : {{ $periode }} </h4>
          </div>
          <div class="row">
            <!-- Total Karyawan -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                  <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Karyawan</h4>
                  </div>
                
                  <div class="card-body">
                   <a href="penggajian-total-karyawan-all-periode">{{ $totalKaryawanPenggajianAktif }} Orang</a>
                  </div>
                 
                </div>
              </div>
            </div>

            <!-- Skema Gaji Normal -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                  <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Skema Gaji Normal</h4>
                  </div>
                 
                  <div class="card-body">
                  <a href="penggajian-total-karyawan-skema-normal">{{ $karyawanGajiNormal }} Orang</a>
                  
                  </div>
              
                </div>
              </div>
            </div>

            <!-- Skema Gaji 50% -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                  <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Skema Gaji 50%</h4>
                  </div>
                 
                  <div class="card-body">
                  <a href="penggajian-total-karyawan-skema-setengah">{{ $karyawanGajiSetengah }} Orang</a>
                  
                  </div>
              
                </div>
              </div>
            </div>

            <!-- Skema Gaji Harian -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                  <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Skema Gaji Harian</h4>
                  </div>
                 
                  <div class="card-body">
                  <a href="penggajian-total-karyawan-skema-harian">{{ $karyawanGajiHarian }} Orang</a>
                  
                  </div>
              
                </div>
              </div>
            </div>

            <!-- Karyawan Tidak Terdaftar -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                  <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Tidak Terdaftar Periode Penggajian</h4>
                  </div>
                 
                  <div class="card-body">
                  <a href="penggajian-total-karyawan-tidakTerdaftar">{{ $karyawanTidakTerdaftarPenggajian }} Orang</a>
                  
                  </div>
              
                </div>
              </div>
            </div>

           
          </div>
          <!-- end Dashboard -->
          @endif     
          
          <!-- Statistic -->
          <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Summary</h4>
                  <div class="card-header-action dropdown" >
                  </div>
                </div>
                <div class="card-body">
                <div class="form-group">
                                 <table id="tableIndex" class="table table-striped table-bordered display nowrap" style="width: 100%">
                                    <thead clas="bg-dark">
                                    <tr>
                                    <th>Payslip</th>
                                    <th>Periode</th>
                                    <th>Total Karyawan</th>
                                    <th>Total Thp</th>             
                                    </tr>
                                    </thead>
                                </table>   
                                <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-end">
                        <div class="col-sm-12 col-lg-3 mt-2 mt-lg-0">
                                <div class="btn-group btn-block mb-3" role="group" aria-label="Basic example">
                                    <button type="button" id="btnDisable" class="btn btn-danger" disabled>
                                        <i class="fas fa-times mr-2"></i>Disable
                                    </button>
                                    <button type="button" id="btnActivate" class="btn btn-success" disabled>
                                        <i class="fas fa-check mr-2"></i>Activate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>           
                </div>
                </div>
              </div>
            </div>
            
            @if( $dataBpjs !='')
            <!-- history acktifitas -->
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
              <div class="card">
             
                <div class="card-body">

                <div class="card mb-3">
                <img src="{{ asset('assets/logo/Header-bpjs.jpg') }}" class="card-img-top" alt="...">
                  <hr>
                  <h5>Periode {{$periodeBpjs}}</h5>
                
                <h6>BPJS dibayarkan Perusahaan</h6>
                <ol class="list-group list-group-numbered">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                          <div class="ms-2 me-auto">
                            <div class="fw-bold">Total BPJS TK</div>
                            {{number_format($dataBpjs->bpjsTkPerusahaan,2)}}
                          </div>
                      
                          <h6>{{$dataBpjs->countBpjsTkPerusahaan}}</h6>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                          <div class="ms-2 me-auto">
                            <div class="fw-bold">Total BPJS JP</div>
                            {{number_format($dataBpjs->bpjsJpPerusahaan,2)}}
                          </div>
                          <h6>{{$dataBpjs->countBpjsJpPerusahaan}}</h6>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                          <div class="ms-2 me-auto">
                            <div class="fw-bold">Total BPJS Kesehatan</div>
                            {{number_format($dataBpjs->bpjsKesehatanPerusahaan,2)}}
                          </div>
                          <h6>{{$dataBpjs->countBpjsKesehatanPerusahaan}}</h6>
                        </li>
                        <li class="alert alert-success"> <h6>Total Bayar : {{number_format($dataBpjs->bpjsTkPerusahaan+$dataBpjs->bpjsJpPerusahaan+$dataBpjs->bpjsKesehatanPerusahaan,2)}}</h6></li>
                       </ol>   
                      <hr>
                       <h6>BPJS dibayarkan Karyawan</h6>
                       <ol class="list-group list-group-numbered">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                          <div class="ms-2 me-auto">
                            <div class="fw-bold">Total BPJS TK</div>
                            {{number_format($dataBpjs->bpjsTkKaryawan,2)}}
                          </div>
                          <h6>{{$dataBpjs->countBpjsTkKaryawan}}</h6>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                          <div class="ms-2 me-auto">
                            <div class="fw-bold">Total BPJS JP</div>
                            {{number_format($dataBpjs->bpjsJpKaryawan,2)}}
                          </div>
                          <h6>{{$dataBpjs->countBpjsJpKaryawan}}</h6>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                          <div class="ms-2 me-auto">
                            <div class="fw-bold">Total BPJS Karyawan</div>
                            {{number_format($dataBpjs->bpjsKesehatanKaryawan,2)}}
                          </div>
                          <h6>{{$dataBpjs->countBpjsKesehatanKaryawan}}</h6>
                        </li>
                        
                        <li class="list-group-item list-group-item-primary bg-success"> <h6>Total Bayar : {{number_format($dataBpjs->bpjsTkKaryawan+$dataBpjs->bpjsJpKaryawan+$dataBpjs->bpjsKesehatanKaryawan,2)}}</h6></li>
                      </ol>   

                </div>
              </div>
              </div>
            </div>
          
          </div>
          <!-- end statistic -->
          @endif     
          
         
        </section>
      </div>

    </div>

@endsection

@section('script')
    <script type="text/javascript">  
      const btnDisable = $('#btnDisable');
      const btnActivate = $('#btnActivate');

        $(document).ready(function () {  
          getDataTable();
        }); 

        
        function getDataTable(){
                let tableIndex = $('#tableIndex').DataTable({
            "bDestroy": true,
            "scrollY": 400,
            "scrollX": true,
            "ajax": {
                "method": "get",
                "url": "{{ url('dashboard/data') }}",
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
                {data: 'keterangan'},
                {data: 'periode'},
                {data: 'totalKaryawan'},
                {data: 'thp',
                    className: "text-right" ,
                    render: $.fn.dataTable.render.number( ',', '.', 2 )},
          
          
            ],
        });
        $('#tableIndex tbody').on( 'click', 'tr', function () {
            let _data = tableIndex.row( this ).data();
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                btnDisable.attr('disabled','true');
                btnActivate.attr('disabled','true');

            } else {
                tableIndex.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                btnDisable.removeAttr('disabled');
                btnActivate.removeAttr('disabled');

                let _data = tableIndex.row('.selected').data();
                selectID = _data.id_periode;
            }
        });  
      }

      btnActivate.click(function (e) {
                e.preventDefault();
                let tables = $('#listTable').DataTable();
                    // Handle form submission event
                    var form = this;
                    Swal.fire({
                    title: "Apakah ingin Aktifkan data ini",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Active'
                    }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('dashboard/payslip') }}',
                            method: 'post',
                            data: {id: selectID,tipe:1},
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
            });


            btnDisable.click(function (e) {
                e.preventDefault();
                let tables = $('#listTable').DataTable();
                    // Handle form submission event
                    var form = this;
                    Swal.fire({
                    title: "Apakah ingin Disable data ini",
                    type: 'danger',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Disable'
                    }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('dashboard/payslip') }}',
                            method: 'post',
                            data: {id: selectID,tipe:0},
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
            });
        
    </script>
  
@endsection
