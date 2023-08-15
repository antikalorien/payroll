@extends('dashboard.layout')


@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Skema Hari Kerja</h4>
                    </div>
                    <form id="formData">
                        <input type="hidden" name="type" value="edit">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="card-body">
                
                            <div class="form-group">
                                <label>ID Skema</label>
                                <input name="idSkema" type="text" class="form-control" value="{{ $data->id_skema }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Skema Hari Kerja</label>
                                <input name="namaSkemaHariKerja" type="text" class="form-control" value="{{ $data->skema }}">
                            </div>
                            <div class="form-group">
                                <label>Jumlah Hari (Periode)</label>
                                <input name="jmlHari" type="text" class="form-control" value="{{ $data->jml_hari }}">
                            </div>
                            <div class="form-group">
                                <label>Jam Kerja</label>
                                <input name="jamKerja" type="text" class="form-control" value="{{ $data->jam_kerja }}">
                            </div>
                            <div class="form-group">
                                <label>Total Jam Mingguan</label>
                                <input name="totJamMingguan" type="text" class="form-control" value="{{ $data->total_jam_mingguan }}">
                            </div>
                            <div class="form-group">
                                <label>Total Jam Bulanan</label>
                                <input name="totJamBulanan" type="text" class="form-control" value="{{ $data->total_jam_bulanan }}">
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

        $(document).ready(function () {
            $('#listTable').DataTable({
                responsive: true
            });

            formData.submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ url('dashboard/master/skema-hari-kerja/submit') }}',
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
                    },
                    error: function (response) {
                        console.log(response);
                    }
                })
            })
        });
    </script>
@endsection
