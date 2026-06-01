<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientiController;
use App\Http\Controllers\ScadenzeController;
use App\Http\Controllers\DominiController;
use App\Http\Controllers\CredenzialiController;
use App\Http\Controllers\TipologieController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FatturazioneController;
use App\Http\Controllers\ProgettiController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// App (protetta da auth)
Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Clienti
    Route::resource('clienti', ClientiController::class)->parameters(['clienti' => 'cliente']);

    // Scadenze
    Route::post('scadenze/{scadenza}/rinnova', [ScadenzeController::class, 'rinnova'])->name('scadenze.rinnova');
    Route::resource('scadenze', ScadenzeController::class)->except(['show'])->parameters(['scadenze' => 'scadenza']);

    // Domini
    Route::resource('domini', DominiController::class)->except(['show'])->parameters(['domini' => 'dominio']);

    // Credenziali
    Route::get('credenziali/{credenziale}/password', [CredenzialiController::class, 'mostraPassword'])->name('credenziali.password');
    Route::resource('credenziali', CredenzialiController::class)->except(['show'])->parameters(['credenziali' => 'credenziale']);

    // Tipologie (Impostazioni)
    Route::resource('tipologie', TipologieController::class)->except(['show', 'create', 'edit'])->parameters(['tipologie' => 'tipologia']);

    // Fatturazione
    Route::get('fatturazione', [FatturazioneController::class, 'index'])->name('fatturazione.index');

    // Progetti
    Route::resource('progetti', ProgettiController::class)->parameters(['progetti' => 'progetto']);
    Route::post('progetti/{progetto}/rate',                    [ProgettiController::class, 'storeRata'])->name('progetti.rate.store');
    Route::patch('progetti/{progetto}/rate/{rata}',            [ProgettiController::class, 'updateRata'])->name('progetti.rate.update');
    Route::delete('progetti/{progetto}/rate/{rata}',           [ProgettiController::class, 'destroyRata'])->name('progetti.rate.destroy');
    Route::post('progetti/{progetto}/step',                    [ProgettiController::class, 'storeStep'])->name('progetti.step.store');
    Route::patch('progetti/{progetto}/step/{step}',            [ProgettiController::class, 'updateStep'])->name('progetti.step.update');
    Route::delete('progetti/{progetto}/step/{step}',           [ProgettiController::class, 'destroyStep'])->name('progetti.step.destroy');

    // Export
    Route::get('export/clienti',      [ExportController::class, 'clienti'])->name('export.clienti');
    Route::get('export/scadenze',     [ExportController::class, 'scadenze'])->name('export.scadenze');
    Route::get('export/fatturazione', [ExportController::class, 'fatturazione'])->name('export.fatturazione');
});
