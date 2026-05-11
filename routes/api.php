<?php

use App\Http\Controllers\Api\ClientCsvFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('imports')->group(function () {
    Route::post('/', [ClientCsvFileController::class, 'store']);
    Route::get('/{importJob}/duplicate-groups', [ClientCsvFileController::class, 'duplicatesInGroup']);
    Route::get('/duplicates', [ClientCsvFileController::class, 'duplicates']);
    Route::put('/clients/{id}', [ClientCsvFileController::class, 'update']);
    Route::get('/{importJob}/export',[ClientCsvFileController::class, 'export']);
});
