<div class="d-flex justify-content-end mb-3 pt-4">
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

<div class="table-responsive">
    <table id="tableBPJS" class="table table-striped table-bordered display nowrap" style="width: 100%">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="selectAllCheckbox" />
                </th>
                <th>Departemen</th>
                <th>Sub Departemen</th>
                <th>Pos</th>
                <th>Grade</th>
                <th>ID Absen / Username</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Skema BPJS</th>
                <th>BPJS TK</th>
                <th>BPJS JP</th>
                <th>BPJS Kesehatan</th>
                <th>BPJS TK-Perusahaan</th>
                <th>BPJS JP-Perusahaan</th>
                <th>BPJS Kesehatan-Perusahaan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Total</th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsTk" type="text"
                        name="totalBpjsTk" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsJp" type="text"
                        name="totalBpjsJp" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsKesehatan"
                        type="text" name="totalBpjsKes" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsTkPerusahaan"
                        type="text" name="totBpjsTkPerusahaan" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsJpPerusahaan"
                        type="text" name="totBpjsJpPerusahaan" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotalBpjsKesPerusahaan"
                        type="text" name="totBpjsKesPerusahaan" readonly></th>
            </tr>
        </tfoot>
        <tbody>
            <td></td>
            <td>IT</td>
            <td>Aplikasi & System</td>
            <td>Aplikasi & System</td>
            <td>Grade</td>
            <td>1708</td>
            <td>82933</td>
            <td>User Trial</td>
            <td><span class="badge bg-success text-dark">
                    Normal
                </span>
            </td>
            <td>24000</td>
            <td>12000</td>
            <td>12000</td>
            <td>12000</td>
            <td>12000</td>
            <td>12000</td>
            <td><button type="button" id="iEditLembur" class="btn btn-warning">
                    <i class="fas fa-edit"></i>
                </button></td>
        </tbody>
    </table>
</div>

<script>
function loadBPJS() {
    if ($.fn.DataTable.isDataTable('#tableBPJS')) {
        $('#tableBPJS').DataTable().destroy();
    }

    $('#tableBPJS').DataTable({
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

    $('#selectAllCheckbox').on('change', function() {
        const checked = $(this).is(':checked');
        $('.rowCheckbox').prop('checked', checked);
    });

    $(document).on('change', '.rowCheckbox', function() {
        if (!$(this).is(':checked')) {
            $('#selectAllCheckbox').prop('checked', false);
        }
    });
}

document.addEventListener('DOMContentLoaded', loadBPJS);
</script>