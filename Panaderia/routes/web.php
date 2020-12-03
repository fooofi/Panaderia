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

        Route::get('/production/create', [Web\ProductionController::class, 'create'])->name('production.create');

        Route::post('/production/create', [Web\ProductionController::class, 'store'])->name('production.create');
        
        Route::post('/production/delete', [Web\ProductionController::class, 'production_delete'])->name('production.delete');
        
        Route::get('/material', [Web\MaterialController::class, 'index'])->name('material');
        
        Route::get('/material/create', [Web\MaterialController::class, 'create'])->name('material.create');
        
        Route::post('/material/create', [Web\MaterialController::class, 'store'])->name('material.create');
        
        Route::post('/material/delete', [Web\MaterialController::class, 'material_delete'])->name('material.delete');

        Route::get('/product', [Web\ProductController::class, 'index'])->name('product');

        Route::get('/product/create', [Web\ProductController::class, 'create'])->name('product.create');

        Route::post('/product/create', [Web\ProductController::class, 'store'])->name('product.create');

        Route::post('/product/delete', [Web\ProductController::class, 'product_delete'])->name('product.delete');

        Route::get('/order', [Web\OrderController::class, 'index'])->name('order');

        Route::get('/order/create', [Web\OrderController::class, 'create'])->name('order.create');
        
        Route::post('/order/create', [Web\OrderController::class, 'store'])->name('order.create');
        
        Route::post('/order/delete', [Web\OrderController::class, 'order_delete'])->name('order.delete');
        
        Route::get('/report/week', [Web\ReportController::class, 'index'])->name('report');

        Route::get('/report/cost', [Web\ReportController::class, 'cost'])->name('cost');

        Route::get('/client', [Web\ClientController::class, 'index'])->name('client');
        
        Route::get('/client/create', [Web\ClientController::class, 'create'])->name('client.create');
        
        Route::post('/client/create', [Web\ClientController::class, 'store'])->name('client.create');
        
        Route::post('/client/delete', [Web\ClientController::class, 'client_delete'])->name('client.delete');

        Route::get('/dealer', [Web\DealerController::class, 'index'])->name('dealer');
        
        Route::get('/dealer/create', [Web\DealerController::class, 'create'])->name('dealer.create');
        
        Route::post('/dealer/create', [Web\DealerController::class, 'store'])->name('dealer.create');
        
        Route::post('/dealer/delete', [Web\DealerController::class, 'dealer_delete'])->name('dealer.delete');
        
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
