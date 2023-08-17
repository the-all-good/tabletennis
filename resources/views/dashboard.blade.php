<?php
    require(resource_path('views').'/header.blade.php');
?>
  
  <main class="container mx-auto py-8">
    <table class="table-fixed min-w-full border rounded-lg overflow-hidden">
      <thead class="bg-gray-200">
        <tr class="even:bg-slate-50 odd:bg-white border-spacing-1">
          <th class="py-2 px-4 text-center">Name</th>
          <th class="py-2 px-4 text-center">Wins</th>
          <th class="py-2 px-4 text-center">Points</th>
          <th class="py-2 px-4 text-center">Games Played</th>
          <th class="py-2 px-4 text-center">Win Rate</th>
        </tr>
      </thead>
      <tbody class="bg-white">
        <?php $counter = 0;?>
        @foreach ($stats as $key =>$player)
        @if($counter % 2 === 0)
          <tr class="bg-white">
          <?php $counter++;?>
        @else
          <tr class="bg-gray-200">
          <?php $counter++;?>
        @endif
          <td class="py-2 px-4 text-center divide-x-2">{{ ucwords($player['name'])}}</td>
          <td class="py-2 px-4 text-center divide-x-2">{{ $player['wins']}}</td>
          <td class="py-2 px-4 text-center divide-x-2">{{ $player['points']}}</td>
          <td class="py-2 px-4 text-center divide-x-2">{{ $player['games']}}</td>
          <td class="py-2 px-4 text-center divide-x-2">{{ $player['winrate']}}</td>
        </tr>
        @endforeach
        <!-- Add more rows as needed -->

      </tbody>
    </table>
    <div class="container mx-auto flex justify-end center items-end py-3">
        <button class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-full shadow-lg focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
            <a href="/game">Add Game</a>
        </button>
    </div>
  </main>
</body>
</html>