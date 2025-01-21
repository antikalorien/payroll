<!-- Form Import Upah Start -->
<div id="formImportUpah" class="card border" style="display:none;">
    <div class="modal-content">
        <div class="card-header">
            <h4>Import Data</h4>
        </div>

        <div class="modal-body">
            <form method="post" action="/dashboard/master-data/upah-karyawan/import-user" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3">
                    <input type="file" name="file" class="form-control">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
            <button type="button" class="btn btn-outline-danger" onclick="hideImportUpah()">
                <i class=" fas fa-arrow-left mr-2"></i>Kembali
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-block btn-danger" class="fas fa-file-export mr-2"><i
                        class="fas fa-file-export mr-2"></i>Export</button>
                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" id="iBtnExportUpah">(1) Data Upah</a>
                    <a class="dropdown-item" id="iBtnExport">(2) Data User</a>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Form Import Upah End -->

<!-- Form Import Upah Start -->
<div id="formEditUpah" class="card border" style="display:none;">
    <div class="card-header">
        <h4>Edit Upah Karyawan</h4>
    </div>
    <form id="formData">
        <div class="modal-body">
            <div class="form-group">
                <label>No Rekening</label>
                <input name="nominalTnjTransport" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Gaji Pokok</label>
                <input name="intervalBulan" type="text" class="form-control">
            </div>
        </div>
        <div class="card-footer bg-whitesmoke">
            <div class="row justify-content-end">
                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                    <button type="button" class="btn btn-block btn-outline-danger" onclick="hideEditUpah()">
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
<!-- Form Import Upah End -->

<button type="button" id="iImportUpah" class="btn btn-success w-auto mb-3">
    <i class="fas fa-plus mr-2"></i>Import
</button>


<div class="table-responsive">
    <table id="tableUpah" class="table table-striped table-bordered display nowrap" style="width: 100%">
        <thead>
            <tr>
                <th><input type="checkbox" id="allCheckboxUpah"></th>
                <th>Status Karyawan</th>
                <th>Departemen</th>
                <th>Sub Departemen</th>
                <th>Pos</th>
                <th>Grade</th>
                <th>ID Absen / Username</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tipe Kontrak</th>
                <th>DOJ</th>
                <th>Masa Kerja</th>
                <th>No Rekening</th>
                <th>Skema BPJS</th>
                <th>Tipe Penggajian</th>
                <th>Updated At</th>
                <th>Gaji Pokok</th>
                <th>Jabatan</th>
                <th>Keahlian</th>
                <th>Transport</th>
                <th>Komunikasi</th>
                <th>Tambahan Lainnya</th>
                <th>BPJS-Kesehatan</th>
                <th>BPJS-TK</th>
                <th>BPJS-JP</th>
                <th>Action</th>
                <!-- <th>Simpanan Koperasi</th>
                                <th>Hutang Karyawan</th> -->
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td><span class="badge bg-success text-dark">
                        Active
                    </span></td>
                <td>IT</td>
                <td>Aplikasi</td>
                <td>Aplikasi</td>
                <td>LV-001</td>
                <td>1708</td>
                <td>87834</td>
                <td>User Trial</td>
                <td>PKWT</td>
                <td>2025-01-11</td>
                <td>0</td>
                <td>837483473847</td>
                <td><span class="badge text-success">
                        Normal
                    </span></td>
                <td><span class="badge text-success">
                        Normal
                    </span></td>
                <td>2025-01-11 13:31:42</td>
                <td>1,000,000.00</td>
                <td>200000</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>12000</td>
                <td>24000</td>
                <td>24000</td>
                <td><button type="button" id="iEditUpah" class="btn btn-warning">
                        <i class="fas fa-edit"></i>
                    </button></td>
            </tr>
        </tbody>
    </table>
</div>

<script>
function loadUpah() {
    if ($.fn.DataTable.isDataTable('#tableUpah')) {
        $('#tableUpah').DataTable().destroy();
    }

    $('#tableUpah').DataTable({
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

    $('#allCheckboxUpah').on('change', function() {
        const checked = $(this).is(':checked');
        $('.rowCheckbox').prop('checked', checked);
    });

    $(document).on('change', '.rowCheckbox', function() {
        if (!$(this).is(':checked')) {
            $('#allCheckboxUpah').prop('checked', false);
        }
    });
}

// hide and show form import upah
function showImportUpah() {
    document.getElementById("formImportUpah").style.display = "block";
}

function hideImportUpah() {
    document.getElementById("formImportUpah").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const importButton = document.getElementById("iImportUpah");
    if (importButton) {
        importButton.addEventListener("click", function() {
            showImportUpah();
        });
    }
});

// hide and show edit upah
function showEditUpah() {
    document.getElementById("formEditUpah").style.display = "block";
}

function hideEditUpah() {
    document.getElementById("formEditUpah").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const editButton = document.getElementById("iEditUpah");
    if (editButton) {
        editButton.addEventListener("click", function() {
            showEditUpah();
        });
    }
});

document.addEventListener('DOMContentLoaded', loadUpah);
</script>