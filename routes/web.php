<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//login and register
Route::controller(AuthController::class)->group(function() {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');

    Route::get('/register', 'showRegisterForm')->name('register'); 
    Route::post('/register', 'register')->name('register.post');
});

//admin and staff page
Route::middleware(['auth'])->group(function() { //check user logged in or not
    Route::middleware(['isAdmin'])->group(function() {
        
        //task management
        Route::get('/tasks/create',[TaskController::class,'create'])->name('tasks.create');
        Route::post('/tasks',[TaskController::class,'store'])->name('tasks.store');
        Route::get('/tasks',[TaskController::class,'index'])->name('tasks.index');
        Route::get('/tasks/{task}/edit',[TaskController::class,'edit'])->name('tasks.edit');
        Route::put('/tasks/{task}',[TaskController::class,'update'])->name('tasks.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
        Route::post('/tasks/{task}/assign', [TaskController::class, 'assign'])->name('tasks.assign');

        // User management
        Route::resource('users', UserController::class);
    });

    Route::middleware(['isStaff'])->group(function() {
        // view own tasks
        Route::get('/my-tasks', [TaskController::class, 'myTasks'])
            ->name('tasks.my');

        // update status
        Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
            ->name('tasks.updateStatus');
    });
});
