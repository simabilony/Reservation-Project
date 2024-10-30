<?php

use App\Http\Controllers\CompanyActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyGuideController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', HomeController::class)->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('companies', CompanyController::class)->middleware('isAdmin');
Route::resource('companies.users', CompanyUserController::class)->except('show');
Route::resource('companies.guides', CompanyGuideController::class)->except('show');
Route::resource('companies.activities', CompanyActivityController::class);

require __DIR__.'/auth.php';
