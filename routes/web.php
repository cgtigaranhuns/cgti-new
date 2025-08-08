<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProcessoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InformeController as AdminInformeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rotas Públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/apresentacao', [HomeController::class, 'apresentacao'])->name('apresentacao');
Route::get('/contato', [HomeController::class, 'contato'])->name('contato');
Route::post('/contato', [HomeController::class, 'enviarContato'])->name('contato.enviar');

// Informes
Route::get('/informes', [InformeController::class, 'index'])->name('informes.index');
Route::get('/informes/{informe:slug}', [InformeController::class, 'show'])->name('informes.show');

// Equipe
Route::get('/equipe', [EquipeController::class, 'index'])->name('equipe.index');

// Documentos
Route::get('/documentos', [DocumentoController::class, 'index'])->name('documentos.index');
Route::get('/documentos/{documento}', [DocumentoController::class, 'show'])->name('documentos.show');
Route::get('/documentos/{documento}/download', [DocumentoController::class, 'download'])->name('documentos.download');

// Processos
Route::get('/processos', [ProcessoController::class, 'index'])->name('processos.index');
Route::get('/processos/{processo}', [ProcessoController::class, 'show'])->name('processos.show');
Route::get('/processos/{processo}/download', [ProcessoController::class, 'download'])->name('processos.download');

// Autenticação
Auth::routes(['register' => false]);

// Área Administrativa (protegida por middleware auth e admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Informes
    Route::resource('informes', AdminInformeController::class)->except(['show']);
    
    // Documentos
    Route::resource('documentos', DocumentoController::class)->except(['show']);
    
    // Processos
    Route::resource('processos', ProcessoController::class)->except(['show']);
    
    // Equipe
    Route::resource('equipe', EquipeController::class)->except(['show']);
});

// Redirecionamento após login
Route::get('/home', function () {
    if (auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->middleware('auth')->name('dashboard');

