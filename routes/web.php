<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LivewireProjectsController;
use App\Http\Controllers\Admin\MediaUploadController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\ProjectsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\ChangePasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.mass-destroy');
    Route::resource('permissions', PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.mass-destroy');
    Route::resource('roles', RolesController::class);

    // Users
    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.mass-destroy');
    Route::resource('users', UsersController::class);

    // Projects
    Route::delete('projects/destroy', [ProjectsController::class, 'massDestroy'])->name('projects.mass-destroy');
    Route::resource('projects', ProjectsController::class);

    Route::resource('livewire-projects', LivewireProjectsController::class);

    Route::post('upload-media', [MediaUploadController::class, 'uploadMedia'])->name('upload-media');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [ChangePasswordController::class, 'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class, 'update'])->name('password.update');
        Route::post('profile', [ChangePasswordController::class, 'updateProfile'])->name('password.update-profile');
        Route::post('profile/destroy', [ChangePasswordController::class, 'destroy'])->name('password.destroy-profile');
    }
});
