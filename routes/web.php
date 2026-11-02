<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\AppointmentSlotController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.submit');

Route::get('/dashboard', [App\Http\Controllers\AppointmentController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');
    

// View appointments
Route::get('/appointments', [AppointmentController::class, 'index'])
    ->middleware('auth')
    ->name('appointments.index');

// Show appointment booking form
Route::get('/appointments/create', [AppointmentController::class, 'create'])
    ->middleware('auth')
    ->name('appointments.create');

// Save appointment
Route::post('/appointments', [AppointmentController::class, 'store'])
    ->middleware('auth')
    ->name('appointments.store');

// Approve appointment
Route::patch('/appointments/{appointment}/approve', [AppointmentController::class, 'approve'])
    ->middleware('auth')
    ->name('appointments.approve');

// Reject appointment
Route::patch('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])
    ->middleware('auth')
    ->name('appointments.reject');


Route::patch('/appointments/{appointment}/cancel',
    [AppointmentController::class, 'cancel']
)->middleware('auth')->name('appointments.cancel');

// Complete appointment
Route::patch('/appointments/{appointment}/complete', [AppointmentController::class, 'complete'])
    ->middleware('auth')
    ->name('appointments.complete');
Route::get('/admin/appointment-slots/{slot}/edit', [AppointmentSlotController::class, 'edit'])
    ->middleware('auth')
    ->name('admin.appointment-slots.edit');

Route::put('/admin/appointment-slots/{slot}', [AppointmentSlotController::class, 'update'])
    ->middleware('auth')
    ->name('admin.appointment-slots.update');


// Delete appointment
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])
    ->middleware('auth')
    ->name('appointments.destroy');
// Admin Appointment Slot Management
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // Display all appointment slots
    Route::get('/appointment-slots', [AppointmentSlotController::class, 'index'])
        ->name('appointment-slots.index');
    

    // Show create slot form
    Route::get('/appointment-slots/create', [AppointmentSlotController::class, 'create'])
        ->name('appointment-slots.create');

    // Save new appointment slot
    Route::post('/appointment-slots', [AppointmentSlotController::class, 'store'])
        ->name('appointment-slots.store');
    Route::patch('/appointment-slots/{slot}/toggle-status',[AppointmentSlotController::class, 'toggleStatus']) 
           ->name('appointment-slots.toggle-status');

});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
