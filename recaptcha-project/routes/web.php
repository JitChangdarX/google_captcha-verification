<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController; // ✅ Import this
use App\Http\Controllers\FormController; 

Route::get('/', function () {
    return view('welcome');
});

// Correct way to define routes
Route::get('/contact', [ContactController::class, 'showForm']);
Route::post('/submit-form', [ContactController::class, 'submitForm'])->name('submit.form');
