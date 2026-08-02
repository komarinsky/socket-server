<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::patch('/items/{item}', [ItemController::class, 'update'])->name('items.update');
