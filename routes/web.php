<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TickerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ImportTransactionsController;

// Login
Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');
Route::get('/logout', [LoginController::class, 'destroy'])->name('login.destroy');
Route::get('/create-user-login', [LoginController::class, 'create'])->name('login.create-user');
Route::post('/store-user-login', [LoginController::class, 'store'])->name('login.store-user');

// Recuperar senha
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPassword'])->name('forgot-password.show');
Route::post('/forgot-password', [ForgotPasswordController::class, 'submitForgotPassword'])->name('forgot-password.submit');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPassword'])->name('reset-password.submit');


Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Transações
    Route::resource('transactions', TransactionController::class);
    Route::post('/import-excel', [ImportTransactionsController::class, 'importExcel'])->name('transactions.importExcel');
    Route::get('/download-modelo-excel', [ImportTransactionsController::class, 'downloadExcel'])->name('transactions.downloadExcel');

    // Tickers
    Route::resource('tickers', TickerController::class);

    // Regras de Impostos
    Route::resource('rules', RuleController::class);

    // Impostos
    Route::get('/taxes', [TaxController::class, 'index'])->name('taxes.index');
    Route::patch('/taxes/{tax}', [TaxController::class, 'update'])->name('taxes.update');

    // Perfil
    Route::get('/show-profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/update-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/edit-profile-password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::delete('/profile/{user}', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Usuários
    Route::get('/index-user', [UserController::class, 'index'])->name('user.index')->middleware('permission:index-user');
    Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show')->middleware('permission:show-user');
    Route::get('/create-user', [UserController::class, 'create'])->name('user.create')->middleware('permission:create-user');
    Route::post('/store-user', [UserController::class, 'store'])->name('user.store')->middleware('permission:create-user');
    Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit')->middleware('permission:edit-user');
    Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update')->middleware('permission:edit-user');
    Route::get('/edit-user-password/{user}', [UserController::class, 'editPassword'])->name('user.edit-password')->middleware('permission:edit-user-password');
    Route::put('/update-user-password/{user}', [UserController::class, 'updatePassword'])->name('user.update-password')->middleware('permission:edit-user-password');
    Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('permission:destroy-user');

    // Hierarquia
    Route::get('/index-role', [RoleController::class, 'index'])->name('role.index')->middleware('permission:index-role');
    Route::get('/create-role', [RoleController::class, 'create'])->name('role.create')->middleware('permission:create-role');
    Route::post('/store-role', [RoleController::class, 'store'])->name('role.store')->middleware('permission:create-role');
    Route::get('/edit-role/{role}', [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:edit-role');
    Route::put('/update-role/{role}', [RoleController::class, 'update'])->name('role.update')->middleware('permission:edit-role');
    Route::delete('/destroy-role/{role}', [RoleController::class, 'destroy'])->name('role.destroy')->middleware('permission:destroy-role');

    // Permissões da Hierarquia
    Route::get('/index-role-permission/{role}', [RolePermissionController::class, 'index'])->name('role-permission.index')->middleware('permission:index-role-permission');
    Route::get('/update-role-permission/{role}/{permission}', [RolePermissionController::class, 'update'])->name('role-permission.update')->middleware('permission:update-role-permission');

    // Permissões
    Route::get('/index-permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/create-permission', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/store-permission', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/edit-permission/{permission}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::put('/update-permission/{permission}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/destroy-permission/{permission}', [PermissionController::class, 'destroy'])->name('permission.destroy');

});
