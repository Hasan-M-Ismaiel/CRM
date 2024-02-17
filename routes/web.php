<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\GetUsersController;
use App\Http\Controllers\Admin\MatcherUserProjectSkillsController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TaskGroupController;
use App\Http\Controllers\CreatingProjectStatusesController;
use App\Http\Controllers\CreatingTasksStatusesController;
use App\Http\Controllers\NotificationController;
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

            //skillsx
            Route::post('skills/getProjectsWithSkills', [SkillController::class, 'getProjectsWithSkills'])->name('skills.getProjectsWithSkills'); 
            Route::post('skills/getUsersWithSkills', [SkillController::class, 'getUsersWithSkills'])->name('skills.getUsersWithSkills'); 
            Route::resource('skills', SkillController::class); 
            
            Route::resource('taskGroups', TaskGroupController::class)->only('create','store')->name('taskGroups.create', 'taskGroups.store');
            
            //success views - creating Tasks/projects
            Route::get('success_create_project', CreatingProjectStatusesController::class)->name('success_create_project.status');
            Route::get('success_create_tasks', CreatingTasksStatusesController::class)->name('success_create_tasks.status');
        });
        
        Route::resource('users', UserController::class);
        Route::resource('profiles', ProfileController::class);
        Route::resource('projects', ProjectController::class);
        Route::post('tasks/remove',[TaskController::class, 'remove'])->name('tasks.remove');
        Route::get('tasks/accept',[TaskController::class, 'accept'])->name('tasks.accept');
        Route::resource('tasks', TaskController::class);
        
        //notification
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/mark_as_read', [NotificationController::class, 'markNotification'])->name('notifications.markNotification');
        
        
    });
});

//for testing the notificaitons 
// Route::get('/notification', function () {
//     $task = Task::find(1);
 
//     return (new TaskAssigned($task))
//                 ->toMail($task->user);
// });

// Route::get('/testview', function () {
//     return view('success_create_project');
// });