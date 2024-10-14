<?php

use App\Http\Controllers\Download\DataUploadController;
use App\Http\Controllers\Download\SuppressionUploadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => '/download', 'as' => 'download.'], function () {
    Route::get('/data-upload', [DataUploadController::class, 'index'])->name('data-upload');
    Route::post('/data-upload', [DataUploadController::class, 'upload']);
    Route::get('/data-upload/delete/{dataUpload}', [DataUploadController::class, 'delete'])->name('data-upload.delete');

    Route::get('/suppression-upload', [SuppressionUploadController::class, 'index'])->name('suppression-upload');
    Route::post('/suppression-upload', [SuppressionUploadController::class, 'upload']);
    Route::get('/suppression-upload/delete/{dataUpload}', [SuppressionUploadController::class, 'delete'])->name('suppression-upload.delete');

});
