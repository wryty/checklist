<?php

use App\Http\Controllers\GithubController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChecklistController;
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
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard', [ChecklistController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('auth/github', [GitHubController::class, 'redirect'])->name('github.login');
Route::get('auth/github/callback', [GitHubController::class, 'callback']);

Route::middleware(['auth'])->group(function () {
    Route::get('/checklists/create', [ChecklistController::class, 'create'])->name('checklists.create');
    Route::post('/checklists', [ChecklistController::class, 'store'])->name('checklists.store');
    Route::get('/checklists/{id}', [ChecklistController::class, 'show'])->name('checklists.show');
    Route::post('/checklists/{id}/toggle', [ChecklistController::class, 'toggleItem'])->name('checklists.toggleItem');
    Route::post('/checklists/{id}/items', [ChecklistController::class, 'storeItem'])->name('checklists.items.store');
    Route::delete('/checklists/{id}', [ChecklistController::class, 'destroy'])->name('checklists.destroy');
    Route::delete('/checklists/{checklistId}/items/{itemId}', [ChecklistController::class, 'destroyItem'])->name('checklists.items.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/checklists/{checklistId}/items/{itemId}', [ChecklistController::class, 'showItem'])->name('checklists.items.show');

    Route::post('/checklists/{checklistId}/items/{itemId}/subitems/{subitemId}/toggle', [ChecklistController::class, 'toggleSubitem'])->name('checklists.items.subitems.toggle');

    Route::post('/checklists/{checklistId}/items/{itemId}/subitems', [ChecklistController::class, 'storeSubitem'])->name('checklists.items.subitems.store');

    Route::delete('/checklists/{checklistId}/items/{itemId}/subitems/{subitemId}', [ChecklistController::class, 'destroySubitem'])->name('checklists.items.subitems.destroy');
});


require __DIR__.'/auth.php';
