<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\GetUsersController;
use App\Http\Controllers\Admin\MatcherUserProjectSkillsController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\StatusMessagesController;
use App\Http\Controllers\Admin\TaskGroupController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TeamManagerController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\CreatingProjectStatusesController;
use App\Http\Controllers\CreatingTasksStatusesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TestBroadcastController;
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
            

            Route::get('clients/getSortedClients', [ClientController::class, 'getSortedClients'])->name('clients.getSortedClients');
            Route::get('clients/getSearchResult', [ClientController::class, 'getSearchResult'])->name('clients.getSearchResult');
            Route::resource('clients', ClientController::class);
            

            Route::get('projects/{project}/assign/create', [ProjectController::class, 'assignCreate'])->name('projects.assignCreate');
            Route::patch('projects/{project}/assign', [ProjectController::class, 'assignStore'])->name('projects.assignStore');
            
            Route::post('getUsers', GetUsersController::class)->name('getUsers');

            //skills
            Route::get('skills/getSearchResult', [SkillController::class, 'getSearchResult'])->name('skills.getSearchResult'); 
            Route::get('skills/getSortedSkills', [SkillController::class, 'getSortedSkills'])->name('skills.getSortedSkills'); 
            Route::post('skills/getProjectsWithSkills', [SkillController::class, 'getProjectsWithSkills'])->name('skills.getProjectsWithSkills'); 
            Route::post('skills/getUsersWithSkills', [SkillController::class, 'getUsersWithSkills'])->name('skills.getUsersWithSkills'); 
            Route::resource('skills', SkillController::class); 
            
            Route::resource('taskGroups', TaskGroupController::class)->only('create','store')->name('taskGroups.create', 'taskGroups.store');
            
            //success views - creating Tasks/projects
            Route::get('success_create_project', CreatingProjectStatusesController::class)->name('success_create_project.status');
            Route::get('success_create_tasks', CreatingTasksStatusesController::class)->name('success_create_tasks.status');
        });
        
        Route::get('users/getSearchResult', [UserController::class, 'getSearchResult'])->name('users.getSearchResult'); 
        Route::get('users/getSortedUsers', [UserController::class, 'getSortedUsers'])->name('users.getSortedUsers'); 
        Route::get('users/getSortedRoles', [UserController::class, 'getSortedRoles'])->name('users.getSortedRoles'); 
        Route::resource('users', UserController::class);
        Route::resource('profiles', ProfileController::class);


        Route::get('projects/getSortedProjects', [ProjectController::class, 'getSortedProjects'])->name('projects.getSortedProjects');
        Route::get('projects/getSearchResult', [ProjectController::class, 'getSearchResult'])->name('projects.getSearchResult');
        Route::resource('projects', ProjectController::class);

        // managing the tasks 
        Route::get('tasks/getSearchResult',[TaskController::class, 'getSearchResult'])->name('tasks.getSearchResult');
        Route::get('tasks/getSortedTasks',[TaskController::class, 'getSortedTasks'])->name('tasks.getSortedTasks');
        Route::post('tasks/markTaskMessagesAsReaded',[TaskController::class, 'markTaskMessagesAsReaded'])->name('tasks.markTaskMessagesAsReaded');
        Route::post('tasks/sendTaskMessage',[TaskController::class, 'sendTaskMessage'])->name('tasks.sendTaskMessage');
        Route::get('tasks/showTaskChat/{task}',[TaskController::class, 'showTaskChat'])->name('tasks.showTaskChat');
        Route::get('tasks/showTasks',[TaskController::class, 'showTasks'])->name('tasks.showTasks');
        Route::post('tasks/remove',[TaskController::class, 'remove'])->name('tasks.remove');
        Route::get('tasks/accept',[TaskController::class, 'accept'])->name('tasks.accept');
        Route::get('tasks/markascompleted',[TaskController::class, 'markascompleted'])->name('tasks.markascompleted');
        Route::resource('tasks', TaskController::class);

        //team manager controller 
        Route::post('teams/markMessagesAsReaded',[TeamController::class, 'markMessagesAsReaded'])->name('teams.markMessagesAsReaded');
        Route::post('teams/sendMessage',[TeamController::class, 'sendMessage'])->name('teams.sendMessage');
        Route::resource('teams', TeamController::class)->only('index','show')->name('teams.index', 'teams.show');
        
        //Task messages manager controller 
        // Route::post('teams/sendMessage',[TeamController::class, 'sendMessage'])->name('teams.sendMessage');
        // Route::resource('teams', TeamController::class)->only('index','show')->name('teams.index', 'teams.show');

        //notification
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/mark_as_read', [NotificationController::class, 'markNotification'])->name('notifications.markNotification');
        
        // this route is responsible for retrive the status message like - not found - success - error ----
        Route::get('statuses', [StatusMessagesController::class,'notFound'])->name('statuses.notFound');

        // upload files using file pond
        Route::post('upload', [UploadController::class,'store']);

        
        Route::get('test', [TestBroadcastController::class,'sendbroadcast']);
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

// Route::post('/test', function () {
//     return true;
// })->name('test');