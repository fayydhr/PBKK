<?php

use App\Http\Controllers\Todos\Todoscontroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/* Route::get('/todo', function () {
    return view('todo.app');
});
 */

 route::get('/todo', [Todoscontroller::class, 'index']);
 route::post('/todo', [Todoscontroller::class, 'store']);
 Route::delete('/todo/{id}', [TodosController::class, 'destroy']);
 Route::put('/todo/{id}', [TodosController::class, 'update']);




