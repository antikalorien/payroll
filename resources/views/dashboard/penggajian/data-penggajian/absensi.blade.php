<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 pt-4">
    <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
        <select class="form-select p-2 border border-gray-300 rounded-md" aria-label="Default select example">
            <option selected>-- PILIH PERIODE --</option>
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
        </select>

        <button type="button" id="btnSyncronise" class="btn btn-primary ml-3">
            <i class="fas fa-undo mr-2"></i>GET DATA
        </button>
    </div>

    <div class="dropdown ms-auto">
        <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
            ACTION
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" id="iRemoveSelectedCheckbox">Remove Selected Checkbox</a>
            <a class="dropdown-item" id="iRemoveAll">Remove All</a>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table id="tableAbsensi" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th><input type="checkbox" id="allCheckboxAbsensi"></th>
                <th>ID</th>
                <th>ID Periode</th>
                <th>Departemen</th>
                <th>Sub Departemen</th>
                <th>Pos</th>
                <th>Grade</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tipe Kontrak</th>
                <th>Skema</th>
                <th>Total Hari</th>
                <th>Gaji Pokok</th>
                <th>Upah Harian</th>
                <th>Total Masuk</th>
                <th>Ph</th>
                <th>Izin</th>
                <th>Alfa</th>
                <th>Sakit</th>
                <th>Reff</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="checkbox" class="row-checkbox"></td>
                <td>240027</td>
                <td>INPARK REVENUE</td>
                <td>Partnership & Support</td>
                <td>Admin</td>
                <td>LV-006</td>
                <td>837483478</td>
                <td>User Trial</td>
                <td>PKWT</td>
                <td>5-2</td>
                <td>21</td>
                <td>20</td>
                <td>9</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>00-0000-00</td>
                <td>2025-01-11 14:13:00</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
function loadAbsensi() {
    if ($.fn.DataTable.isDataTable('#tableAbsensi')) {
        $('#tableAbsensi').DataTable().destroy();
    }

    $('#tableAbsensi').DataTable({
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

    $('#allCheckboxAbsensi').on('change', function() {
        const checked = $(this).is(':checked');
        $('.rowCheckbox').prop('checked', checked);
    });

    $(document).on('change', '.rowCheckbox', function() {
        if (!$(this).is(':checked')) {
            $('#allCheckboxAbsensi').prop('checked', false);
        }
    });

    addSyncButtonListener();
}

function addSyncButtonListener() {
    const btnSyncronise = document.getElementById('btnSyncronise');
    if (btnSyncronise) {
        btnSyncronise.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Syncronise Absensi",
                text: "Apakah kamu yakin ingin Syncronise Absensi? Data akan otomatis terinput pada tabel absensi",
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

document.addEventListener('DOMContentLoaded', loadAbsensi);
</script>