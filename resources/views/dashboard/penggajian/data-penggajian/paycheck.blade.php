<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 pt-4">
    <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
        <select class="form-select p-2 border border-gray-300 rounded-md" aria-label="Default select example">
            <option selected>-- PILIH PERIODE --</option>
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
        </select>
        <button type="button" id="btnCheckThp" class="btn btn-block btn-warning ml-3">
            <i class="fas fa-undo mr-2"></i>Cek THP
        </button>
    </div>
    <div class="dropdown">
        <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
            Action Export
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" id="iExportSelected">Export Selected (.pdf)</a>
            <a class="dropdown-item" id="iExportSelectedCheckBox">Export CheckBox(.pdf)</a>
            <a class="dropdown-item" id="iExportAll">Export All (.xls)</a>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table id="tablePayCheck" class="table table-striped table-bordered display nowrap" style="width: 100%">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="allCheckboxPay" />
                </th>
                <th>Status Check</th>
                <th>Departemen</th>
                <th>Sub Departemen</th>
                <th>Pos</th>
                <th>Grade</th>
                <th>ID Absen / Username</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tipe Kontrak</th>
                <th>Tanggal Bergabung</th>
                <th>Masa Kerja</th>
                <th>No Rekening</th>
                <th>Skema BPJS</th>
                <th>Take Home Pay (THP)</th>
                <th>Updated At</th>
                <th>Gaji Pokok</th>
                <th>Jabatan</th>
                <th>Keahlian</th>
                <th>Transport</th>
                <th>Komunikasi</th>
                <th>Lembur</th>
                <th>Tambahan Lainnya</th>
                <th>Alfa</th>
                <th>Ijin</th>
                <th>Potongan Lainnya</th>
                <th>BPJS-Kesehatan</th>
                <th>BPJS-TK</th>
                <th>BPJS-JP</th>

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
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Total</th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotThp" type="text"
                        name="totThp" readonly></th>
                <th></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotGajiPokok" type="text"
                        name="totGajiPokok" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotJabatan" type="text"
                        name="totJabatan" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotKeahlian" type="text"
                        name="totKeahlian" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotTransport" type="text"
                        name="totTransport" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotKomunikasi" type="text"
                        name="totKomunikasi" readonly></th>

                <th><input style="text-align: right;width:150px" class="form-control" id="iLembur" type="text"
                        name="totLembur" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTambahanLainnya" type="text"
                        name="totTambahanLainnya" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iAlfa" type="text" name="alfa"
                        readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iIjin" type="text"
                        name="iIjin" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iPotonganLainnya" type="text"
                        name="totPotonganLainnya" readonly></th>

                <th><input style="text-align: right;width:150px" class="form-control" id="iTotBpjsKes" type="text"
                        name="totBpjsKes" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotBpjsTk" type="text"
                        name="totBpjsTk" readonly></th>
                <th><input style="text-align: right;width:150px" class="form-control" id="iTotBpjsJp" type="text"
                        name="totBpjsJp" readonly></th>

            </tr>
        </tfoot>
        <tbody>
            <td></td>
            <td><span class="badge bg-success text-dark">
                    Check
                </span></td>
            <td>IT</td>
            <td>Aplikasi & System</td>
            <td>Aplikasi & System</td>
            <td>LV-005</td>
            <td>1708</td>
            <td> 82933</td>
            <td>User Trial</td>
            <td>PKWT
            </td>
            <td> 2025-01-11</td>
            <td>0</td>
            <td>335353535</td>
            <td><span class="badge bg-success text-dark">
                    Normal
                </span></td>
            <td>1,176,277.46</td>
            <td>2025-01-18 10:56:37</td>
            <td>1000000</td>
            <td>200000</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>24000</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>12000</td>
            <td>24000</td>
            <td>12000</td>
        </tbody>
    </table>
</div>

<script>
function loadPayCheck() {
    if ($.fn.DataTable.isDataTable('#tablePayCheck')) {
        $('#tablePayCheck').DataTable().destroy();
    }

    $('#tablePayCheck').DataTable({
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

    $('#allCheckboxPay').on('change', function() {
        const checked = $(this).is(':checked');
        $('.rowCheckbox').prop('checked', checked);
    });

    $(document).on('change', '.rowCheckbox', function() {
        if (!$(this).is(':checked')) {
            $('#allCheckboxPay').prop('checked', false);
        }
    });
}

document.addEventListener('DOMContentLoaded', loadPayCheck);
</script>