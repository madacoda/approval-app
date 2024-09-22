<?php

use Illuminate\Support\Facades\Route;

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


Route::get('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('login', [App\Http\Controllers\AuthController::class, 'postLogin'])->name('login.post');
Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
        Route::group(['prefix' => 'job-position'], function () {
            Route::get('/', [App\Http\Controllers\JobPositionController::class, 'index'])->name('job-position.index');
            Route::get('/form', [App\Http\Controllers\JobPositionController::class, 'create'])->name('job-position.create');
            Route::post('/', [App\Http\Controllers\JobPositionController::class, 'store'])->name('job-position.store');
            Route::get('/form/{id}', [App\Http\Controllers\JobPositionController::class, 'edit'])->name('job-position.edit');
            Route::post('/{id}', [App\Http\Controllers\JobPositionController::class, 'update'])->name('job-position.update');
            Route::delete('/{id}', [App\Http\Controllers\JobPositionController::class, 'destroy'])->name('job-position.delete');
        });

        Route::group(['prefix' => 'approval-category'], function () {
            Route::get('/', [App\Http\Controllers\ApprovalCategoryController::class, 'index'])->name('approval-category.index');
            Route::get('/form', [App\Http\Controllers\ApprovalCategoryController::class, 'create'])->name('approval-category.create');
            Route::post('/', [App\Http\Controllers\ApprovalCategoryController::class, 'store'])->name('approval-category.store');
            Route::get('/form/{id}', [App\Http\Controllers\ApprovalCategoryController::class, 'edit'])->name('approval-category.edit');
            Route::post('/{id}', [App\Http\Controllers\ApprovalCategoryController::class, 'update'])->name('approval-category.update');
            Route::delete('/{id}', [App\Http\Controllers\ApprovalCategoryController::class, 'destroy'])->name('approval-category.delete');
        });

        Route::group(['prefix' => 'unit'], function () {
            Route::get('/', [App\Http\Controllers\UnitController::class, 'index'])->name('unit.index');
            Route::get('/form', [App\Http\Controllers\UnitController::class, 'create'])->name('unit.create');
            Route::post('/', [App\Http\Controllers\UnitController::class, 'store'])->name('unit.store');
            Route::get('/form/{id}', [App\Http\Controllers\UnitController::class, 'edit'])->name('unit.edit');
            Route::post('/{id}', [App\Http\Controllers\UnitController::class, 'update'])->name('unit.update');
            Route::delete('/{id}', [App\Http\Controllers\UnitController::class, 'destroy'])->name('unit.delete');
        });
    });
    
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::get('/form', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
        Route::post('/', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
        Route::get('/form/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
        Route::post('/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
        Route::delete('/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.delete');
    });

    Route::group(['prefix' => 'approval'], function () {
        Route::post('/approval-sk', [App\Http\Controllers\ApprovalController::class, 'assignSk'])->name('approval.assign-sk');
        Route::post('/approval/{id}', [App\Http\Controllers\ApprovalController::class, 'approval'])->name('approval.approval');
        Route::post('/approval-final/{id}', [App\Http\Controllers\ApprovalController::class, 'approvalFinal'])->name('approval.approval-final');

        Route::get('/', [App\Http\Controllers\ApprovalController::class, 'index'])->name('approval.index');
        Route::get('/form', [App\Http\Controllers\ApprovalController::class, 'create'])->name('approval.create');
        Route::post('/', [App\Http\Controllers\ApprovalController::class, 'store'])->name('approval.store');
        Route::get('/form/{id}', [App\Http\Controllers\ApprovalController::class, 'edit'])->name('approval.edit');
        Route::get('/{id}', [App\Http\Controllers\ApprovalController::class, 'show'])->name('approval.show');
        Route::post('/{id}', [App\Http\Controllers\ApprovalController::class, 'update'])->name('approval.update');
        Route::delete('/{id}', [App\Http\Controllers\ApprovalController::class, 'destroy'])->name('approval.delete');
    });
});




