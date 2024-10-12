<?php

use App\Http\Controllers\Download\DataUploadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => '/download', 'as' => 'download.'], function () {
    Route::get('/data-upload', [DataUploadController::class, 'index'])->name('data-upload');
    Route::post('/data-upload', [DataUploadController::class, 'upload']);
});
