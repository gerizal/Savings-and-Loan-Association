<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TaspenController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\BranchUnitController;
use App\Http\Controllers\ServiceUnitController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\SlikController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\InternalController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\ApplicationFilesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BusinessDataController;


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



Route::middleware(['guest'])->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate'])->name('auth.authenticate');
    Route::get('password/reset', [ResetPasswordController::class, 'showResetEmail'])->name('password.email.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'postResetEmail'])->name('password.submit.email.reset');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showReset'])->name('password.reset');
    Route::post('password/reset/{token}', [ResetPasswordController::class, 'postReset'])->name('password.submit.reset');
    Route::get('password/user/set/{token}', [ResetPasswordController::class, 'showSetPassword'])->name('setup.password');
    Route::post('password/set', [ResetPasswordController::class, 'setPassword'])->name('setup.set.password');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');
    Route::resource('user', UserController::class);
    Route::get('user/data/datatable', [UserController::class,'datatable'])->name('user.datatable');
    Route::get('user/profile', [UserController::class,'profile'])->name('user.profile');
    Route::post('user/update_profile/{id}', [UserController::class,'updateProfile'])->name('user.update.profile');
    Route::get('user/data/datatable', [UserController::class,'datatable'])->name('user.datatable');
    Route::resource('role', RoleController::class);
    Route::get('role/data/datatable', [RoleController::class,'datatable'])->name('role.datatable');
    Route::resource('menu', MenuController::class);
    Route::resource('simulation', SimulationController::class);
    Route::get('simulation/data/datatable', [SimulationController::class,'datatable'])->name('simulation.datatable');
    Route::resource('attendance', AttendanceController::class);
    Route::get('attendance/report', [AttendanceController::class,'report'])->name('attendance.report');
    Route::get('attendance/data/datatable', [AttendanceController::class,'datatable'])->name('attendance.datatable');
    Route::prefix('master-data')->name('master-data.')->group(function () {
        Route::prefix('data-table')->name('datatable.')->group(function () {
            Route::get('finance', [FinanceController::class,'datatable'])->name('finance');
            Route::get('product', [ProductController::class,'datatable'])->name('product');
            Route::get('bank', [BankController::class,'datatable'])->name('bank');
            Route::get('employee', [EmployeeController::class,'datatable'])->name('employee');
            Route::get('taspen', [TaspenController::class,'datatable'])->name('taspen');
            Route::get('referral', [ReferralController::class,'datatable'])->name('referral');
            Route::get('service-unit', [ServiceUnitController::class,'datatable'])->name('service-unit');
            Route::get('branch-unit', [BranchUnitController::class,'datatable'])->name('branch-unit');
        });
        Route::prefix('dropdown')->name('dropdown.')->group(function () {
            Route::post('finance', [FinanceController::class,'dropdown'])->name('finance');
            Route::post('product', [ProductController::class,'dropdown'])->name('product');
            Route::post('branch-unit', [MasterDataController::class, 'branchUnit'])->name('branch-unit');
            Route::post('marketing', [MasterDataController::class, 'marketing'])->name('marketing');
        });
        Route::resource('finance', FinanceController::class);
        Route::resource('product', ProductController::class);
        Route::resource('bank', BankController::class);
        Route::resource('employee', EmployeeController::class);
        Route::resource('taspen', TaspenController::class);
        Route::post('taspen/detail', [TaspenController::class,'detail'])->name('taspen.detail');
        Route::resource('referral', ReferralController::class);
        Route::resource('branch-unit', BranchUnitController::class);
        Route::resource('service-unit', ServiceUnitController::class);
        Route::post('provinces', [MasterDataController::class, 'provinces'])->name('provinces');
        Route::post('cities', [MasterDataController::class, 'cities'])->name('cities');
        Route::post('districts', [MasterDataController::class, 'districts'])->name('districts');
        Route::post('sub-districts', [MasterDataController::class, 'subDistricts'])->name('sub-districts');
    });
    Route::prefix('application')->name('application.')->group(function () {
        Route::resource('loan',ApplicationController::class);
        Route::get('data-table/loan',[ApplicationController::class, 'datatable'])->name('loan.datatable');
        Route::post('loan/{loan}/confirm',[ApplicationController::class, 'confirm'])->name('loan.confirm');
        Route::get('slik',[SlikController::class,'index'])->name('slik.index');;
        Route::get('slik/{id}',[SlikController::class,'show'])->name('slik.show');
        Route::delete('slik/{id}',[SlikController::class,'delete'])->name('slik.delete');
        Route::post('slik/{id}/approve-reject',[SlikController::class,'approveReject'])->name('slik.approve-reject');
        Route::get('data-table/slik',[SlikController::class, 'datatable'])->name('slik.datatable');
        Route::get('verification',[VerificationController::class,'index'])->name('verification.index');;
        Route::get('verification/{id}',[VerificationController::class,'show'])->name('verification.show');
        Route::delete('verification/{id}',[VerificationController::class,'delete'])->name('verification.delete');
        Route::post('verification/{id}/approve-reject',[VerificationController::class,'approveReject'])->name('verification.approve-reject');
        Route::get('data-table/verification',[VerificationController::class, 'datatable'])->name('verification.datatable');
        Route::get('approval',[ApprovalController::class,'index'])->name('approval.index');;
        Route::get('approval/{id}',[ApprovalController::class,'show'])->name('approval.show');
        Route::post('approval/{id}/approve-reject',[ApprovalController::class,'approveReject'])->name('approval.approve-reject');
        Route::get('data-table/approval',[ApprovalController::class, 'datatable'])->name('approval.datatable');
        Route::post('print/contract/{id}',[ContractController::class, 'printContract'])->name('print.contract');
        Route::get('operational',[InternalController::class,'index'])->name('internal.index');
        Route::get('operational/document',[InternalController::class,'document'])->name('internal.document');
        Route::get('operational/disbursement',[InternalController::class,'disbursement'])->name('internal.disbursement');
        Route::get('operational/second-disbursement',[InternalController::class,'secondDisbursement'])->name('internal.second-disbursement');
        Route::get('operational/si-disbursement',[InternalController::class,'SIDisbursement'])->name('internal.si-disbursement');
        Route::post('operational/print-si',[InternalController::class,'printSIDisbursement'])->name('internal.si-disbursement.print');
        Route::post('data-table/document',[InternalController::class,'datatableDocument'])->name('internal.document.datatable');
        Route::get('data-table/disbursement',[InternalController::class,'datatableDisbursement'])->name('internal.disbursement.datatable');
        Route::get('data-table/second-disbursement',[InternalController::class,'datatableSecondDisbursement'])->name('internal.second-disbursement.datatable');
        Route::get('data-table/si-disbursement',[InternalController::class,'datatableSIDisbursement'])->name('internal.si-disbursement.datatable');
        Route::post('files/upload',[InternalController::class,'uploadFiles'])->name('files.upload');
        Route::get('{id}/files/view',[InternalController::class,'viewFiles'])->name('files.view');
        Route::post('operational/dropping/upload',[InternalController::class,'uploadDroppingEvidence'])->name('internal.dropping-evidence.upload');
        Route::post('operational/bank-transfer/upload',[InternalController::class,'uploadBankTransferEvidence'])->name('internal.bank-transfer.upload');
        Route::post('operational/reception/upload',[InternalController::class,'uploadReceptionEvidence'])->name('internal.reception-evidence.upload');
        Route::post('operational/disbursement/approve',[InternalController::class,'disbursementApprove'])->name('internal.disbursement.approve');
    });

    Route::prefix('berkas')->name('files.')->group(function () {
        // cari berkas
        Route::get('pembiayaan',[ApplicationFilesController::class, 'applications'])->name('applications');
        Route::get('pembiayaan/data-table',[ApplicationFilesController::class, 'applicationDataTable'])->name('application.datatable');
        // cetak berkas penyerahan
        Route::get('cetak-berkas-penyerahan',[ApplicationFilesController::class, 'getSubmission'])->name('submission');
        Route::get('cetak-berkas-penyerahan/data-table',[ApplicationFilesController::class, 'submissionDataTable'])->name('submission.datatable');
        Route::post('cetak-berkas-penyerahan',[ApplicationFilesController::class, 'printSubmission'])->name('print.submission');
        // upload berkas penyerahan
        Route::get('upload-berkas-penyerahan',[ApplicationFilesController::class, 'getSubmissionFiles'])->name('get.submission-files');
        Route::get('upload-berkas-penyerahan/data-table',[ApplicationFilesController::class, 'submissionFilesDataTable'])->name('submission-files.datatable');
        Route::post('upload-berkas-penyerahan',[ApplicationFilesController::class, 'uploadSubmissionFiles'])->name('upload.submission-files');
        // Cetak Berkas Jaminan
        Route::get('cetak-berkas-jaminan',[ApplicationFilesController::class, 'getGuarantee'])->name('guarantee');
        Route::get('cetak-berkas-jaminan/data-table',[ApplicationFilesController::class, 'guaranteeDataTable'])->name('guarantee.datatable');
        Route::post('cetak-berkas-jaminan',[ApplicationFilesController::class, 'printGuarantee'])->name('print.guarantee');

        Route::get('upload-berkas-jaminan',[ApplicationFilesController::class, 'getGuaranteeFiles'])->name('get.guarantee-files');
        Route::get('upload-berkas-jaminan/data-table',[ApplicationFilesController::class, 'guaranteeFilesDataTable'])->name('guarantee-files.datatable');
        Route::post('upload-berkas-jaminan',[ApplicationFilesController::class, 'uploadGuaranteeFiles'])->name('upload.guarantee-files');
    });
    Route::prefix('laporan')->name('report.')->group(function () {
        // cari berkas
        Route::get('/daftar-nominatif',[ReportController::class, 'index'])->name('index');
        Route::get('/arus-kas',[ReportController::class, 'cashFlow'])->name('cash-flow');
        Route::get('/daftar-outstanding-aktif',[ReportController::class, 'outstanding'])->name('outstanding');
        Route::get('/laporan-bulanan',[ReportController::class, 'monthly'])->name('monthly');
        Route::get('/fixed-cost',[ReportController::class, 'fixedCost'])->name('fixed-cost');
        Route::get('/alternative-cost',[ReportController::class, 'alternativeCost'])->name('alternative-cost');
        Route::get('/pembayaran-asuransi',[ReportController::class, 'insurance'])->name('insurance');
        Route::get('/pelunasan-debitur',[ReportController::class, 'debtor'])->name('debtor');
        Route::post('datatable',[ReportController::class, 'dataTable'])->name('datatable');
        Route::post('cash-flow-datatable',[ReportController::class, 'cashFlowDataTable'])->name('cash-flow-datatable');
        Route::post('outstanding-datatable',[ReportController::class, 'outstandingDataTable'])->name('outstanding-datatable');
        Route::post('monthly-datatable',[ReportController::class, 'monthlyDataTable'])->name('monthly-datatable');
        Route::post('fixed-cost-datatable',[ReportController::class, 'fixedCostDataTable'])->name('fixed-cost-datatable');
        Route::post('alternative-cost-datatable',[ReportController::class, 'alternativeCostDataTable'])->name('alternative-cost-datatable');
        Route::post('insurance-datatable',[ReportController::class, 'insuranceDataTable'])->name('insurance-datatable');
        Route::post('debtor-datatable',[ReportController::class, 'debtorDataTable'])->name('debtor-datatable');
        Route::post('generate-report',[ReportController::class, 'generateReport'])->name('generate-report');
        Route::post('generate-report-cash-flow',[ReportController::class, 'generateReportCashFlow'])->name('generate-report-cash-flow');
        Route::post('generate-report-outstanding',[ReportController::class, 'generateReportOutstanding'])->name('generate-report-outstanding');
        Route::post('generate-report-debtor',[ReportController::class, 'generateReportDebtor'])->name('generate-report-debtor');
    });
    Route::prefix('data-bisnis')->name('business-data.')->group(function () {
        Route::get('/',[BusinessDataController::class, 'index'])->name('index');
        Route::post('/data-table',[BusinessDataController::class, 'dataTable'])->name('datatable');
        Route::post('/data-table-marketing',[BusinessDataController::class, 'dataTableMarketing'])->name('datatable-marketing');
        Route::post('/data-table-debitur',[BusinessDataController::class, 'dataTableDebitur'])->name('datatable-debitur');
    });
    Route::get('monitoring',[MonitoringController::class,'index'])->name('monitoring.index');;
    Route::get('monitoring/{id}',[MonitoringController::class,'show'])->name('monitoring.show');
    Route::post('monitoring/{id}/approve-reject',[MonitoringController::class,'approveReject'])->name('monitoring.approve-reject');
    Route::delete('monitoring/{id}/delete',[MonitoringController::class,'destroy'])->name('monitoring.destroy');
    Route::get('data-table/monitoring',[MonitoringController::class, 'datatable'])->name('monitoring.datatable');
    Route::get('data-table/regular-bank-dt',[HomeController::class, 'regularBankDataTable'])->name('home.regular.datatable');
    Route::get('data-table/flash-bank-dt',[HomeController::class, 'flashBankDataTable'])->name('home.flash.datatable');
    Route::get('data-table/area-service-dt',[HomeController::class, 'areaDataTable'])->name('home.area.datatable');
    Route::get('data-table/branch-service-dt',[HomeController::class, 'branchDataTable'])->name('home.branch.datatable');
    Route::get('data-table/marketing-dt',[HomeController::class, 'marketingDataTable'])->name('home.marketing.datatable');
    Route::get('installment',[InstallmentController::class,'index'])->name('installment.index');
    Route::get('data-table/installment',[InstallmentController::class,'dataTableInstallment'])->name('installment.data-table-installment');
    Route::get('installment/{application_id}',[InstallmentController::class,'detail'])->name('installment.detail');
    Route::get('installment/{application_id}/data-table',[InstallmentController::class,'dataTable'])->name('installment.data-table');
    Route::post('installment/payment/{id}/update',[InstallmentController::class,'paymentUpdate'])->name('installment.payment.update');
});
Route::get('print/contract/{id}',[MonitoringController::class, 'printContract'])->name('print.contract');
