<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\TituloController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\PeriodicoController;
use App\Http\Controllers\DashboardController;
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
    return Auth::check() ? redirect()->route('dashboard') : view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Reservas de Títulos e Periódicos
Route::post('/reservar-titulo/{titulo}', [DashboardController::class, 'reservarTitulo'])->name('reservar.titulo')->middleware('auth');
Route::post('/reservar-periodico/{titulo}', [DashboardController::class, 'reservarPeriodico'])->name('reservar.periodico')->middleware('auth');
Route::post('/tornar-publico/{titulo}', [DashboardController::class, 'tornarPublico'])->name('tornar.publico')->middleware('auth');

// Rotas para Disciplinas
Route::post('/disciplinas/store', [DisciplinaController::class, 'store'])->name('disciplinas.store');
Route::get('/minhas-disciplinas', [DisciplinaController::class, 'index'])->name('disciplinas.index');

Route::get('/disciplinas/{disciplina}/edit', [DisciplinaController::class, 'edit'])->name('disciplinas.edit');

// Títulos
Route::get('/titulos', [TituloController::class, 'index'])->name('titulos.index');
Route::post('/titulos', [TituloController::class, 'store'])->name('titulos.store');

Route::get('/titulos/create', [TituloController::class, 'create'])->name('titulos.create');

Route::get('/titulos/{titulo}/edit', [TituloController::class, 'edit'])->name('titulos.edit');
Route::put('/titulos/{titulo}', [TituloController::class, 'update'])->name('titulos.update');

Route::delete('/titulos/{titulo}', [TituloController::class, 'destroy'])->name('titulos.destroy');

// Rota para Empréstimos
Route::get('/emprestimos', [EmprestimoController::class, 'index'])->name('emprestimos.index');
Route::resource('emprestimos', EmprestimoController::class);

Route::post('/emprestimos/devolver/{id}', [EmprestimoController::class, 'devolver'])->name('emprestimos.devolver');

// Rotas para Periódicos
Route::resource('periodicos', PeriodicoController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
