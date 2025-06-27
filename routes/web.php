<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('/register', [RegistrationController::class, 'index'])->name('register');
Route::post('/register', [RegistrationController::class, 'registration']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::get('/role-assign', [UserController::class, 'roleAssign']);
    Route::post('/assign-role', [UserController::class, 'assignRole'])->name('assign-role');
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/{role}', [RoleController::class, 'show'])->name('role.show');
    Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/role/{role}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role.destroy');
    Route::resource('permissions', PermissionController::class);
    Route::resource('posts', PostController::class);
    Route::get('/post/approve/{postId}', [PostController::class, 'approve'])->name('post.approve');
    Route::resource('products', ProductController::class);
    Route::get('/product/approve/{product}', [ProductController::class, 'approve'])->name('product.approve');
    Route::get('/product/publish/{product}', [ProductController::class, 'publish'])->name('product.publish');
    Route::get('/product/archive', [ProductController::class, 'archive'])->name('product.archive');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// $routeName = request()->route()?->getName();

Route::get('/test-permission', function () {
    $user = Auth::user();
    dd([
        'user' => $user->name,
        'hasPermission' => $user->hasPermission('product-create'),
        'gateAllows' => Gate::allows('product-create'),
        'allPermissions' => $user->permissions->pluck('name'),
    ]);
});
