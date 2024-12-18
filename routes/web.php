<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataBase\EmailProcessingController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/process-emails', [EmailProcessingController::class, 'processEmails']);
Route::post('/get-email-records', [EmailProcessingController::class, 'getRecordsForEmails']);
Route::get('/upload-emails', [EmailProcessingController::class, 'showUploadForm']);