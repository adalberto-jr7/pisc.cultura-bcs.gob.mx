<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/app');

Auth::routes(['register' => false]);