<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FpFloorpAdmController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/device')->group(function(){
   Route::get('/{id}', [FpFloorpAdmController::class, 'get']);
   Route::put('/{id}', [FpFloorpAdmController::class, 'update']);
   Route::post('/create', [FpFloorpAdmController::class, 'create']);
});
#Route::get('/device', [FpFloorpAdmController::class, 'deviceDetail']);