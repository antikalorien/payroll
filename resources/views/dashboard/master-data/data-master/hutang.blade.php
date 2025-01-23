<!-- Form Add Hutang Start -->
<div id="formAddHutang" class="card border" style="display:none;">
    <div class="card-header">
        <h4>Tambah Data Hutang</h4>
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
                <label for="provi">Nama Karyawan</label>
                <select style="width: 100%" id="iNamaKaryawan" name="idKaryawan" required></select>
            </div>
            <div class="form-group">
                <label>Nominal</label>
                <input name="nominal" type="text" class="form-control" autofocus>
            </div>
            <div class="form-group">
                <label>Tenor</label>
                <input name="tenor" type="text" class="form-control" autofocus>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Keterangan</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" style="height: 150px;"></textarea>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke">
            <div class="row justify-content-end">
                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                    <button type="button" class="btn btn-block btn-outline-danger" onclick="hideFormAddHutang()">
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
<!-- Form Add Hutang End -->

<!-- Form Edit Hutang Start -->
<div id="formEditHutang" class="card border" style="display:none;">
    <div class="card-header">
        <h4>Edit Data Hutang</h4>
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
                <label for="nama">Nama</label>
                <select style="width: 100%" id="iNamaKaryawan" name="idKaryawan" required></select>
            </div>
            <div class="form-group">
                <label>Nominal</label>
                <input name="nominal" type="text" class="form-control" autofocus>
            </div>
            <div class="form-group">
                <label>Tenor</label>
                <input name="tenor" type="text" class="form-control" autofocus>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Keterangan</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" style="height: 150px;"></textarea>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke">
            <div class="row justify-content-end">
                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                    <button type="button" class="btn btn-block btn-outline-danger" onclick="hideFormEditHutang()">
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
<!-- Form Edit Hutang End -->


<button type="button" id="iTambahHutang" class="btn btn-primary w-auto mb-3">
    <i class="fas fa-plus mr-3"></i>Tambah
</button>

<div class="table-responsive">
    <table id="tableHutang" class="table table-striped table-bordered display nowrap" style="width: 100%">
        <thead>
            <tr>
                <th><input type="checkbox" id="allCheckboxHutang"></th>
                <th>Departemen</th>
                <th>Sub Departemen</th>
                <th>Pos</th>
                <th>Grade</th>
                <th>ID Absen / Username</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Nominal Hutang</th>
                <th>Tenor</th>
                <th>Keterangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>IT</td>
                <td>Aplikasi & System</td>
                <td>Aplikasi & System</td>
                <td>LV-005</td>
                <td>1708</td>
                <td>834834884</td>
                <td>User Trial</td>
                <td>1000000</td>
                <td>1 Bulan</td>
                <td>ket</td>
                <td><button type="button" id="iEditHutang" class="btn btn-warning mr-2" title="Edit User">
                        <i class="fas fa-edit"></i>
                    </button></td>
            </tr>
        </tbody>
    </table>
</div>

<script>
function loadHutang() {
    if ($.fn.DataTable.isDataTable('#tableHutang')) {
        $('#tableHutang').DataTable().destroy();
    }

    $('#tableHutang').DataTable({
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
    $('#allCheckboxHutang').on('change', function() {
        const checked = $(this).is(':checked');
        $('.rowCheckbox').prop('checked', checked);
    });

    $(document).on('change', '.rowCheckbox', function() {
        if (!$(this).is(':checked')) {
            $('#allCheckboxHutang').prop('checked', false);
        }
    });

}


// hide and show form add hutang
function showFormAddHutang() {
    document.getElementById("formAddHutang").style.display = "block";
    document.getElementById("formEditHutang").style.display = "none";
}

function hideFormAddHutang() {
    document.getElementById("formAddHutang").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const addHutangButton = document.getElementById("iTambahHutang");
    if (addHutangButton) {
        addHutangButton.addEventListener("click", function() {
            showFormAddHutang();
        });
    }
});

// hide and show form edit hutang
function showFormEditHutang() {
    document.getElementById("formEditHutang").style.display = "block";
    document.getElementById("formAddHutang").style.display = "none";
}

function hideFormEditHutang() {
    document.getElementById("formEditHutang").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const editHutangButton = document.getElementById("iEditHutang");
    if (editHutangButton) {
        editHutangButton.addEventListener("click", function() {
            showFormEditHutang();
        });
    }
});

document.addEventListener('DOMContentLoaded', loadHutang);
</script>