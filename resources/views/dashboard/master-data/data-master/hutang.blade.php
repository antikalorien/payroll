<div class="table-responsive">
    <table id="tableHutang" class="table table-striped table-bordered display nowrap" style="width: 100%">
        <thead>
            <tr>
                <th>Nominal</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>10000000</td>
                <td>1 Bulan</td>

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
    });
}

document.addEventListener('DOMContentLoaded', loadHutang);
</script>