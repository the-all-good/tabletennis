<?php
    require(resource_path('views').'/header.blade.php');
?>
@if ($errors->any())
  <div class="alert alert-danger bg-red-500 border-l-4 border-red-700 text-white p-4">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
  <body class="bg-gray-100 flex justify-center items-center h-screen">
  <div class="w-full md:w-1/2 sm:mx-auto bg-white p-8  rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold mb-4">Player Information</h2>
    <form action="/game" method="POST">
    @csrf
      <div class="mb-4">
        <label for="player1" class="block font-semibold">Player 1</label>
        <input list="players" type="text" id="player1" name="player1" class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:ring-opacity-50" required>
        <datalist id="players">
        @foreach ($players as $player)
          <option value="<?php echo ucwords($player['name']);?>"></option>
        @endforeach
        </datalist>
      </div>
      <div class="mb-4">
        <label for="score1" class="block font-semibold">Player 1 Score</label>
        <input type="number" id="score1" name="score1" min="0" class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:ring-opacity-50" required>
      </div>
      <div class="mb-4">
        <label for="player2" class="block font-semibold">Player 2</label>
        <input list="players" type="text" id="player2" name="player2" class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:ring-opacity-50" required>
        <datalist id="players">
        @foreach ($players as $player)
          <option value="<?php echo ucwords($player['name']);?>">{{$player['name']}}</option>
        @endforeach
        </datalist>
      </div>
      <div class="mb-4">
        <label for="score2" class="block font-semibold">Player 2 Score</label>
        <input type="number" id="score2" name="score2" min="0" class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:ring-opacity-50" required>
      </div>
      <div class="mb-4">
        <label for="player_serve" class="block font-semibold">Player starting serve</label>
        <input list="servers" type="text" id="player_serve" name="player_serve" class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:ring-opacity-50" required>
        <datalist id="servers">
          <option value="" id="server1"></option>
          <option value="" id="server2"></option>
      </div>
      <input type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
    </form>
  </div>

  <script>
    const player1 = document.getElementById('player1');
    const player2 = document.getElementById('player2');
    const serve1 = document.getElementById('server1');
    const serve2 = document.getElementById('server2');
    console.log(player1.value);
    player1.addEventListener('change', () => {
      serve1.value = player1.value;
    });
    player2.addEventListener('change', () => {
      serve2.value = player2.value;
    });
    
  </script>
</body>
</html>