<?php

use App\Http\Controllers\Api\{
    EvaluationController
};
use Illuminate\Support\Facades\Route;

Route::get('/evaluations/{company}', [EvaluationController::class, 'index']);
Route::post('/evaluations/{company}', [EvaluationController::class, 'store']);

Route::get('/', function () {
    return response()->json(['message' => 'success']);
});