@extends('dashboard.layout')


@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    @if($periode !=null)
                    <!--  -->
                    <div class="card-group">

                    @foreach($data as $x)
                    @foreach($x as $v)
                    <div class="card">
                        @if($v->status==0)
                        <img src="{{asset($v->filename1)}}" class="card-img-top" alt="Card image cap">
                        @else
                        <img src="{{asset($v->filename2)}}" class="card-img-top" alt="Card image cap">
                        @endif     
                            <div class="card-body">
                            <h5 class="card-title">{{$v->statusGaji}}</h5>
                            <p class="card-text">{{$v->keterangan}}</p>
                            </div>
                            <div class="card-footer">

                            <button type="button" class="btn btn-block btn-outline-primary" onclick="window.location = '{{ url($v->url) }}'">
                           
                                        <i class="fas fa-arrow-right mr-2"></i>Go Module
                            </button>
                             <p class="card-text"><small class="text-muted">Last updated {{$v->updatedAt}}</small></p>
                             <p class="card-text">PIC : {{$v->reff}}</p>
                            </div>
                    </div>
                    @endforeach
                    @endforeach
                    </div>
                    <!--  -->
             

                    <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Periode Gaji : {{$periode->periode}}</h5>
                        <p class="card-text">Silahkan Lengkapi Data Penggajian per-Modul yang tersedia secara bertahap. *Isikan data dengan hati-hati</p>
                        <a href="#" class="btn btn-primary">Total Karyawan : {{$periode->totalKaryawan}}</a>
                    </div>
                    </div>
       
                    </div>
                    </div>
                    @else
                    <div class="row justify-content-end">
                    <div class="card-body pt-0 pb-0">
                    <div class="card text-center" style="width: 100%;">
                            <div class="card-body">
                                <h5 class="card-title">Generate Periode Penggajian</h5>
                                <p class="card-text">---digunakan untuk memilih periode penggajian---</p>

                                <select style="width: 30%" id="iPeriode" name="periode" required></select>
                                <button type="button"  id="btnGenerate" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Generate Data</button>
                            </div>
                    </div>
                    </div>
                    </div>
                    @endif
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
        const btnGenerate = $('#btnGenerate');
        let iPeriode = $('#iPeriode');

        $(document).ready(function () {
               
            iPeriode.select2({
                ajax: {
                    url: '{{ url("listPeriodeJadwal") }}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            search: params.term,
                        }
                    }
                }
            });

            iPeriode.change(function(){
                var value = $(this).val();
              
                dataID = value;
                btnGenerate.removeAttr('disabled');
                
                selectedOption = $('#iPeriode').find(':selected').text();
                
            });
            
            });


            btnGenerate.click(function (e) {
                e.preventDefault();
                    Swal.fire({
                    title: "Apakah ingin Generate Periode "+selectedOption+" ?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Generate',
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
                            url: '{{ url('dashboard/penggajian/generate-gaji/submit') }}',
                            method: 'post',
                            data: {idPeriode: dataID},
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
