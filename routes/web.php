<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\EducationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AssessmentInterpretationController;
use App\Http\Controllers\AssessmentQuestionController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\ReportSettingController;
use App\Http\Controllers\BookletPageController;

use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'landing'])->name('public.landing');
Route::get('/cek-loneliness', [PublicController::class, 'calculator'])->name('public.calculator');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('admin/users', UserManagementController::class)
    ->names('users');

    Route::get('/admin/report-settings', [ReportSettingController::class, 'index'])
    ->name('report-settings.index');

    Route::put('/admin/report-settings', [ReportSettingController::class, 'update'])
    ->name('report-settings.update');

    Route::get('/admin/site-settings', [SiteSettingController::class, 'index'])
    ->name('site-settings.index');

    Route::put('/admin/site-settings', [SiteSettingController::class, 'update'])    
    ->name('site-settings.update');

    Route::resource('admin/interpretations', AssessmentInterpretationController::class)
    ->names('interpretations');

    Route::resource('admin/questions', AssessmentQuestionController::class)
    ->names('questions');

    Route::resource('admin/booklet-pages', BookletPageController::class)
    ->except(['show'])
    ->parameters(['booklet-pages' => 'bookletPage'])
    ->names('booklet-pages');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('patients', PatientController::class);

    Route::get('/assessment-loneliness', [AssessmentController::class, 'selectPatient'])
    ->name('assessments.select_patient');

    Route::get('/patients/{patient}/assessments/create', [AssessmentController::class, 'create'])
        ->name('assessments.create');

    Route::post('/patients/{patient}/assessments', [AssessmentController::class, 'store'])
        ->name('assessments.store');

    Route::get('/assessments', [AssessmentController::class, 'index'])
    ->name('assessments.index');

    Route::get('/assessments/{assessment}/print', [AssessmentController::class, 'print'])
        ->name('assessments.print');

    Route::get('/assessments/{assessment}/follow-up', [AssessmentController::class, 'editFollowUp'])
    ->name('assessments.follow_up.edit');

    Route::put('/assessments/{assessment}/follow-up', [AssessmentController::class, 'updateFollowUp'])
    ->name('assessments.follow_up.update');

    Route::get('/assessments/{assessment}', [AssessmentController::class, 'show'])
        ->name('assessments.show');

    Route::delete('/assessments/{assessment}', [AssessmentController::class, 'destroy'])
        ->name('assessments.destroy');

    Route::get('/education/perawat', [EducationController::class, 'perawat'])
        ->name('education.perawat');

    Route::get('/education/keluarga', [EducationController::class, 'keluarga'])
        ->name('education.keluarga');

    Route::get('/education/{educationContent}', [EducationController::class, 'show'])
        ->name('education.show');

    Route::get('/admin/education-management', [EducationController::class, 'manage'])
        ->name('education.manage');

    Route::get('/admin/education/create', [EducationController::class, 'create'])
        ->name('education.create');

    Route::post('/admin/education', [EducationController::class, 'store'])
        ->name('education.store');

    Route::get('/admin/education/{educationContent}/edit', [EducationController::class, 'edit'])
        ->name('education.edit');

    Route::put('/admin/education/{educationContent}', [EducationController::class, 'update'])
        ->name('education.update');

    Route::delete('/admin/education/{educationContent}', [EducationController::class, 'destroy'])
        ->name('education.destroy');
});
