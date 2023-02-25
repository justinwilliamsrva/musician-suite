<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GigController;
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
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/finder', [GigController::class, 'index'])->name('musician-finder.dashboard');
    Route::resource('/gigs', GigController::class)->except('index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


    Route::get('/new-job-component', function () {
        $number = request()->query('number', 1);
        $data = [
          'musicianNumber' => $number,
        ];
        return view('components.finder-components.new-job', $data)->render();
      });
Route::fallback(function () {
    return redirect('/dashboard');
});

require __DIR__.'/auth.php';
