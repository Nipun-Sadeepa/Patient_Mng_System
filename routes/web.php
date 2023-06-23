<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TestController;

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [PatientController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patient Routes
    Route::get('/patient/create', [PatientController::class, 'create']);
    Route::post('/patient', [PatientController::class, 'store']);
    Route::get('/patient/{id}', [PatientController::class, 'show']);
    Route::get('/patient/delete/{id}', [PatientController::class, 'delete']);
    Route::get('/search/{nic}', [PatientController::class, 'search']);

    //Prescription Routes
    Route::post('/prescription', [PrescriptionController::class, 'store']);

    // Payment Routes
    Route::get('/payment', [PaymentController::class, 'index']);
    Route::get('/payment/{date1}/{date2}', [PaymentController::class, 'showReport']);
});

require __DIR__ . '/auth.php';
