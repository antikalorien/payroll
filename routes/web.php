<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostGuzzleController;

$routes = [
    [
        'method' => 'get',
        'url' => 'login',
        'act' => 'c_Login@index'
    ],
];

foreach ($routes as $route) {
    if ($route['method'] == 'get') {
        Route::get($route['url'], $route['act'])->middleware();
    }
}

//Route::get('login','c_Login@index');
Route::post('login/submit', 'c_Login@submit');
Route::post('logout', 'c_Login@logout');
Route::get('reset-password', 'c_Login@resetPassword');

Route::post('reset-password-allUser', 'c_MasterUserManagement@resetPasswordAllUser');

Route::post('reset-password/submit', 'c_Login@resetPasswordSubmit');

// addtitional
Route::get('list_departemen', 'c_Dashboard@listDepartemen');
Route::get('list_periode', 'c_Dashboard@listPeriode');
Route::get('list_periode_success', 'c_Dashboard@listPeriodeSuccess');
Route::get('list_subDepartemen/{id}', 'c_Dashboard@listSubDepartemen');
Route::get('list_grade','c_Dashboard@listGrade');
Route::get('skema_hariKerja', 'c_Dashboard@skemaHariKerja');

Route::middleware(['check.login'])->group(function () {
    
    Route::get('/', function () {
        return redirect('dashboard');
    });

    // Dashboard
    Route::get('dashboard', 'c_Overview@index');
    Route::get('dashboard/data', 'c_Overview@listData');
    Route::post('dashboard/payslip', 'c_Overview@updateStatusPayslip');
    
    Route::get('dashboard/data-bpjs', 'c_Overview@listDataBpjs');

    // informasi karyawan
        // total-karyawan aktive- detail
        Route::get('dashboard-{id}', 'c_Overview_informasiKaryawan@index');
        Route::get('dashboard/total-karyawan/{id}', 'c_Overview_informasiKaryawan@listData');

        // informasi kehadiran -personal
        Route::get('penggajian-{id}', 'c_Overview_informasiPenggajian@index');
        Route::get('penggajian-list-data/{id}', 'c_Overview_informasiPenggajian@listData');

    Route::get('dashboard/profile', 'c_Profile@edit');
    Route::post('dashboard/profile/submit', 'c_Profile@submit');

    Route::middleware(['menu.permission'])->group(function () {

    // System Utilities
        // Menu
        Route::get('dashboard/system/menu', 'c_SysMenu@index');
        Route::get('dashboard/system/menu-group', 'c_SysMenuGroup@index');
        Route::get('dashboard/system/menu-group/list', 'c_SysMenuGroup@list');
        Route::get('dashboard/system/menu-group/list/data', 'c_SysMenuGroup@listData');
        Route::post('dashboard/system/menu-group/submit', 'c_SysMenuGroup@submit');
        Route::get('dashboard/system/menu-group/edit/{id}', 'c_SysMenuGroup@edit');

        // Menu Group
        Route::get('dashboard/system/menu', 'c_SysMenu@index');
        Route::get('dashboard/system/menu/list', 'c_SysMenu@list');
        Route::post('dashboard/system/menu/list/data', 'c_SysMenu@listData');
        Route::post('dashboard/system/menu/submit', 'c_SysMenu@submit');
        Route::get('dashboard/system/menu/edit/{id}', 'c_SysMenu@edit');
        Route::post('dashboard/system/menu/reorder', 'c_SysMenu@reorder');

        // Groups
        Route::get('dashboard/system-utility/group', 'c_Sys_Group@index');
        Route::get('dashboard/system-utility/group/list', 'c_Sys_Group@list');
        Route::get('dashboard/system-utility/group/list/data', 'c_Sys_Group@listData');
        Route::post('dashboard/system-utility/group/submit', 'c_Sys_Group@submit');
        Route::get('dashboard/system-utility/group/edit/{id}', 'c_Sys_Group@edit');
        Route::post('dashboard/system-utility/group/disable', 'c_Sys_Group@disable');
        Route::post('dashboard/system-utility/group/activate', 'c_Sys_Group@activate');
      
        // Group-sub
        Route::get('dashboard/system-utility/group-sub', 'c_Sys_GroupSub@index');
        Route::get('dashboard/system-utility/group-sub/list', 'c_Sys_GroupSub@list');
        Route::get('dashboard/system-utility/group-sub/list/data', 'c_Sys_GroupSub@listData');
        Route::post('dashboard/system-utility/group-sub/submit', 'c_Sys_GroupSub@submit');
        Route::get('dashboard/system-utility/group-sub/edit/{id}', 'c_Sys_GroupSub@edit');
        Route::post('dashboard/system-utility/group-sub/disable', 'c_Sys_GroupSub@disable');
        Route::post('dashboard/system-utility/group-sub/activate', 'c_Sys_GroupSub@activate');

        // Group-sub-variable
        Route::get('dashboard/system-utility/group-sub-variable', 'c_Sys_GroupSubVariable@index');
        Route::get('dashboard/system-utility/group-sub-variable/list', 'c_Sys_GroupSubVariable@list');
        Route::get('dashboard/system-utility/group-sub-variable/list/data', 'c_Sys_GroupSubVariable@listData');
        Route::post('dashboard/system-utility/group-sub-variable/submit', 'c_Sys_GroupSubVariable@submit');
        Route::get('dashboard/system-utility/group-sub-variable/edit/{id}', 'c_Sys_GroupSubVariable@edit');
        Route::post('dashboard/system-utility/group-sub-variable/disable', 'c_Sys_GroupSubVariable@disable');
        Route::post('dashboard/system-utility/group-sub-variable/activate', 'c_Sys_GroupSubVariable@activate');

        // Grouping-sub-variable
        Route::get('spGroup', 'c_Sys_GroupingSubVariable@spGroup');
        Route::get('spGroupSub', 'c_Sys_GroupingSubVariable@spGroupSub');
        
        // get data List-Baru
        Route::get('dashboard/system-utility/grouping-sub-variable/list/data/{idGroup}/{idSubGroup}', 'c_Sys_GroupingSubVariable@listDataVariable');
        Route::post('dashboard/system-utility/grouping-sub-variable/submit', 'c_Sys_GroupingSubVariable@submit');

        Route::get('dashboard/system-utility/grouping-sub-variable', 'c_Sys_GroupingSubVariable@index');
        Route::get('dashboard/system-utility/grouping-sub-variable/list', 'c_Sys_GroupingSubVariable@list');
        
        Route::get('dashboard/system-utility/grouping-sub-variable/data', 'c_Sys_GroupingSubVariable@listData');
        Route::get('dashboard/system-utility/grouping-sub-variable/edit/{id}', 'c_Sys_GroupingSubVariable@edit');

        // Group-Sub-Variable-BPJS
        Route::get('dashbaord/system-utility/grouping-sub-variable-bpjs', 'c_Sys_GroupinSubVariableBpjs@index');
        Route::get('dashbaord/system-utility/grouping-sub-variable-bpjs/list', 'c_Sys_GroupinSubVariableBpjs@list');
        Route::get('dashbaord/system-utility/grouping-sub-variable-bpjs/list/data', 'c_Sys_GroupinSubVariableBpjs@listData');

        // Group Rumus
        Route::get('dashboard/system-utility/group-rumus', 'c_Sys_GroupRumus@index');
        Route::get('dashboard/system-utility/group-rumus/list', 'c_Sys_GroupRumus@list');
        Route::get('dashboard/system-utility/group-rumus/list/data', 'c_Sys_GroupRumus@listData');

        // Activity History
        Route::get('dashboard/system-utility/activity-history', 'c_SysActivityHistory@index');
        Route::get('dashboard/system-utility/activity-history/list/data', 'c_SysActivityHistory@listData');
    // end

        // Master Data
        Route::get('dashboard/master/user-management', 'c_MasterUserManagement@index');
        Route::get('dashboard/master/user-management/list', 'c_MasterUserManagement@list');
        Route::get('dashboard/master/user-management/data', 'c_MasterUserManagement@data');
        Route::get('dashboard/master/user-management/edit/{username}', 'c_MasterUserManagement@edit');
        Route::post('dashboard/master/user-management/submit', 'c_MasterUserManagement@submit');
        Route::post('dashboard/master/user-management/reset-password', 'c_MasterUserManagement@resetPassword');
        Route::post('dashboard/master/user-management/disable', 'c_MasterUserManagement@disable');
        Route::post('dashboard/master/user-management/activate', 'c_MasterUserManagement@activate');

        Route::post('dashboard/master/user-management/import-user', 'c_MasterUserManagement@importUserManagement');
        Route::get('dashboard/master-data/user-management/export', 'c_MasterUserManagement@exportUserManagement');

        // Upah Karyawan
        Route::get('master-data-upah-karyawan', 'c_master_upahKaryawan@index');
        Route::get('dashboard/master-data/upah-karyawan/data', 'c_master_upahKaryawan@data');
        Route::get('master-data-upah-karyawan-edit-{username}', 'c_master_upahKaryawan@edit');

        Route::post('dashboard/master-data/upah-karyawan/submit', 'c_master_upahKaryawan@submit');

        Route::post('dashboard/master-data/upah-karyawan/reset-password', 'c_master_upahKaryawan@resetPassword');
        Route::post('dashboard/master-data/upah-karyawan/disable', 'c_master_upahKaryawan@disable');
        Route::post('dashboard/master-data/upah-karyawan/activate', 'c_master_upahKaryawan@activate');

        Route::post('dashboard/master-data/upah-karyawan/import-user', 'c_master_upahKaryawan@importUpahKaryawan');
        Route::get('dashboard/master-data/upah-karyawan/export', 'c_master_upahKaryawan@exportUpahKaryawan');
        Route::get('dashboard/master-data/upah-karyawan/export-gaji', 'c_master_upahKaryawan@exportUpahKaryawanGaji');

        // Departemen
        Route::get('dashboard/master/departemen', 'c_master_departemen@index');
        Route::get('dashboard/master/departemen/list', 'c_master_departemen@list');
        Route::get('dashboard/master/departemen/data', 'c_master_departemen@listData');
        Route::get('dashboard/master/departemen/edit/{id}', 'c_master_departemen@edit');
        Route::post('dashboard/master/departemen/submit', 'c_master_departemen@submit');
        //Route::post('dashboard/master/departemen/disable', 'c_master_departemen@disable');
        //Route::post('dashboard/master/departemen/activate', 'c_master_departemen@activate');

        // Sub-Departemen
        Route::get('dashboard/master/sub-departemen', 'c_master_subDepartemen@index');
        Route::get('dashboard/master/sub-departemen/list', 'c_master_subDepartemen@list');
        Route::get('dashboard/master/sub-departemen/data', 'c_master_subDepartemen@listData');
        Route::get('dashboard/master/sub-departemen/edit/{id}', 'c_master_subDepartemen@edit');
        Route::post('dashboard/master/sub-departemen/submit', 'c_master_subDepartemen@submit');

        // Grade
        Route::get('dashboard/master/grade', 'c_master_grade@index');
        Route::get('dashboard/master/grade/list', 'c_master_grade@list');
        Route::get('dashboard/master/grade/data', 'c_master_grade@listData');
        Route::get('dashboard/master/grade/edit/{id}', 'c_master_grade@edit');
        Route::post('dashboard/master/grade/submit', 'c_master_grade@submit');

        // Skema hari kerja
        Route::get('dashboard/master/skema-hari-kerja', 'c_master_skemaHariKerja@index');
        Route::get('dashboard/master/skema-hari-kerja/list', 'c_master_skemaHariKerja@list');
        Route::get('dashboard/master/skema-hari-kerja/data', 'c_master_skemaHariKerja@listData');
        Route::get('dashboard/master/skema-hari-kerja/edit/{id}', 'c_master_skemaHariKerja@edit');
        Route::post('dashboard/master/skema-hari-kerja/submit', 'c_master_skemaHariKerja@submit');
        //Route::post('dashboard/master/departemen/disable', 'c_master_skemaHariKerja@disable');
        //Route::post('dashboard/master/departemen/activate', 'c_master_skemaHariKerja@activate');

    // Hutang Karyawan
        // Anggota 
        Route::get('dashboard/hutang-perusahaan/anggota', 'c_penggajian_generateGaji@index');
        Route::get('dashboard/hutang-perusahaan/anggota/list', 'c_penggajian_generateGaji@list');
        Route::get('dashboard/hutang-perusahaan/anggota/data', 'c_penggajian_generateGaji@listData');

   // Penggajian 
        // generate gaji
        Route::get('dashboard/penggajian/generate-gaji', 'c_penggajian_generateGaji@index');
        Route::get('dashboard/penggajian/generate-gaji/list', 'c_penggajian_generateGaji@list');
        Route::get('dashboard/penggajian/generate-gaji/data', 'c_penggajian_generateGaji@listData');
        Route::get('listPeriodeJadwal', 'c_penggajian_generateGaji@listPeriodeJadwal');
        Route::post('dashboard/penggajian/generate-gaji/submit', 'c_penggajian_generateGaji@generateGajiPeriode');

        // Upah - Karyawan
        Route::get('dashboard/penggajian/upah-karyawan', 'c_penggajian_upahKaryawan@index');
            // Action Data
            Route::get('penggajian/upah-karyawan-add', 'c_penggajian_upahKaryawan@addKaryawan');
            Route::post('penggajian/upah-karyawan/action', 'c_penggajian_upahKaryawan@actionData');
            // Action Export
            Route::get('penggajian/upah-karyawan/actionExport/{id}/{idData}', 'c_penggajian_upahKaryawan@actionExport');

        Route::get('dashboard/penggajian/upah-karyawan/data', 'c_penggajian_upahKaryawan@data');
        Route::get('penggajian/upah-karyawan/listDataTidakTerdaftar', 'c_penggajian_upahKaryawan@listData');
    
        Route::get('dashboard/penggajian/upah-karyawan/edit/{username}', 'c_penggajian_upahKaryawan@edit');
        Route::post('dashboard/penggajian/upah-karyawan/submit', 'c_penggajian_upahKaryawan@submitEdit');
        Route::post('penggajian/upah-karyawan/submit', 'c_penggajian_upahKaryawan@submit');
       
        // Absensi Karyawan
        Route::get('dashboard/penggajian/absensi-karyawan', 'c_penggajian_absensi@index');
        Route::get('dashboard/penggajian/absensi-karyawan/data', 'c_penggajian_absensi@data');
        Route::get('dashboard/penggajian/absensi-karyawan/list', 'c_penggajian_absensi@list');
        Route::get('dashboard/penggajian/absensi-karyawan/listData', 'c_penggajian_absensi@listData');
            // syncronise absensi karyawan
            Route::post('GetPivotPeriode', 'c_penggajian_absensi@GetPivotPeriode');
            Route::post('dashboard/penggajian/absensi-karyawan/submit', 'c_penggajian_absensi@submit');
            Route::post('dashboard/penggajian/absensi-karyawan/kunci', 'c_penggajian_absensi@kunci');
            // Action Data
            Route::post('penggajian/absensi-karyawan/action', 'c_penggajian_absensi@actionData');

        // Data Lembur
        Route::get('dashboard/penggajian/data-lembur', 'c_penggajian_dataLembur@index');
            // Action Data
            Route::get('penggajian/data-lembur-add', 'c_penggajian_dataLembur@addLembur');
            Route::get('penggajian/data-lembur-importExcel', 'c_penggajian_dataLembur@importLembur');
            Route::post('penggajian/data-lembur/action', 'c_penggajian_dataLembur@actionData');
            // Action Export
            Route::get('penggajian/data-lembur/actionExport/{id}/{idData}', 'c_penggajian_dataLembur@actionExport');

        Route::get('dashboard/penggajian/data-lembur/data', 'c_penggajian_dataLembur@data');
        Route::get('dashboard/penggajian/data-lembur/list', 'c_penggajian_dataLembur@list');
        Route::get('dashboard/penggajian/data-lembur/list/data', 'c_penggajian_dataLembur@listData');
        Route::get('namaKaryawanPeriode', 'c_penggajian_dataLembur@getKaryawanGajiPeriode');
        Route::post('dashboard/penggajian/data-lembur/submit', 'c_penggajian_dataLembur@submit');
        Route::post('penggajian/data-lembur/submitModule', 'c_penggajian_dataLembur@submitModule');
        Route::post('dashboard/penggajian/data-lembur/import-lembur', 'c_penggajian_dataLembur@imporDataLembur');
    
        // Bpjs  
        Route::get('dashboard/penggajian/bpjs', 'c_penggajian_bpjs@index');
            // Action Data
            Route::get('penggajian/bpjs-exportAll', 'c_penggajian_bpjs@exportAll');
            Route::get('penggajian/bpjs/actionExport/{id}/{idData}', 'c_penggajian_bpjs@actionExport');
        Route::get('dashboard/penggajian/bpjs/data', 'c_penggajian_bpjs@data');
        Route::get('dashboard/penggajian/bpjs/data/edit/{id}', 'c_penggajian_bpjs@dataEdit');
        Route::post('dashboard/penggajian/bpjs/submit', 'c_penggajian_bpjs@submit');
        Route::post('dashboard/penggajian/bpjs/updateVariable', 'c_penggajian_bpjs@updateVariable');
        
        Route::post('dashboard/penggajian/bpjs/data-karyawan/{idKaryawan}', 'c_penggajian_bpjs@listDataBpjs');
        Route::get('dashboard/penggajian/bpjs/export-all', 'c_penggajian_bpjs@exportBpjsAllData');
        Route::post('penggajian/bpjs/submitModule', 'c_penggajian_bpjs@submitModule');
        
        // Paycheck
        Route::get('dashboard/penggajian/paycheck', 'c_penggajian_paycheck@index');
        Route::get('dashboard/penggajian/paycheck/data', 'c_penggajian_paycheck@data');
        Route::get('dashboard/penggajian/paycheck/export-gaji', 'c_penggajian_paycheck@exportUpahKaryawanGaji');
        Route::get('dashboard/penggajian/paycheck/export-gaji/selected/{id}', 'c_penggajian_paycheck@exportUpahKaryawanGajiSelected');
        Route::get('dashboard/penggajian/paycheck/export-gaji/checkBox/{idData}', 'c_penggajian_paycheck@exportUpahKaryawanGajiCheckBox');

        Route::get('dashboard/penggajian/paycheck/cekThp', 'c_penggajian_paycheck@hitungThp');
        Route::post('penggajian/paycheck/submitModule', 'c_penggajian_paycheck@submitModule');
        
        
    // Laporan 
        // Analisa-pph21
        Route::get('laporan/analisa-pph21', 'c_laporan_analisaPph@index');
        Route::get('laporan/analisa-pph21/data', 'c_laporan_analisaPph@data');

        // Analisa-bpjs
        Route::get('laporan/analisa-bpjs', 'c_laporan_analisaBpjs@index');
        Route::get('laporan/analisa-bpjs/data/{idPeriode}', 'c_laporan_analisaBpjs@data');
        Route::get('laporan/analisa-bpjs/actionExport/{id}/{idData}', 'c_laporan_analisaBpjs@actionExport');

        // analisa-payroll
        Route::get('laporan/analisa-payroll', 'c_laporan_analisaPayroll@index');
        Route::get('laporan/analisa-payroll/data/{idPeriode}', 'c_laporan_analisaPayroll@data');
        Route::get('laporan/analisa-payroll/actionExport/{typeExport}/{idPeriode}/{idDataKaryawan}', 'c_laporan_analisaPayroll@actionExport');
    });
});
