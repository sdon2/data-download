<?php

use App\Http\Controllers\Download\DataDownloadController;
use App\Http\Controllers\Download\DataUploadController;
use App\Http\Controllers\Download\SuppressionUploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::group(['prefix' => '/download', 'as' => 'download.', 'middleware' => ['auth']], function () {
    Route::get('/data-upload', [DataUploadController::class, 'index'])->name('data-upload');
    Route::post('/data-upload', [DataUploadController::class, 'upload']);
    Route::get('/data-upload/delete/{dataUpload}', [DataUploadController::class, 'delete'])->name('data-upload.delete');

    Route::get('/suppression-upload', [SuppressionUploadController::class, 'index'])->name('suppression-upload');
    Route::post('/suppression-upload', [SuppressionUploadController::class, 'upload']);
    Route::get('/suppression-upload/delete/{dataUpload}', [SuppressionUploadController::class, 'delete'])->name('suppression-upload.delete');

    Route::get('/data-download', [DataDownloadController::class, 'index'])->name('data-download');
    Route::post('/data-download', [DataDownloadController::class, 'download']);
    Route::get('/data-downlad/delete/{dataDowload}', [DataDownloadController::class, 'delete'])->name('data-download.delete');
    Route::get('/data-download/file/{dataDownload}', [DataDownloadController::class, 'downloadFile'])->name('data-download.file');
});
