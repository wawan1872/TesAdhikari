<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('contents', [ContentController::class, 'index']);
    Route::post('contents', [ContentController::class, 'store']);
    Route::put('contents/{id}', [ContentController::class, 'update']);
    Route::delete('contents/{id}', [ContentController::class, 'destroy']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
});
?>