<?php
    require(resource_path('views').'/header.blade.php');
?>
  
  <main class="container mx-auto py-8">
    <table class="min-w-full border rounded-lg overflow-hidden">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4 text-left">Game ID</th>
          <th class="py-2 px-4 text-left">Player 1</th>
          <th class="py-2 px-4 text-left">Player 1 Score</th>
          <th class="py-2 px-4 text-left">Winner</th>
          <th class="py-2 px-4 text-left">Player 2 Score</th>
          <th class="py-2 px-4 text-left">Player 2</th>
          <th class="py-2 px-4 text-left">Date Added</th>
          <th class="py-2 px-4 text-left">Archive</th>
        </tr>
      </thead>
      <tbody class="bg-white">
        <?php //dd($games)?>
        @foreach ($games as $game)
        <tr>
        <form action="/games" method="POST">
            @csrf
            <td class="py-2 px-4">{{ $game['id']}}</td>
            <td class="py-2 px-4">{{ ucwords($game['player1_id'])}}</td>
            <td class="py-2 px-4">{{ $game['player1_score']}}</td>
            <td class="py-2 px-4">{{ ucwords($game['winner'])}}</td>
            <td class="py-2 px-4">{{ $game['player2_score']}}</td>
            <td class="py-2 px-4">{{ ucwords($game['player2_id'])}}</td>
            <td class="py-2 px-4">{{ $game['created_at']}}</td>
            <td class="py-2 px-4">
                <input type="hidden" name="game_id" value="<?php echo $game['id'];?>">     
                <input type="submit" value="Unarchive" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-full shadow-lg focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
            </td>
        </form>
        </tr>
        @endforeach
        <!-- Add more rows as needed -->

      </tbody>
    </table>
  </main>
</body>
</html>