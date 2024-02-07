<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::group([
            // 'middleware' => ['is_admin'],
            'prefix' => 'admin',
            'as' => 'admin.'] ,function () {
        Route::resource('users', UserController::class);
        Route::resource('clients', ClientController::class);
        Route::get('projects/{project}/assign/create', [ProjectController::class, 'assignCreate'])->name('projects.assignCreate');
        Route::patch('projects/{project}/assign', [ProjectController::class, 'assignStore'])->name('projects.assignStore');
        Route::resource('projects', ProjectController::class);
        Route::resource('tasks', TaskController::class);
    });
    // Route::resource('tasks', ::class)->only('index', 'show');
});