<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\player;
use App\Models\Game;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/', function () {
    $players = player::playerStats();
    $players = collect($players)->sortBy('winrate')->reverse()->toArray();
    return json_encode($players);
});
Route::get('/games', function(){
    return json_encode(Game::playerStats());
});
Route::get('/profile/{profile}', function($profile){
    return json_encode(Game::profileStats($profile));
});