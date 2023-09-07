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
            $winrate = ($games > 0) ? round(($wins / $games) * 100, 2) : $winrate = 0;
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
    public static function vsOpponent(string $name){
        $player = player::where('name', $name)->get()->first();
        
        $allGames = Game::where('player1_id', $player['id'])
                        ->orWhere('player2_id', $player['id'])
                        ->get();
        foreach($allGames as $games){
            if($player['id'] === $games['player1_id']){
                $opponents[$games['player2_id']]['games'][] = $games;
            }else{
                $opponents[$games['player1_id']]['games'][] = $games;
            }
        }

        foreach($opponents as $id => $opponentData){
            //  $opponent = collection player[name, id] and can add any details needed for return
            //  $opponentData = collection of all games vs opponent to get stats from
            $opponent = player::where('id', $id)->get(['id', 'name'])->first();
            $opponent->wins = 0;
            $opponent->losses = 0;
            $opponent->points = 0;
            $opponent->lostPoints = 0;
            $opponent->outlierCount = 0;
            $opponent->lastupset = 0;
            $opponent->upset = 0;
            $opponent->matches = array_reverse($opponents[$opponent->id]['games']);
            $opponent->games = count($opponentData['games']);
            foreach($opponentData['games'] as $game){
                if($player['id'] === $game['winner']){
                    $opponent->wins += 1;
                    $opponent->outlierCount += 1;
                }else{
                    if($opponent->outlierCount >= 5){
                        $opponent->upset += 1;
                        $opponent->lastupset = $opponent->outlierCount;
                    }
                    $opponent->outlierCount = 0;
                }
                if($player['id'] === $game['player1_id']){
                    $opponent->points += $game['player1_score'];
                    $opponent->lostPoints += $game['player2_score'];
                }else{
                    $opponent->points += $game['player2_score'];
                    $opponent->lostPoints += $game['player1_score'];
                }
            }
            $opponent->losses = $opponent->games - $opponent->wins;
            $opponent->winrate = round(($opponent->wins / $opponent->games) * 100, 2);
            $opponent->pointRate = round(($opponent->points / ($opponent->points + $opponent->lostPoints)) * 100, 2);
            $opponent->avgPoints = $opponent->points / $opponent->games;
            $finalResult[] = $opponent;
        }
        $finalResult = collect($finalResult)->sortBy('games')->reverse()->toArray();
        return $finalResult;
    }
}
