<?php

use App\Models\TextContent;
use Dom\Text;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TextContentController;
use Illuminate\Http\Request;


Route::get('/health', function () {
	return response()->json(['status' => 'ok']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
	
	Route::get('text-content', [TextContentController::class, 'show'])
		->middleware('verify.role:role:reader|role:writer');
	
	Route::post('text-content', [TextContentController::class, 'update'])
		->middleware('verify.role:role:writer');	
});