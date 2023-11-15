<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\EnfermeraController;
use App\Http\Controllers\Admin\PacienteController;
use App\Http\Controllers\ReportesController;



Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->group(function () {
   // Las rutas relacionadas
   Route::resource('specialties', SpecialtyController::class);
   //Rutas enfermera
   Route::resource('enfermera', EnfermeraController::class);
   //Rutas paciente
   Route::resource('paciente', PacienteController::class);

    //Rutas Reportes


    Route::get('/reportes/citas/line', [App\Http\Controllers\admin\ChartController::class, 'appointments']);
    Route::get('/reportes/enfermeras/column', [App\Http\Controllers\admin\ChartController::class, 'enfermeras']);

    Route::get('/reportes/enfermeras/column/data', [App\Http\Controllers\admin\ChartController::class, 'enfermerasJson']);

    Route::post('/fcm/send', [App\Http\Controllers\admin\FirebaseController::class, 'sendAll']);
});

Route::middleware(['auth', 'enfermera'])->group(function () {
    Route::get('/horario', [App\Http\Controllers\enfermera\HorarioController::class, 'edit']);
    Route::post('/horario', [App\Http\Controllers\enfermera\HorarioController::class, 'store']);

});

Route::middleware('auth')->group(function(){

    Route::get('/reservarcitas/create', [App\Http\Controllers\AppointmentController::class, 'create']);
    Route::post('/reservarcitas', [App\Http\Controllers\AppointmentController::class, 'store']);
    Route::get('/miscitas', [App\Http\Controllers\AppointmentController::class, 'index']);
    Route::get('/miscitas/{appointment}', [App\Http\Controllers\AppointmentController::class, 'show']);
    Route::post('/miscitas/{appointment}/cancel', [App\Http\Controllers\AppointmentController::class, 'cancel']);
    Route::post('/miscitas/{appointment}/confirm', [App\Http\Controllers\AppointmentController::class, 'confirm']);

    Route::get('/miscitas/{appointment}/cancel', [App\Http\Controllers\AppointmentController::class, 'formCancel']);

    Route::get('/profile', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/profile', [App\Http\Controllers\UserController::class, 'update']);
    Route::get('/reportes/citas/general', [App\Http\Controllers\AppointmentController::class, 'generarReporte']);

    Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
    Route::get('/reports/pdf', [ReportesController::class, 'pdf'])->name('reports.pdf');



});
