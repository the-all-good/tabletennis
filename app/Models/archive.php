<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\player;

class archive extends Model
{
    use HasFactory;
    protected $table = 'archives';
    public static function playerStats(){
        $games = archive::all();
        foreach($games as $game){
            $player1_name = Player::where('id', $game->player1_id)->get('name');
            $game->player1_id = $player1_name[0]->name;
            $player2_name = Player::where('id', $game->player2_id)->get('name');
            $game->player2_id = $player2_name[0]->name;
            ($game->player1_score > $game->player2_score) ? $game->winner = $player1_name[0]->name : $game->winner = $player2_name[0]->name;
        }
        return $games;
    }
}
