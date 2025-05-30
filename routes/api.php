<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/projects',[ProjectController::class,'getAll']);
Route::post('/projects',[ProjectController::class,'store']);
Route::get('/projects/{id}',[ProjectController::class,'getOne']);
Route::put('/projects/{id}',[ProjectController::class,'update']);
Route::delete('/projects/{id}',[ProjectController::class,'destroy']);

Route::get('/tasks',[TaskController::class,'getAll']); //agregar filtros
Route::post('/tasks',[TaskController::class,'store']);
Route::get('/tasks/{id}',[TaskController::class,'getOne']);
Route::put('/tasks/{id}',[TaskController::class,'update']);
Route::delete('/tasks/{id}',[TaskController::class,'destroy']);

