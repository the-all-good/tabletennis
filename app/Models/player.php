<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class player extends Model
{
    use HasFactory;
    public static function playerStats(){
        $playerStats = [];
        $players = player::all();
        foreach($players as $player){
            $wins = Game::where('winner', $player->id)
                        ->count();
            $games = Game::where('player1_id', $player->id)
                        ->orWhere('player2_id', $player->id)
                        ->count();
            $points1 = Game::where('player1_id', $player->id)
                        ->sum('player1_score');
            $points2 = Game::where('player2_id', $player->id)
                        ->sum('player2_score');
            $points = $points1 + $points2;
            if($games > 0){
            $winrate = round(($wins / $games) * 100, 2);
            }else{
                $winrate = 0;
            }
            $playerStats[] = [
                'name' => $player->name,
                'wins' => $wins,
                'games'=> $games,
                'points' => $points,
                'winrate' => $winrate    
            ];
        }
        return $playerStats;
    }
}
