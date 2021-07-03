<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EvaluationController;

Route::get('/', function() {
    return response()->json(['msg' => 'App works!']);
});

Route::apiResource('/evaluations', EvaluationController::class)->only(['index', 'store']);
