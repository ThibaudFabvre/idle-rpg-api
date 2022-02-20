<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\FightController;
use App\Http\Controllers\NpcController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);


/**
 * Character routes
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('characters', [CharacterController::class, 'index']);
    Route::get('characters/{character}', [CharacterController::class, 'show']);
    Route::post('characters', [CharacterController::class, 'store']);
    Route::put('characters/{character}', [CharacterController::class, 'update']);
    Route::delete('characters/{character}', [CharacterController::class, 'destroy']);
});

/**
 * Npc routes
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('npc', [NpcController::class, 'index']);
    Route::get('npc/{npc}', [NpcController::class, 'show']);
    Route::post('npc', [NpcController::class, 'store']);
    Route::put('npc/{npc}', [NpcController::class, 'update']);
    Route::delete('npc/{npc}', [NpcController::class, 'destroy']);
});


/**
 * Fight routes
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('fights', [FightController::class, 'index']);
    Route::post('fights', [FightController::class, 'store']);
});
