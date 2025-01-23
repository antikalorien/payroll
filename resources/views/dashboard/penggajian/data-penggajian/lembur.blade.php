<!-- Form Add Lembur Start -->
<div id="overtimeForm" class="card border" style="display:none;">
    <div class="card-header">
        <h4>Tambah Data Lembur</h4>
    </div>
    <form id="formData">
        <div class="modal-body">
            <div class="form-group">
                <label for="provi">Nama Karyawan</label>
                <select style="width: 100   %" id="iNamaKaryawan" name="idKaryawan" required></select>
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
                    <button type="button" class="btn btn-block btn-outline-danger" onclick="hideOvertimeForm()">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </button>
                </div>
                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                    <button type="submit" class="btn btn-block btn-success"><i
                            class="fas fa-check mr-2"></i>Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Form Add Lembur End -->

<!-- Form Edit Lembur Start -->
<div id="formEditLembur" class="card border" style="display:none;">
    <div class="card-header">
        <h4>Edit Data Lembur</h4>
    </div>
    <form id="formData">
        <div class="modal-body">
            <div class="form-group">
                <label for="provi">Nama Karyawan</label>
                <select style="width: 100%" id="iEditNamaKaryawanLembur" name="idKaryawan" required></select>
            </div>

            <div class="form-group">
                <label for="iTglLahir">Tanggal Lembur</label>
                <input type="text" id="iEditTanggalLembur" name="tglLembur" class="form-control">
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
                    <button type="button" class="btn btn-block btn-outline-danger" onclick="hideFormEditLembur()()">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </button>
                </div>
                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                    <button type="submit" class="btn btn-block btn-success"><i
                            class="fas fa-check mr-2"></i>Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Form Edit Lembur End -->

<!-- Form Import Lembur Start -->
<div id="importLembur" class="card" style="display:none;">
    <div class="card-header mb-3">
        <h4>Import Data</h4>
    </div>
    <div class="card-body pt-0 pb-0">
        <div class="modal-content">

            <div class="modal-body">
                <form method="post" action="#" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="file" name="file" class="form-control">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>

                <button type="button" onclick="location.href='{{ asset('assets/excel/sample-importLembur.xls') }}'"
                    id="iBtnExportSample" class="btn btn-danger disabled">
                    <i class="fas fa-file-export mr-2"></i>Download Sample
                </button>


            </div>

            <div class="card-footer bg-whitesmoke">
                <div class="row justify-content-end">
                    <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                        <button type="button" class="btn btn-block btn-outline-danger" onclick="hideImportForm()">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Form Import Lembur End -->

<!-- Button Start -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 pt-4">
    <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
        <select class="form-select p-2 border border-gray-300 rounded-md" aria-label="Default select example">
            <option selected>-- PILIH PERIODE --</option>
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
        </select>

        <div class="dropdown ms-auto ml-3">
            <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                ACTION
            </button>
            <div class="dropdown-menu">
                <!-- Button dalam dropdown -->


                <a class="dropdown-item" id="iTambahLembur" href="javascript:void(0)">Add Lembur</a>
                <a class="dropdown-item" id="iGetFromLokaryawan">Get From Lokaryawan</a>
                <a class="dropdown-item" id="iImportExcel">Import Excel</a>
                <hr>
                <a class="dropdown-item" id="iRemoveSelectedCheckbox">Remove Selected Checkbox</a>
            </div>
        </div>
    </div>
    <div class="dropdown">
        <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
            Action Export
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" id="iExportSelectedCheckBox">Export Selected Checkbox</a>
            <a class="dropdown-item" id="iExportAll">Export All</a>
        </div>
    </div>
</div>
<!-- Button End -->


<div class="table-responsive">
    <table id="tableLembur" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th><input type="checkbox" id="allCheckboxLembur"></th>
                <th>ID</th>
                <th>Departemen</th>
                <th>Sub Departemen</th>
                <th>Pos</th>
                <th>Grade</th>
                <th>ID Absen/Username</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tipe Kontrak</th>
                <th>Tanggal</th>
                <th>Jam Lembur</th>
                <th>Total Upah</th>
                <th>Total Jam</th>
                <th>Nominal</th>
                <th>Keterangan</th>
                <th>PIC</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="checkbox" class="row-checkbox"></td>
                <td>1</td>
                <td>HR</td>
                <td>Recruitment</td>
                <td>Manager</td>
                <td>LV-001</td>
                <td>john.doe</td>
                <td>00888787</td>
                <td>John Doe</td>
                <td>PKWT</td>
                <td>2025-01-15</td>
                <td>3</td>
                <td>3000000</td>
                <td>8</td>
                <td>50000</td>
                <td>Regular Shift</td>
                <td>HR</td>
                <td>2025-01-15</td>
                <td><button type="button" id="iEditLembur" class="btn btn-warning">
                        <i class="fas fa-edit"></i>
                    </button></td>
            </tr>
        </tbody>
    </table>
    <div class="d-flex align-items-center mt-4">
        <b style="text-align: center; margin-right: 10px;">Total :</b>
        <input style="text-align: right; width: 350px;" class="form-control" id="iNominal" type="text" name="nominal"
            readonly>
    </div>
