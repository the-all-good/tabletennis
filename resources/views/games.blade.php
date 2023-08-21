<?php
    require(resource_path('views').'/header.blade.php');
?>
  <div class="flex justify-center mt-8 p-4">
    <div class="flex items-center space-x-4">
      <a href="/games" class="text-gray-500 hover:text-gray-800 transition duration-300 ease-in-out">
        Alltime
      </a>
      <p>-</p>
      <a href="/games/weekly" class="text-gray-500 hover:text-gray-800 transition duration-300 ease-in-out">
        Weekly
      </a>
      <p>-</p>
      <a href="/games/monthly" class="text-gray-500 hover:text-gray-800 transition duration-300 ease-in-out">
        Monthly
      </a>
    </div>
  </div>
  @if (isset($status))
    <div class="alert alert-danger bg-red-500 border-l-4 border-red-700 text-white p-4">
      {{$status}}
    </div>
    {{exit()}}
  @endif
  <main class="container mx-auto py-2">
    <table class="min-w-full border rounded-lg overflow-hidden">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4 text-left">Game ID</th>
          <th class="py-2 px-4 text-left">Player 1</th>
          <th class="py-2 px-4 text-left">Player 1 Score</th>
          <th class="py-2 px-4 text-left">Player 2</th>
          <th class="py-2 px-4 text-left">Player 2 Score</th>
          <th class="py-2 px-4 text-left">Winner</th>
          <th class="py-2 px-4 text-left">Date Added</th>
          <th class="py-2 px-4 text-left">Archive</th>
        </tr>
      </thead>
      <tbody class="bg-white">
        @foreach ($games as $key => $game)
        <?php 
          $date = explode('T',$game['created_at']);
          $game['created_at'] = $date[0];
        ?>
        @if($key % 2 === 0)
          <tr class="bg-white">
        @else
          <tr class="bg-gray-200">
        @endif
        <form action="/archive" method="POST">
            @csrf
            <td class="py-2 px-4">{{ $game['id']}}</td>
            @if( $game['player1_id'] == $game['winner'])
            <td class="">
              <a href="/profile/{{$game['player1_id']}}"
                class="hover:text-blue-700 hover:underline hover:bg-blue-100 rounded-lg px-3 py-2 inline-block transition duration-300 ease-in-out">
                👑{{ ucwords($game['player1_id']) }}
              </a>
            </td>
            @else
            <td class="">
              <a href="/profile/{{$game['player1_id']}}"
                class="hover:text-blue-700 hover:underline hover:bg-blue-100 rounded-lg px-3 py-2 inline-block transition duration-300 ease-in-out">
                {{ ucwords($game['player1_id']) }}
              </a>
            </td>
            @endif
            <td class="py-2 px-4">{{ $game['player1_score']}}</td>
            @if( $game['player2_id'] == $game['winner'])
            <td class="">
              <a href="/profile/{{$game['player2_id']}}"
                class="hover:text-blue-700 hover:underline hover:bg-blue-100 rounded-lg px-3 py-2 inline-block transition duration-300 ease-in-out">
                👑{{ ucwords($game['player2_id']) }}
              </a>
            </td>
            @else
            <td class="">
              <a href="/profile/{{$game['player2_id']}}"
                class="hover:text-blue-700 hover:underline hover:bg-blue-100 rounded-lg px-3 py-2 inline-block transition duration-300 ease-in-out">
                {{ ucwords($game['player2_id']) }}
              </a>
            </td>
            @endif
            <td class="py-2 px-4">{{ $game['player2_score']}}</td>
            <td class="">
              <a href="/profile/{{$game['winner']}}"
                class="hover:text-blue-700 hover:underline hover:bg-blue-100 rounded-lg px-3 py-2 inline-block transition duration-300 ease-in-out">
                {{ ucwords($game['winner']) }}
              </a>
            </td>            
            <td class="py-2 px-4">{{ $game['created_at']}}</td>
            <td class="py-2 px-4">
                <input type="hidden" name="game_id" value="<?php echo $game['id'];?>">     
                <input type="submit" value="Archive" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-full shadow-lg focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
            </td>
        </form>
        </tr>
        @endforeach
      </tbody>
    </table>
<?php 
  $uri = explode('/',url()->current());
  if(isset($uri[4])){
    $date = $uri[4];
  }
  if(!isset($uri[5]) || $uri[5] <= 1){
    $page = -1;
  }else{
    $page = $uri[5] -3;
  }
?>
@if(isset($uri[4]))
    <div class="flex items-center justify-center mt-8">
      <nav class="flex items-center space-x-4">
        @for($i = 0; $i <= 4; $i++)
          <?php 
            $page += 1;
            if(isset($uri[5])){
              $link = $page;
            }else{
              $link = "{$date}/{$page}";
            }
          ?>
          @if(isset($uri[5]) && $page == $uri[5])
            <a href="{{$link}}" class="px-3 py-2 bg-blue-500 text-black rounded-md hover:bg-blue-700">{{$page}}</a>
          @else
            <a href="{{$link}}" class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">{{$page}}</a>
          @endif
        @endfor
      </nav>
    </div>
@endif
    <div class="container mx-auto flex justify-end center py-3">
        <button class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-full shadow-lg focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
            <a href="/game">Add Game</a>
        </button>
    </div>
  </main>
</body>
</html>