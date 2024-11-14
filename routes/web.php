<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/questions', [QuestionController::class, 'store'])->name('submit.question');

Route::get('/admin', [QuestionController::class, 'index'])->name('admin.questions');
Route::delete('/admin/questions/{id}', [QuestionController::class, 'destroy'])->name('delete.question');
Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
Route::get('/questions/create', [QuestionController::class, 'create']);