</div>


<script>
function loadLembur() {
    console.log('Skrip Lembur dijalankan');
    if ($.fn.DataTable.isDataTable('#tableAbsensi')) {
        $('#tableLembur').DataTable().destroy();
    }

    $('#tableLembur').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "Next",
                previous: "Previous"
            },
        },
        scrollY: '400px',
        scrollCollapse: true,
        fixedHeader: true,
        responsive: true,
        scrollX: true,
        columnDefs: [{
            targets: 0,
            orderable: false,
            className: 'dt-body-center',
            render: function(data, type, row) {
                return `<input type="checkbox" class="rowCheckbox" />`;
            }
        }]
    });
    addSyncButtonLembur();

    $('#allCheckboxLembur').on('change', function() {
        const checked = $(this).is(':checked');
        $('.rowCheckbox').prop('checked', checked);
    });

    $(document).on('change', '.rowCheckbox', function() {
        if (!$(this).is(':checked')) {
            $('#allCheckboxLembur').prop('checked', false);
        }
    });

    $('#iNamaKaryawan').select2({
        ajax: {
            url: '{{ url("namaKaryawanPeriode") }}',
            dataType: 'json',
            data: function(params) {
                return {
                    search: params.term
                };
            }
        }
    });

    $('#iTanggalLembur').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD MMMM YYYY'
        }
    });

    $('#iEditNamaKaryawanLembur').select2({
        ajax: {
            url: '{{ url("namaKaryawanPeriode") }}',
            dataType: 'json',
            data: function(params) {
                return {
                    search: params.term
                };
            }
        }
    });

    $('#iEditTanggalLembur').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD MMMM YYYY'
        }
    });
}

// hide and show form tambah lembur
function showOvertimeForm() {
    document.getElementById("overtimeForm").style.display = "block";
    document.getElementById("importLembur").style.display = "none";
    document.getElementById("formEditLembur").style.display = "none";
}

function hideOvertimeForm() {
    document.getElementById("overtimeForm").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const addLemburButton = document.getElementById("iTambahLembur");
    if (addLemburButton) {
        addLemburButton.addEventListener("click", function() {
            showOvertimeForm();
        });
    }
});


// hide and show form edit lembur
function showFormEditLembur() {
    document.getElementById("formEditLembur").style.display = "block";
    document.getElementById("overtimeForm").style.display = "none";
    document.getElementById("importLembur").style.display = "none";
}

function hideFormEditLembur() {
    document.getElementById("formEditLembur").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const editLemburButton = document.getElementById("iEditLembur");
    if (editLemburButton) {
        editLemburButton.addEventListener("click", function() {
            showFormEditLembur();
        });
    }
});

// hide and show form import lembur
function showImportForm() {
    document.getElementById("importLembur").style.display = "block";
    document.getElementById("overtimeForm").style.display = "none";
    document.getElementById("formEditLembur").style.display = "none";

}

function hideImportForm() {
    document.getElementById("importLembur").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const addImportLembur = document.getElementById("iImportExcel");
    if (addImportLembur) {
        addImportLembur.addEventListener("click", function() {
            showImportForm();
        });
    }

});

// Sync Lembur from lokaryawan
function addSyncButtonLembur() {
    const btnSyncronise = document.getElementById('iGetFromLokaryawan');
    if (btnSyncronise) {
        btnSyncronise.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Syncronise Data Lokaryawan",
                text: "Apakah kamu yakin ingin Syncronise Data? Data dari lokaryawan akan otomatis terinput pada tabel lembur",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#cbd5e1",
                confirmButtonText: "Generate",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('Synchronization Confirmed');
                }
            });
        });
    } else {
        console.error("Tombol Synchronise tidak ditemukan!");
    }
}
</script>