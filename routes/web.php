<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClasController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExamController;
use Illuminate\Support\Facades\Auth;

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
    return redirect('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'class'], function () {
    Route::any('/index', [ClasController::class, 'index'])->name('class.index');
    Route::any('/call', [ClasController::class, 'callData']);
    Route::any('/add', [ClasController::class, 'add'])->name('class.add');
    Route::any('/store', [ClasController::class, 'store'])->name('class.store');
    Route::any('/edit/{id}', [ClasController::class, 'edit'])->name('class.edit');
    Route::any('/update/{id}', [ClasController::class, 'update'])->name('class.update');
    Route::any('/delete/{id}', [ClasController::class, 'delete'])->name('class.delete');
    Route::any('/show/{id}', [ClasController::class, 'show'])->name('class.show');
});

Route::group(['prefix' => 'subject'], function () {
    Route::any('/index', [SubjectController::class, 'index'])->name('subject.index');
    Route::any('/add', [SubjectController::class, 'add'])->name('subject.create');
    Route::any('/store', [SubjectController::class, 'store'])->name('subject.store');
    Route::any('/edit/{id}', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::any('/show/{id}', [SubjectController::class, 'show'])->name('subject.show');
    Route::any('/update/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::any('/delete/{id}', [SubjectController::class, 'delete'])->name('subject.delete');
});

Route::group(['prefix' => 'student'], function () {
    Route::any('/index', [StudentController::class, 'index'])->name('student.index');
    Route::any('/add', [StudentController::class, 'add'])->name('student.create');
    Route::any('/store', [StudentController::class, 'store'])->name('student.store');
    Route::any('/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
    Route::any('/show/{id}', [StudentController::class, 'show'])->name('student.show');
    Route::any('/update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::any('/delete/{id}', [StudentController::class, 'delete'])->name('student.delete');
});


Route::group(['prefix' => '/exam'], function () {
    Route::any('/index', [ExamController::class, 'index'])->name('exam.index');
    Route::any('/add', [ExamController::class, 'add'])->name('exam.create');
    Route::any('/store', [ExamController::class, 'store'])->name('exam.store');
    Route::any('/edit/{id}', [ExamController::class, 'edit'])->name('exam.edit');
    Route::any('/show/{id}', [ExamController::class, 'show'])->name('exam.show');
    Route::any('/update/{id}', [ExamController::class, 'update'])->name('exam.update');
    Route::any('/delete/{id}', [ExamController::class, 'delete'])->name('exam.delete');
    Route::any('/{id?}', [ExamController::class, 'exam'])->name('exam.exam');
    Route::any('/get-data-to-mark/{id?}', [ExamController::class, 'getDataToMark']);

});
Route::post('/mark', [ExamController::class, 'mark']);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();