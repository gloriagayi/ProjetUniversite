<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UniversiteController;
use App\Http\Controllers\CritereController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Frontend\FrontController;


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

 Route::get('/dashboard',[FrontController::class,'dashboard'], function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/* Route::prefix('/universite')->name('universite.')->controller(UniversiteController::class)->group(function(){
    Route::patch('/{id}',  'update')->name("update");
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
    Route::get('/{id}', 'edit')->name('edit');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');



}); */

Route::resource('universite', 'UniversiteController');
Route::resource('critere', 'CritereController');
Route::get('/universite/r/{id}', [UniversiteController::class, 'showr'])->name('universite.showr');


// Route::get('/universite/{id}', [UniversiteController::class, 'update'])->name("universite.update");
//   Route::resource('universite', 'UniversiteController');
// Route::get('universite', function () {
// });
// Route::resource('universite', 'UniversiteController')->name('universite');
// Route::resource('critere', 'CritereController');
// Route::get('/index', [UniversiteController::class, 'index']);



require __DIR__.'/auth.php';

/* Route::get('/universite/{id}', [UniversiteController::class, 'show'])->name('universite.show');
Route::get('/universite/r/{id}', [UniversiteController::class, 'showr'])->name('universite.showr');
Route::get('/universite/{id}', [UniversiteController::class, 'edit'])->name('universite.edit'); */
Route::get('admin/dashboard', [HomeController::class,'index']);
Route::get('/dashboard', [UniversiteController::class, 'showRanking'])->name('dashboard');
Route::get('universitee/indexu', [UniversiteController::class, 'indexu'])->name('universite.indexu');
