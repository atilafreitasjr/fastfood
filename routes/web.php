<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\EntradaVeiculo;
use App\Livewire\SaidaVeiculo;
use App\Livewire\RelatorioVeiculo;
use App\Livewire\Mensagens;
use App\Livewire\Notificacoes;
use App\Http\Controllers\CarController;
use App\Livewire\Parking\ParkingIndex;
use App\Livewire\Parking\ParkingCreate;
use App\Livewire\Parking\ParkingEdit;

Route::view('/', 'welcome');

// Parking
Route::prefix('parking')->name('parking.')->group(function () {
    Route::get('/', ParkingIndex::class)->name('index');
    Route::get('/create', ParkingCreate::class)->name('create');
    Route::get('/{id}/edit', ParkingEdit::class)->name('edit');
    Route::delete('/{parking}', [ParkingIndex::class, 'destroy'])->name('destroy');
    Route::get('/{parking}', [ParkingIndex::class, 'show'])->name('show');
});

//car
Route::get('/car', [CarController::class, 'index'])->name('car.index');
Route::get('/car/create', [CarController::class, 'create'])->name('car.create');
Route::post('/car/list', [CarController::class, 'store'])->name('car.store');
Route::get('/car/{car}/edit', [CarController::class, 'edit'])->name('car.edit');
Route::put('/car/{car}', [CarController::class, 'update'])->name('car.update');
Route::delete('/car/{car}', [CarController::class, 'destroy'])->name('car.destroy');
Route::get('/car/{car}', [CarController::class, 'show'])->name('car.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/entrada-veiculo', EntradaVeiculo::class)->name('entrada.veiculo');

Route::get('/saida-veiculo', SaidaVeiculo::class)->name('saida.veiculo');

// Relatório de veículos
Route::get('/relatorio-veiculo', RelatorioVeiculo::class)->name('relatorio.veiculo');

// Mensagens
Route::get('/mensagens', Mensagens::class)->name('mensagens');

// Notificações
Route::get('/notificacoes', Notificacoes::class)->name('notificacoes');

require __DIR__.'/auth.php';