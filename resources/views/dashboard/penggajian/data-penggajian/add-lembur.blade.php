@section('script')
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const tabs = document.querySelectorAll('.nav-link');
    const contentDiv = document.getElementById('tab-content');
    let lastActiveTab = 'tab-absensi';

    // Fungsi untuk memuat konten berdasarkan tab
    async function loadTabContent(tabId, url) {
        contentDiv.innerHTML = '<div class="loading">Loading...</div>';
        try {
            const response = await fetch(url);
            const html = await response.text();
            contentDiv.innerHTML = html;

            initializeDataTable(tabId); // Inisialisasi DataTable setelah konten dimuat
            // Tambahkan event listener untuk tombol Sync Absensi di sini
            addSyncButtonListener();
        } catch (error) {
            contentDiv.innerHTML = '<div class="error">Error loading content.</div>';
        }
    }

    // Fungsi untuk menginisialisasi DataTables
    function initializeDataTable(tabId) {
        const tableId = tabId === 'tab-absensi' ? '#tableAbsensi' : '#tableLembur';
        const table = $(tableId);
        if ($.fn.DataTable.isDataTable(table)) {
            table.DataTable().destroy();
        }
        table.DataTable({
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
                    previous: "Previous",
                },
            },
            scrollY: '400px',
            scrollCollapse: true,
            fixedHeader: true,
            responsive: true,
            scrollX: true,
        });
    }

    // Fungsi untuk menambahkan event listener pada tombol 'Sync Absensi'
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
                        // Lakukan sinkronisasi data di sini
                    }
                });
            });
        }
    }

    // Load konten default (tab absensi)
    await loadTabContent('tab-absensi', '/dashboard/penggajian/data-penggajian/absensi/list');

    // Event listener untuk tab klik
    tabs.forEach((tab) => {
        tab.addEventListener('click', async (event) => {
            event.preventDefault();
            const tabId = tab.id;

            if (lastActiveTab !== tabId) {
                tabs.forEach((t) => t.classList.remove('active'));
                tab.classList.add('active');

                const url =
                    tabId === 'tab-absensi' ?
                    '/dashboard/penggajian/data-penggajian/absensi/list' :
                    '/dashboard/penggajian/data-penggajian/lembur/list';

                await loadTabContent(tabId, url);
                lastActiveTab = tabId;
            }
        });
    });
});
</script>
@endsection