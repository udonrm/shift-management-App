<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;

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
    return view('index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// イベント登録処理
Route::post('/schedule-add', [ScheduleController::class, 'add'])->name('schedule.add');

// イベント取得処理
Route::post('/schedule-get', [ScheduleController::class, 'get'])->name('schedule.get');

Route::post('/schedule-update', [ScheduleController::class, 'update'])->name('schedule.update');

Route::post('/schedule-destroy', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
