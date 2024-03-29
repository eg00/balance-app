<?php

declare(strict_types=1);

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware('auth')->group(function (): void {
    Route::get('/', fn () => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/operations', [UserController::class, 'operations'])->name('operations');
});

require __DIR__ . '/auth.php';
