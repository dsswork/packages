<?php

use App\Http\Controllers\Web as Web;
use Illuminate\Support\Facades\Route;

Route::get('/', [Web\DocumentController::class, 'index']);
