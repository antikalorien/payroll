<!-- Form Add Grade Start -->
<div id="formAddGrade" class="card border" style="display:none;">
    <div class="card-header">
        <h4>Tambah Grade Baru</h4>
    </div>
    <form id="formData">
        <div class="modal-body">
            <div class="form-group">
                <label>Level</label>
                <input name="level" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Nominal Tunjangan Transport</label>
                <input name="nominalTnjTransport" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Interval Bulan</label>
                <input name="intervalBulan" type="text" class="form-control">
            </div>
        </div>
        <div class="card-footer bg-whitesmoke">
            <div class="row justify-content-end">
                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                    <button type="button" class="btn btn-block btn-outline-danger" onclick="hideFormAddGrade()">
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
<!-- Form Add Grade End -->

<!-- Form Add Grade Start -->
<div id="formEditGrade" class="card border" style="display:none;">
    <div class="card-header">
        <h4>Edit Grade</h4>
    </div>
    <form id="formData">
        <div class="modal-body">
            <div class="form-group">
                <label>Level</label>
                <input name="level" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Nominal Tunjangan Transport</label>
                <input name="nominalTnjTransport" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Interval Bulan</label>
                <input name="intervalBulan" type="text" class="form-control">
            </div>
        </div>
        <div class="card-footer bg-whitesmoke">
            <div class="row justify-content-end">
                <div class="col-sm-12 col-lg-2 mt-2 mb-lg-0">
                    <button type="button" class="btn btn-block btn-outline-danger" onclick="hideFormEditGrade()">
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
<!-- Form Add Grade End -->

<button type="button" id="iTambahGrade" class="btn btn-block btn-primary mb-3" style="width: 15%">
    <i class="fas fa-plus mr-2"></i>Tambah
</button>


<div class="table-responsive">
    <table id="tableGrade" class="table table-striped table-bordered display nowrap" style="width: 100%">
        <thead>
            <tr>
                <th>Status</th>
                <th>ID</th>
                <th>Level</th>
                <th>Nominal Tunjangan Transport</th>
                <th>Interval Bulan</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="badge bg-success text-dark">
                        Active
                    </span></td>
                <td>LV-001</td>
                <td>General Manager</td>
                <td>10000</td>
                <td>24</td>
                <td>2025-01-11T06:08:31</td>
                <td><button type="button" id="iEditGrade" class="btn btn-warning">
                        <i class="fas fa-edit"></i>
                    </button></td>
            </tr>
        </tbody>
    </table>
</div>

<script>
function loadGrade() {
    if ($.fn.DataTable.isDataTable('#tableGrade')) {
        $('#tableGrade').DataTable().destroy();
    }

    $('#tableGrade').DataTable({
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
    });
}

// hide and show form add grade
function showFormAddGrade() {
    document.getElementById("formAddGrade").style.display = "block";
    document.getElementById("formEditGrade").style.display = "none";
}

function hideFormAddGrade() {
    document.getElementById("formAddGrade").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const addGradeButton = document.getElementById("iTambahGrade");
    if (addGradeButton) {
        addGradeButton.addEventListener("click", function() {
            showFormAddGrade();
        });
    }
});

// hide and show form edit grade
function showFormEditGrade() {
    document.getElementById("formEditGrade").style.display = "block";
    document.getElementById("formAddGrade").style.display = "none";
}

function hideFormEditGrade() {
    document.getElementById("formEditGrade").style.display = "none";
    document.querySelector(".table-responsive").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    const addGradeButton = document.getElementById("iEditGrade");
    if (addGradeButton) {
        addGradeButton.addEventListener("click", function() {
            showFormEditGrade();
        });
    }
});

document.addEventListener('DOMContentLoaded', loadGrade);
</script>