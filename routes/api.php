<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AeroportController;
use App\Http\Controllers\VolController;
use App\Http\Controllers\PassagerController;
use App\Http\Controllers\AvionController;
use App\Http\Controllers\ReservationController;

Route::middleware('api')->group(function () {

    Route::resource('aeroports', AeroportController::class);
    Route::resource('vols', VolController::class);
    Route::resource('passagers', PassagerController::class);
    Route::resource('avions', AvionController::class);
    Route::resource('reservations', ReservationController::class);
    Route::get('pagivate_search', [VolController::class, 'pagivate_search']);
    Route::get('/historique-reservations/{email}', [ReservationController::class, 'getHistoriqueReservationsByEmail']);
});
