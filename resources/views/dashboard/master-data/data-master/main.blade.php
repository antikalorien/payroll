@extends('dashboard.layout3')

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="bg-white p-4 rounded shadow">
                <!-- Tabs Navs -->
                <ul class="nav nav-tabs nav-fill mb-3" id="ex-with-icons" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab-grade" href="#master-tab-1" role="tab"
                            aria-controls="master-tab-1" aria-selected="true">
                            <i class="fas fa-chart-line fa-fw me-2" style="font-size: 1rem;"></i>Grade
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-user-manajemen" href="#master-tab-2" role="tab"
                            aria-controls="master-tab-2" aria-selected="false">
                            <i class="fas fa-user-alt fa-fw me-2"></i>User Management
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-upah-karyawan" href="#master-tab-3" role="tab"
                            aria-controls="master-tab-3" aria-selected="false">
                            <i class="fas fa-file-invoice-dollar fa-fw me-2" style="font-size: 1rem;"></i>Upah Karyawan
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-hutang" href="#master-tab-4" role="tab" aria-controls="master-tab-4"
                            aria-selected="false">
                            <i class="fas fa-file-invoice-dollar fa-fw me-2" style="font-size: 1rem;"></i>Hutang
                        </a>
                    </li>
                </ul>


                <!-- Tabs Content -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="master-tab-1" role="tabpanel"
                        aria-labelledby="tab-grade">
                        @include('dashboard.master-data.data-master.grade')
                    </div>
                    <div class="tab-pane fade" id="master-tab-2" role="tabpanel" aria-labelledby="tab-user-manajemen">
                        @include('dashboard.master-data.data-master.user-management')
                    </div>
                    <div class="tab-pane fade" id="master-tab-3" role="tabpanel" aria-labelledby="tab-upah-karyawan">
                        @include('dashboard.master-data.data-master.upah')
                    </div>
                    <div class="tab-pane fade" id="master-tab-4" role="tabpanel" aria-labelledby="tab-hutang">
                        @include('dashboard.master-data.data-master.hutang')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.nav-tabs .nav-link');

    // Fungsi untuk memuat skrip berdasarkan tab
    function loadTabScriptMaster(tabId) {
        if (tabId === 'tab-grade') {
            if (typeof loadGrade === 'function') {
                loadGrade();
            }
        } else if (tabId === 'tab-user-manajemen') {
            if (typeof loadUserManagement === 'function') {
                loadUserManagement();
            }
        } else if (tabId === 'tab-upah-karyawan') {
            if (typeof loadUpah === 'function') {
                loadUpah();
            }
        } else if (tabId === 'tab-hutang') {
            if (typeof loadHutang === 'function') {
                loadHutang();
            }
        }
    }

    // Event listener untuk tab
    tabs.forEach((tab) => {
        tab.addEventListener('click', function(event) {
            event.preventDefault();

            tabs.forEach((t) => t.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach((pane) => pane.classList.remove(
                'show', 'active'));

            tab.classList.add('active');
            const targetId = tab.getAttribute('href').substring(1);
            document.getElementById(targetId).classList.add('show', 'active');

            loadTabScriptMaster(tab.id);
        });
    });

    loadTabScriptMaster('tab-grade');
});
</script>
@endsection