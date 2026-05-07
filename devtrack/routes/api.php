<?php
 
use App\Http\Controllers\Api\TaskApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
 
    
    Route::get('/projects/{project}/tasks', [TaskApiController::class, 'index'])
         ->name('api.tasks.index');
 
    
    Route::get('/projects/{project}/tasks/{task}', [TaskApiController::class, 'show'])
         ->name('api.tasks.show');
 
});