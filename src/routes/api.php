<?php

use Illuminate\Support\Facades\Route;
use Inador\Autenticador\Http\Controllers\AutenticadorController;

Route::post('autenticador/registrar',[AutenticadorController::class, 'registrar']);
Route::post('autenticador/login',[AutenticadorController::class, 'login']);
Route::middleware('auth:sanctum')->post('autenticador/logout',[AutenticadorController::class, 'logout']);

