@extends('dashboard.layout')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                  
                    <div class="row justify-content-end">
                    <div class="card-body pt-0 pb-0">
                    <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                            </div>
                            
                            <div class="modal-body">
                                <form method="post" action="/dashboard/penggajian/data-thr/import-thr" enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="file" name="file" class="form-control">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>

                                <button type="button" onclick="location.href='{{ asset('assets/excel/sample-importThr.xls') }}'" id="iBtnExportSample" class="btn btn-danger disabled">
                                        <i class="fas fa-file-export mr-2"></i>Download Sample
                                </button>             
                            </div>
                            
                            <div class="card-footer bg-whitesmoke">
                                <div class="row justify-content-end">
                                    <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                                        <button type="button" class="btn btn-block btn-outline-danger" onclick="window.location = '{{ url()->previous() }}'">
                                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
