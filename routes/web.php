<?php

use App\Http\Controllers\Project\TelegramIDController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::post('telegram/webhook', [TelegramIDController::class, 'webhook'])->name('telegram.webhook');
