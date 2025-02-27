<!-- Form Add User Start -->
<div id="formAddUser" class="card border" style="display:none;">
    <div class="card-header">
        <h4>Tambah User Baru</h4>
    </div>
    <form id="formData">
        <div class="modal-body">
            <div class="form-group">
                <label for="dept">Departemen</label>
                <select style="width: 100%" id="iDepartemenUser" name="departemen" required></select>
            </div>

            <div class="form-group">
                <label for="sub-dept">Sub Departemen</label>
                <select style="width: 100%" id="iSubDepartemen" name="subDepartemen" required></select>
            </div>

            <div class="form-group">
                <label>Pos</label>
                <input name="pos" type="text" class="form-control" autofocus>
            </div>

            <div class="form-group">
                <label for="grade">Grade</label>
                <select style="width: 100%" id="iGrade" name="grade" required></select>
            </div>

            <div class="form-group">
                <label>ID Absen (4 digit)</label>
                <input name="idAbsen" type="text" class="form-control" autofocus>

            </div>

            <div class="form-group">
                <label>NIP</label>
                <input name="username" type="text" class="form-control" autofocus>
                <small>Password untuk user baru sama dengan NIP. Setiap user dapat mengganti password melalui menu User
                    Profile.</small>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input name="name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="text" class="form-control">
            </div>

            <label for="skema">Skema Hari Kerja</label>
            <div class="form-group">
                <select style="width: 100%" id="iSkemaHariKerja_1" required></select>
            </div>

            <label for="tgl-gabung">Tanggal Bergabung</label>
            <div class="form-group">
                <input type="text" id="iTanggalBergabung" name="tanggalBergabung" class="form-control">
            </div>

            <label for="tgl-lahir">Tanggal Lahir</label>
            <div class="form-group">
                <input type="text" id="iTanggalLahir" name="tanggalLahir" class="form-control">
            </div>

            <div class="form-group">
                <label for="iSystem">System</label>
                <select class="form-control" id="iSystem" name="system">
                    <option value="1">Karyawan</option>
                    <option value="2">Super User</option>
                </select>
            </div>

        </div>
        <div class="card-footer bg-whitesmoke">
            <div class="row justify-content-end">
                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                    <button type="button" class="btn btn-block btn-outline-danger" onclick="hideFormAddUser()">
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
<!-- Form Add User End -->

<!-- Form Edit User Start -->
<div id="formEditUser" class="card border" style="display:none;">
    <div class="card-header">
        <h4>Edit User</h4>
    </div>
    <form id="formData">
        <div class="modal-body">
            <div class="form-group">
                <label for="dept">Departemen</label>
                <select style="width: 100%" id="iDepartemenUser" name="departemen" required></select>
            </div>

            <div class="form-group">
                <label for="sub-dept">Sub Departemen</label>
                <select style="width: 100%" id="iSubDepartemen" name="subDepartemen" required></select>
            </div>

            <div class="form-group">
                <label>Pos</label>
                <input name="pos" type="text" class="form-control" autofocus>
            </div>

            <div class="form-group">
                <label for="grade">Grade</label>
                <select style="width: 100%" id="iGrade" name="grade" required></select>
            </div>

            <div class="form-group">
                <label>ID Absen (4 digit)</label>
                <input name="idAbsen" type="text" class="form-control" autofocus>

            </div>

            <div class="form-group">
                <label>NIP</label>
                <input name="username" type="text" class="form-control" autofocus>
                <small>Password untuk user baru sama dengan NIP. Setiap user dapat mengganti password melalui menu User
                    Profile.</small>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input name="name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label for="skema">Skema Hari Kerja</label>
                <select style="width: 100%" id="iSkemaHariKerja_1" required></select>
            </div>

            <label for="tgl-gabung">Tanggal Bergabung</label>
            <div class="form-group">
                <input type="text" id="iTanggalBergabung" name="tanggalBergabung" class="form-control">
            </div>

            <label for="tgl-lahir">Tanggal Lahir</label>
            <div class="form-group">
                <input type="text" id="iTanggalLahir" name="tanggalLahir" class="form-control">
            </div>

            <div class="form-group">
                <label for="iSystem">System</label>
                <select class="form-control" id="iSystem" name="system">
                    <option value="1">Karyawan</option>
                    <option value="2">Super User</option>
                </select>
            </div>

        </div>
        <div class="card-footer bg-whitesmoke">
            <div class="row justify-content-end">
                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                    <button type="button" class="btn btn-block btn-outline-danger" onclick="hideFormEditUser()">
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
<!-- Form Edit User End -->

