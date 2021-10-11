<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\TodoCtrl;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/todo')->group(function(){
    Route::get('/', [TodoCtrl::class, 'index']);
    Route::get('/{id}/edit', [TodoCtrl::class, 'edit']);
    Route::post('/', [TodoCtrl::class, 'store']);
    Route::match(['patch', 'put'], '/{id}', [TodoCtrl::class, 'update']);
    Route::delete('/{id}', [TodoCtrl::class, 'destroy']);
});
