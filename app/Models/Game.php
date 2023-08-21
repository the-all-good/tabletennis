<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\player;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

use function PHPUnit\Framework\isEmpty;

class Game extends Model
{
    use HasFactory;
    public static function playerStats(){
        $games = Game::all();
        foreach($games as $game){
            $player1_name = Player::where('id', $game->player1_id)->get('name');
            $game->player1_id = $player1_name[0]->name;
            $player2_name = Player::where('id', $game->player2_id)->get('name');
            $game->player2_id = $player2_name[0]->name;
            if($game->player1_score > $game->player2_score){
                $game->winner = $player1_name[0]->name;
            }else{
                $game->winner = $player2_name[0]->name;
            }
        }
        $games = collect($games)->sortBy('game_id')->reverse()->toArray();
        return $games;
    }
    public static function profileStats($profile){
        $profile = strtolower($profile);
        $user_exists = Player::first()->where('name', $profile)->get();
        if($user_exists->contains('name', $profile) == false){
            return redirect('/profile')->with('status', 'User does not exist!');
        }
        $user = $user_exists[0];
        $games = Game::where('player1_id', $user->id)
                     ->orWhere('player2_id', $user->id)
                     ->get();
        $user->serves = 0;
        $user->win_on_serve = 0;
        $user->win_on_recieve = 0;
        $user->wins = 0;
        $user->closegame = 0;
        $user->blowout = 0;
        $user->games = $games->count();
        foreach ($games as $game){
            #winning serve
            if($game->player_serve == $user->id){
                $user->serves++;
            }
            if($game->player1_score + $game->player2_score > 40){
                $winningserver = floor(($game->player1_score + $game->player2_score -40) / 2) %2;
            }else{
                $winningserver = floor(($game->player1_score + $game->player2_score) / 5) %2;
            }
            if($game->player1_id == $game->player_serve){
                $starting_serve = $game->player1_id;
            }else{
                $starting_serve = $game->player2_id;
            }
            if($user->id == $game->winner && $winningserver == 0){
            # wins on serve
                $user->win_on_serve++;
            }
            if($user->id == $game->winner && $winningserver == 1){
            # wins receiving serve
                $user->win_on_recieve++;
            }
            #wins
            if($user->id == $game->winner){
                $user->wins += +1;
            }
            #points
            if($user->id == $game->player1_id){
                $user->points += $game->player1_score;
                $user->lostpoints += $game->player2_score;
            }
            if($user->id == $game->player2_id){
                $user->points += $game->player2_score;
                $user->lostpoints += $game->player1_score;
            }
            # number of close games
            if(abs($game->player1_score - $game->player2_score) < 4 && $user->id == $game->winner){
                $user->closegame += 1;
            }
            # number of blowouts
            if(abs($game->player1_score - $game->player2_score) >= 10 && $user->id == $game->winner){
                $user->blowout += 1;
            }
            # total starting serves
            if($user->id == $game->serve){
                $user->serves += 1;
            }
        }
        # win %
        $user->winrate = round(($user->wins / $user->games)*100, 2);
        #point %
        $user->pointrate = round(($user->points / ($user->lostpoints + $user->points))*100, 2);
        # % of starting serves
        $user->starting_serve_rate = round(($user->serves / $user->games)*100, 2);
        $user->winning_serve_rate = round(($user->win_on_recieve / $user->games)*100, 2);
        return $user;
        # weakest opponent
        # strongest opponent
    }
    public static function dateData($date, $page){
        if(!in_array(strtolower($date), ['weekly', 'monthly'])){
            $data = array(
                'status' => 'Please select a valid timeframe!'
            );
            return view('/games')->with($data);
        }
        $page = abs($page);
        $time = CarbonImmutable::now()->locale('Australia');
        if($date === 'weekly'){
            $startOfPeriod = $time->subWeeks($page)->startOfWeek()->format('Y-m-d');
            $endOfPeriod = $time->subWeeks($page)->endOfWeek()->format('Y-m-d');
        }else{
            $startOfPeriod = $time->subMonths($page)->startOfMonth()->format('Y-m-d');
            $endOfPeriod = $time->subMonths($page)->endOfMonth()->format('Y-m-d');
        }
        $weeklyGames = Game::where('created_at', '>=', $startOfPeriod)
                            ->where('created_at', '<=', $endOfPeriod)
                            ->get();
        foreach($weeklyGames as $game){
            $player1_name = Player::where('id', $game->player1_id)->get('name');
            $game->player1_id = $player1_name[0]->name;
            $player2_name = Player::where('id', $game->player2_id)->get('name');
            $game->player2_id = $player2_name[0]->name;
            if($game->player1_score > $game->player2_score){
                $game->winner = $player1_name[0]->name;
            }else{
                $game->winner = $player2_name[0]->name;
            }
        }
        $weeklyGames = collect($weeklyGames)->sortBy('game_id')->reverse()->toArray();
        return $weeklyGames;
    }
}
    