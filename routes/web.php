<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\GetUsersController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\NotificationController;
use App\Models\Task;
use App\Notifications\TaskAssigned;
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
    Route::group(['prefix' => 'admin', 'as' => 'admin.'] ,function () {
        Route::group(['middleware' => 'admin_access'] ,function () {
            Route::resource('clients', ClientController::class);
            Route::get('projects/{project}/assign/create', [ProjectController::class, 'assignCreate'])->name('projects.assignCreate');
            Route::patch('projects/{project}/assign', [ProjectController::class, 'assignStore'])->name('projects.assignStore');
            Route::post('getUsers', GetUsersController::class)->name('getUsers');
        });
        
        Route::resource('users', UserController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('tasks', TaskController::class);
        
        //notification
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/mark_as_read', [NotificationController::class, 'markNotification'])->name('notifications.markNotification');
        
        
        
    });
});

//for testing the notificaitons 
Route::get('/notification', function () {
    $task = Task::find(1);
 
    return (new TaskAssigned($task))
                ->toMail($task->user);
});