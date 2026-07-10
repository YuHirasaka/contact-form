<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactApiController;

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

/*
|--------------------------------------------------------------------------
| お問い合わせ API（React から呼び出す）
|--------------------------------------------------------------------------
|
| web.php のルートとは別物です。
| - URL は /api/... で始まる（RouteServiceProvider で prefix が付く）
| - middleware は 'api'（CSRF なし・セッションなし）
| - レスポンスはすべて JSON
|
*/
Route::get('/categories', [ContactApiController::class, 'categories']);
Route::post('/contacts', [ContactApiController::class, 'store']);
