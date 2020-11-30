<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web;
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

Auth::routes(['register' => false, 'verify' => false]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [Web\HomeController::class, 'index'])->name('dashboard');

    
    Route::group(['as' => 'admin.'], function () {

        Route::get('/production', [Web\ProductionController::class, 'index'])->name('production');

        Route::get('/dispatch', [Web\DispatchController::class, 'index'])->name('dispatch');
        
        // Admin Routes
        // Route::get('/organizations', [Web\OrganizationController::class, 'index'])->name('organizations');

        // Route::get('/organizations/create', [Web\OrganizationController::class, 'create'])->name(
        //     'organizations.create'
        // );
        // Route::post('/organizations/create', [Web\OrganizationController::class, 'store'])->name(
        //     'organizations.create'
        // );
        
    });


    // Route::group(['middleware' => ['role:admin'], 'prefix' => 'users', 'as' => 'users'], function () {
    //     Route::get('', [Web\UserController::class, 'index'])->name('');
    //     Route::get('/create', [Web\UserController::class, 'create'])->name('.create');
    //     Route::post('/create', [Web\UserController::class, 'store'])->name('.create');
    //     Route::get('/show/{id}', [Web\UserController::class, 'show'])->name('.show');
    //     Route::post('/edit', [Web\UserController::class, 'edit'])->name('.edit');
    //     Route::post('/delete', [Web\UserController::class, 'delete'])->name('.delete');

    // });

    // Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    //     // // Route::middleware('institutions.edit')->group(function () {
    //     // Route::get('', [Web\UserController::class, 'index'])->name('users');
    //     //     Route::get('.create', [Web\UserController::class, 'create'])->name('create');
    //     // // });
    //     Route::get('/password', [Web\UserController::class, 'changePassword'])->name('password');
    //     Route::post('/password', [Web\UserController::class, 'changePassword'])->name('password');
    // });
});
