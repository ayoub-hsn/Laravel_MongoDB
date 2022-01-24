<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeUnlikeController;
use App\Http\Controllers\NewsController;
use App\Models\News;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php'; 

Route::resource('/news',NewsController::class);
Route::delete('/new/{news}',[NewsController::class,'archive'])->name('news.archiver');
Route::post('/likeNews',[LikeUnlikeController::class,'likeNews'])->name('news.like');
Route::post('/unlikeNews',[LikeUnlikeController::class,'unlikeNews'])->name('news.unlike');
Route::post('/news/{news}/saveComment',[CommentController::class,'store'])->name('news.comment');
Route::get('/showArchive',[NewsController::class,'showArchive'])->name('news.archive');
Route::patch('/restore/{news}',[NewsController::class,'restore'])->name('news.restore');
