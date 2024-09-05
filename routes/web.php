<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes(['register' => false]);

Route::get('/admin/dashboard', function () {
    if (Gate::allows('isAdmin')) {
        return view('dashboard');
    } else {
        return "Not Authorized";
    }
})->middleware('auth');
