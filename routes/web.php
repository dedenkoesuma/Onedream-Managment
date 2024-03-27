<?php

use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\toolLendingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/storage-link',function(){
    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder,$linkFolder);
});

Route::middleware(['filament-auth'])->group(function () {
    Route::get('/task', [ToolLendingController::class, 'index']);
    Route::post('/task', [ToolLendingController::class, 'store']);
    Route::put('/task/{id}', [ToolLendingController::class, 'update']);
});

Route::get('/attendances/export', [FinanceReportController::class, 'exportCsv'])->name('finances_reports.export');
