<?php

use App\Http\Controllers\GigController;
use App\Http\Controllers\ProfileController;
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

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/finder', [GigController::class, 'index'])->name('musician-finder.dashboard');
    Route::resource('/gigs', GigController::class)->except('index');
    Route::post('/applyToJob/{job}', [GigController::class, 'applyToJob'])->name('applyToJob');
    Route::post('/removeApp/{job}', [GigController::class, 'removeApp'])->name('removeApp');
    Route::get('/applyToJob', [GigController::class, 'applyToJobGet'])->name('applyToJobGet');
    Route::get('/bookJob', [GigController::class, 'bookJobGet'])->name('bookJobGet');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/new-job-component', function () {
        $number = request()->query('number', 1);
        $payment = request()->query('payment', '');

        $data = array_filter([
            'musicianNumber' => $number,
            'payment' => $payment,
        ]);

        return view('components.finder-components.new-job', $data)->render();
    });

    Route::get('/edit-job-component', function () {
        $number = request()->query('number', 1);
        $payment = request()->query('payment', '');

        $data = array_filter([
            'musicianNumber' => $number - 1,
            'payment' => $payment,
        ]);

        return view('components.finder-components.edit-job', $data)->render();
    });

    Route::fallback(function () {
        return redirect('/dashboard');
    });
});

require __DIR__.'/auth.php';
