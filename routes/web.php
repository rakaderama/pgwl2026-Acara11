<?php
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PolylinesController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'landingpage'])->name('home');

Route::get('/peta', [PageController::class, 'peta'])
->middleware(['auth', 'verified'])
->name('peta');

Route::get('/tabel', [PageController::class, 'tabel'])->name('tabel');

//Points
Route::post('/store-points', [\App\Http\Controllers\PointsController::class, 'store'])->name('points.store');

//Route untuk menghapus point berdasarkan ID
Route::delete('/delete-points/{id}', [PointsController::class, 'destroy'])->name('points.delete');

//Route untuk edit point berdasarkan ID
Route::get('/edit-points/{id}', [PointsController::class, 'edit'])->name('points.edit');

//Route untuk update point berdasarkan ID
Route::patch('/update-points/{id}', [PointsController::class, 'update'])->name('points.update');

//Polylines
Route::post('/store-polylines', [\App\Http\Controllers\PolylinesController::class, 'store'])->name('polylines.store');

//Route untuk menghapus polyline berdasarkan ID
Route::delete('/delete-polylines/{id}', [PolylinesController::class, 'destroy'])->name('polylines.delete');

//Route untuk edit polyline berdasarkan ID
Route::get('/edit-polylines/{id}', [PolylinesController::class, 'edit'])->name('polylines.edit');

//Route untuk update polyline berdasarkan ID
Route::patch('/update-polylines/{id}', [PolylinesController::class, 'update'])->name('polylines.update');


//Polygons
Route::post('/store-polygons', [\App\Http\Controllers\PolygonsController::class, 'store'])->name('polygons.store');

//Route untuk menghapus polygon berdasarkan ID
Route::delete('/delete-polygons/{id}', [PolygonsController::class, 'destroy'])->name('polygons.delete');

//Route untuk edit polygon berdasarkan ID
Route::get('/edit-polygons/{id}', [PolygonsController::class, 'edit'])->name('polygons.edit');

//Route untuk update polygon berdasarkan ID
Route::patch('/update-polygons/{id}', [PolygonsController::class, 'update'])->name('polygons.update');



Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
