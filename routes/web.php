<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\Admin\FoodWasteController;
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

Route::get('/', function () {
    return redirect('login');
});
Route::get('/', [HomeController::class,'index'])->name('main');
Route::post('check',[HomeController::class,'check'])->name('check');
Route::group(['middleware' => ['auth','verified','IsActive','xss'],'prefix'=>'admin'], function() {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::resource('permission_group',PermissionGroupController::class);
    Route::resource('permission',PermissionController::class);
    Route::resource('role',RoleController::class);
    Route::get('get/roles',[RoleController::class,'getRoles'])->name('getRoles');
    Route::resource('user',UserController::class);
    Route::get('get/users',[UserController::class,'getUsers'])->name('getUsers');

      // food-waste Type admin
   Route::resource('food-waste',FoodWasteController::class);
   Route::get('get/food-waste',[FoodWasteController::class,'getFoodWaste'])->name('getFoodWaste');
   Route::get('food-waste-restore/{id}', [FoodWasteController::class,'restore'])->name('food-waste.restore');
   Route::delete('food-waste-delete/{id}', [FoodWasteController::class,'delete'])->name('food-waste.delete');


});



Route::get('/logout', function () {
    Auth::logout();
    return redirect(route('login'));
});
require __DIR__.'/auth.php';
