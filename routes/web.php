<?php

use App\Http\Controllers\DatasetController;
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
    return view('import');
})->name('import.form');
Route::get('/phpinfo', function () {
    return phpinfo();
});

Route::post('/import', [DatasetController::class, 'importCsv'])->name('import.csv');
Route::get('/import/reset-progress', [DatasetController::class, 'resetImportProgress'])->name('import.progress.reset');
Route::get('/dataset', [DatasetController::class, 'showDataset'])->name('dataset.index');
