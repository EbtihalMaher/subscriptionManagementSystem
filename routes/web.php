<?php

use App\Http\Controllers\ActivationCodeGroupController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

//Route::get('/index', function () {
//    return view('index');
//});


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::resource('roles', RoleController::class);
// Route::resource('permissions', PermissionController::class);

Route::prefix('cms')->middleware('guest:admin')->group(function () {
    Route::get('{guard}/login', [AuthController::class, 'showLogin'])->name('cms.login');
    Route::post('login', [AuthController::class, 'login']);
});

 Route::prefix('cms')->middleware(['auth:admin,user'/*, 'verified'*/])->group(function () {
     Route::get('home', [HomeController::class, 'index'])->name('cms.dashboard');
     Route::get('edit-password', [AuthController::class, 'editPassword'])->name('cms.edit-password');
     Route::resource('roles', RoleController::class);
     Route::resource('permissions', PermissionController::class);
     Route::put('edit-password', [AuthController::class, 'updatePassword']);
     Route::get('logout', [AuthController::class, 'logout'])->name('cms.logout');
 });

Route::prefix('/cms/admin')->middleware(['auth:admin'/*, 'verified'*/])->group(function () {
    Route::resource('admins', AdminController::class);
    Route::resource('users', UserController::class);
    Route::resource('enterprises', EnterpriseController::class);

    Route::get('roles/{role}/permissions', [RoleController::class, 'editRolePermissions'])->name('role.edit-permissions');
    Route::put('roles/{role}/permissions', [RoleController::class, 'updateRolePermissions']);
});

Route::prefix('/cms/user')->middleware(['auth:user'/*, 'verified'*/])->group(function () {
    Route::resource('users', UserController::class);

    Route::get('users/{user}/permissions', [UserController::class, 'editPermissions'])->name('user.edit-permissions');
    Route::put('users/{user}/permissions', [UserController::class, 'updatePermissions']);

    Route::resource('packages', PackageController::class);
    Route::resource('activation_codes_groups', ActivationCodeGroupController::class);
});
