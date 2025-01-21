@extends('dashboard.layout3')

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="bg-white p-4 rounded shadow">
                <!-- Tabs Navs -->
                <ul class="nav nav-tabs mb-3" id="ex-with-icons" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab-absensi" href="#ex-with-icons-tabs-1" role="tab"
                            aria-controls="ex-with-icons-tabs-1" aria-selected="true">
                            <i class="fas fa-user-clock me-2"></i>Absensi Karyawan
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-lembur" href="#ex-with-icons-tabs-2" role="tab"
                            aria-controls="ex-with-icons-tabs-2" aria-selected="false">
                            <i class="fas fa-chart-line fa-fw me-2"></i>Data Lembur
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-bpjs" href="#ex-with-icons-tabs-3" role="tab"
                            aria-controls="ex-with-icons-tabs-2" aria-selected="false">
                            <i class="fas fa-ambulance fa-fw me-2"></i>BPJS
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-paycheck" href="#ex-with-icons-tabs-4" role="tab"
                            aria-controls="ex-with-icons-tabs-2" aria-selected="false">
                            <i class="fas fa-dollar-sign fa-fw me-2"></i>Pay Check
                        </a>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                        aria-labelledby="tab-absensi">
                        @include('dashboard.penggajian.data-penggajian.absensi')
                    </div>
                    <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="tab-lembur">
                        @include('dashboard.penggajian.data-penggajian.lembur')
                    </div>
                    <div class="tab-pane fade" id="ex-with-icons-tabs-3" role="tabpanel" aria-labelledby="tab-bpjs">
                        @include('dashboard.penggajian.data-penggajian.bpjs')
                    </div>
                    <div class="tab-pane fade" id="ex-with-icons-tabs-4" role="tabpanel" aria-labelledby="tab-paycheck">
                        @include('dashboard.penggajian.data-penggajian.paycheck')
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
    const tabs = document.querySelectorAll('.nav-link');

    // Fungsi untuk memuat skrip berdasarkan tab
    function loadTabScript(tabId) {
        if (tabId === 'tab-absensi') {
            if (typeof loadAbsensi === 'function') {
                loadAbsensi();
            }
        } else if (tabId === 'tab-lembur') {
            if (typeof loadLembur === 'function') {
                loadLembur();
            }
        } else if (tabId === 'tab-bpjs') {
            if (typeof loadBPJS === 'function') {
                loadBPJS();
            }
        } else if (tabId === 'tab-paycheck') {
            if (typeof loadBPJS === 'function') {
                loadPayCheck();
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

            loadTabScript(tab.id);
        });
    });

    loadTabScript('tab-absensi');
});
</script>
@endsection