<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\archive;
use App\Models\Game;
use App\Models\player;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Profiler\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $players = player::playerStats();
    $players = collect($players)->sortBy('games')->sortBy('winrate')->reverse()->toArray();
    return view('dashboard', ['stats'=> $players]);
});
Route::get('/game', function(){
    return view('game', ['players' => player::all()]);
});
Route::get('/games', function(){
    return view('/games', ['games' => Game::playerStats()]);
});
Route::get('/games/{date}/{page?}', function($date, $page = 0){
    return view('/games', ['games' => Game::dateData($date, $page)]);
});
Route::get('/vs/{profile}/{opponent}', function($profile, $opponent){
    return view('/vs', ['games' => Game::vsOpponent($profile, $opponent)]);
});
Route::get('/archive', function(){
    return view('/archive', ['games' => archive::playerStats()]);
});
Route::post('/game', [GameController::class, 'create']);
Route::post('/archive', [ArchiveController::class, 'store']);
Route::post('/games', [GameController::class, 'store']);
Route::get('/profile', function(){
    return view('/profile');
});
Route::get('/profile/{profile}', function($profile){
    return view('/profile', [
        'profile' => Game::profileStats($profile),
        'opponentData' => player::vsOpponent($profile)
    ]);
});
Route::get('/import/{count}', function($count){
    return str_repeat("Im not that much of a cunt you evil bitch <br>", $count);
});