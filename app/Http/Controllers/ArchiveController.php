<?php

namespace App\Http\Controllers;

use App\Models\archive;
use Illuminate\Http\Request;
use App\Models\Game;

class ArchiveController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'game_id' => 'required'
        ]);
        $game = Game::where('id', $validate['game_id'])->get();
        $archive = New archive();
        $archive->id = $game[0]->id;
        $archive->player1_id = $game[0]->player1_id; 
        $archive->player2_id = $game[0]->player2_id; 
        $archive->player1_score = $game[0]->player1_score; 
        $archive->player2_score = $game[0]->player2_score; 
        $archive->winner = $game[0]->winner;       
        $archive->created_at = $game[0]->created_at;
        $archive->serve = $game[0]->player_serve;
        $archive->save();
        $game[0]->delete();
        return redirect('/archive');
    }

    /**
     * Display the specified resource.
     */
    public function show(archive $archive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(archive $archive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, archive $archive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(archive $archive)
    {
        //
    }
}