<!-- Form Import User Start -->
<div id="formImportUser" class="card border" style="display:none;">
    <div class="card">
        <div class="card-header">
            <h4>Import User Baru</h4>
        </div>
        <div class="row justify-content-end">
            <div class="card-body pt-0 pb-0">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post" action="/dashboard/master/user-management/import-user"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="file" name="file" class="form-control">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                        <button type="button" class="btn btn-outline-danger" onclick="hideFormImportUser()">
                            <i class=" fas fa-arrow-left mr-2"></i>Kembali
                        </button>
                        <button type="button"
                            onclick="location.href='{{ asset('assets/excel/sample-userManagement.xls') }}'"
                            id="iBtnExportSample" class="btn btn-danger disabled">
                            <i class="fas fa-file-export mr-2"></i>Download Sample
                        </button>
                        <button type="button" id="iBtnExport" class="btn btn-danger ">
                            <i class="fas fa-file-export mr-2"></i>EXPORT
                        </button>
                        <button type="button" id="iResetPasswordAllUser" class="btn btn-warning ">
                            <i class="fas fa-file-export mr-2"></i>RESET PIN All User
                        </button>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Form Import User End -->


<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 pt-4">
    <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
        <button type="button" id="iTambahUser" class="btn btn-primary w-auto mr-3">
            <i class="fas fa-plus mr-2"></i>Tambah
        </button>

        <button type="button" id="iImportUser" class="btn btn-success w-auto">
            <i class="fas fa-plus mr-2"></i>Import
        </button>
    </div>
</div>

<div class="table-responsive">
    <table id="tableUserManagement" class="table table-striped table-bordered display nowrap" style="width: 100%">
        <thead>
            <tr>
                <th><input type="checkbox" id="allCheckboxUser"></th>
                <th>Status</th>
                <th>Departemen</th>
                <th>Sub Departemen</th>
                <th>Pos</th>
                <th>Grade</th>
                <th>ID Absen / Username</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Skema Hari Kerja</th>
                <th>Total hari Kerja</th>
                <th>Jam Kerja</th>
                <th>Tanggal Bergabung</th>
                <th>Masa Kerja</th>
                <th>Tanggal Lahir</th>
                <th>Usia</th>
                <th>System</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td class="sticky-col first-col"><span class="badge bg-success text-dark">
                        Active
                    </span></td>
                <td class="sticky-col second-col">IT</td>
                <td class="sticky-col third-col">Aplikasi & System</td>
                <td>Aplikasi & System</td>
                <td>LV-001</td>
                <td>1708</td>
                <td>8333434</td>
                <td>User Trial</td>
                <td>5-2</td>
                <td>20</td>
                <td>9</td>
                <td>2025-18-01</td>
                <td>5 tahun</td>
                <td>04-04-1999</td>
                <td>25</td>
                <td><span class="badge text-success">
                        Karyawan
                    </span></td>

                <td><button type="button" id="iEditUser" class="btn btn-warning mr-2" title="Edit User">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" id="iEditUser" class="btn btn-success mr-2" title="Activate">
                        <i class="fas fa-check-square"></i>
                    </button>
                    <button type="button" id="iEditUser" class="btn btn-danger mr-2" title="Disable">
                        <i class="fas fa-window-close"></i>
                    </button>
                    <button type="button" id="iEditUser" class="btn btn-warning" title="Reset Password">
                        <i class="fas fa-undo"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
function loadUserManagement() {
    if ($.fn.DataTable.isDataTable('#tableUserManagement')) {
        $('#tableUserManagement').DataTable().destroy();
    }

    $('#tableUserManagement').DataTable({
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

    $('#allCheckboxUser').on('change', function() {
        const checked = $(this).is(':checked');
        $('.rowCheckbox').prop('checked', checked);
    });

    $(document).on('change', '.rowCheckbox', function() {
        if (!$(this).is(':checked')) {
            $('#allCheckboxUser').prop('checked', false);
        }
    });

    $('#iTanggalLahir').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD MMMM YYYY'
        }
    });

    $('#iTanggalBergabung').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD MMMM YYYY'
        }
    });
}


// hide and show form add user
function showFormAddUser() {
    document.getElementById("formAddUser").style.display = "block";
    document.getElementById("formEditUser").style.display = "none";
    document.getElementById("formImportUser").style.display = "none";
}

function hideFormAddUser() {
    document.getElementById("formAddUser").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const addUserButton = document.getElementById("iTambahUser");
    if (addUserButton) {
        addUserButton.addEventListener("click", function() {
            showFormAddUser();
        });
    }
});

// hide and show form add user
function showFormEditUser() {
    document.getElementById("formEditUser").style.display = "block";
    document.getElementById("formAddUser").style.display = "none";
    document.getElementById("formImportUser").style.display = "none";
}

function hideFormEditUser() {
    document.getElementById("formEditUser").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const editUserButton = document.getElementById("iEditUser");
    if (editUserButton) {
        editUserButton.addEventListener("click", function() {
            showFormEditUser();
        });
    }
});

// hide and show form import user
function showFormImportUser() {
    document.getElementById("formImportUser").style.display = "block";
    document.getElementById("formAddUser").style.display = "none";
    document.getElementById("formEditUser").style.display = "none";
}

function hideFormImportUser() {
    document.getElementById("formImportUser").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const importUserButton = document.getElementById("iImportUser");
    if (importUserButton) {
        importUserButton.addEventListener("click", function() {
            showFormImportUser();
        });
    }
});


document.addEventListener('DOMContentLoaded', loadUserManagement);
</script>