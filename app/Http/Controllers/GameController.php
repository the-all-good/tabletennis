<?php

namespace App\Http\Controllers;

use App\Models\archive;
use App\Models\Game;
use App\Models\player;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isEmpty;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = $request->validate([
            'player1' => 'required|min:3|max:16',
            'player2' => 'required|min:3|max:16|different:player1',
            'score1' => 'required|min:0',
            'score2' => 'required|min:0',
            'player_serve' => ['required', Rule::in([$request['player1'], $request['player2']])],
        ]);
        $players = [strtolower($validate['player1']), strtolower($validate['player2'])];
        foreach($players as $player){
            if(!player::where('name', $player)->exists()){
                $create = new player();
                $create->name = $player;
                $create->save();
            }
            $existing = player::where('name', $player)->get();
            $playerIds[] = $existing[0];
        }
        $player1 = player::where('name', $playerIds[0]->name)->get();
        $player2 = player::where('name', $playerIds[1]->name)->get();
        $game = new Game();
        $game->player1_id = $player1[0]->id;
        $game->player2_id = $player2[0]->id;
        $game->player1_score = $validate['score1'];
        $game->player2_score = $validate['score2'];
        ($validate['score1'] > $validate['score2']) ? $game->winner = $player1[0]->id : $game->winner = $player2[0]->id;
        ($player1[0]->name === strtolower($validate['player_serve'])) ? $game->player_serve = $player1[0]->id : $game->player_serve = $player2[0]->id;
        $game->save();
        return redirect('/');
    }
   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'game_id' => 'required'
        ]);
        $game = archive::where('id', $validate['game_id'])->get();
        $archive = New Game();
        $archive->id = $game[0]->id;
        $archive->player1_id = $game[0]->player1_id; 
        $archive->player2_id = $game[0]->player2_id; 
        $archive->player1_score = $game[0]->player1_score; 
        $archive->player2_score = $game[0]->player2_score; 
        $archive->winner = $game[0]->winner;       
        $archive->created_at = $game[0]->created_at;
        $archive->player_serve = $game[0]->serve;
        $archive->save();
        $game[0]->delete();
        return redirect('/games');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }
}
