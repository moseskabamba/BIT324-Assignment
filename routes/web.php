<?php

use App\Http\Livewire\CartComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ProductComponent;
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

Route::get('/', HomeComponent::class)->name('home');

Route::middleware(['auth:sanctum', 'verified'])->group(
    function () {
        Route::get(
            '/dashboard',
            function () {
                return view('dashboard');
            })->name('dashboard');

        Route::get('/products', ProductComponent::class)->name('product-index');

        Route::get('/cart', CartComponent::class)->name('cart');
    }
);

// Route::middleware(['auth::sanctum', 'verified'])->get('')
