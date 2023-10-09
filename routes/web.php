<?php

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

// Головна сторінка
Route::get('/', function () {
    return view('welcome');
});

// Маршрути для аутентификації, котрі включають в себе реєстрацію, вхід та вихід з системи
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

// Група маршрутів, доступних лише для автентифікованих користувачів.
Route::middleware(['auth'])->group(function () {
    // Разлогинится из системы
    Route::post('/logout', [\App\Http\Controllers\HomeController::class, 'logout'])->name('logout');

    // Маршрут для відображення списку завдань
    Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])
        ->name('task.list');

    // Маршрут для відображення форми створення нового завдання
    Route::get('/task/create', [\App\Http\Controllers\TaskController::class, 'create'])
        ->name('task.create');
    // Маршрут для відображення завдання
    Route::post('/task', [\App\Http\Controllers\TaskController::class, 'store'])
        ->name('task.store');

    // Простотреть завдання
    Route::get('/task/{task}/view', [\App\Http\Controllers\TaskController::class, 'view'])
        ->name('task.view');
    // Маршрут для відображення форми редагування завдання
    Route::get('/task/{task}/edit', [\App\Http\Controllers\TaskController::class, 'edit'])
        ->name('task.edit');
    // Маршрут для оновлення завдання
    Route::put('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'update'])
        ->name('task.update');

    // Маршрут для видалення завдання
    Route::delete('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'delete'])
        ->name('task.delete');
});
