<?php
    use App\Models\player;
    require(resource_path('views').'/header.blade.php');
?>
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

.flip-card {
  background-color: transparent;
  width: 250px;
  height: 300px;
  perspective: 1000px;
}

.flip-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.6s;
  transform-style: preserve-3d;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
}

.flip-card:hover .flip-card-inner {
  transform: rotateY(180deg);
}

.flip-card-front, .flip-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
}

.flip-card-front {
  background-color: #bbb;
  color: white;
}

.flip-card-back {
  background-color: #2980b9;
  color: white;
  transform: rotateY(180deg);
}
</style>
@if (session('status'))
  <div class="alert alert-danger bg-red-500 border-l-4 border-red-700 text-white p-4">
    {{session('status')}}
  </div>
@endif
<div class="relative">
  <div class="bg-white p-4 rounded-lg shadow-md cursor-pointer" id="dropdown-trigger">
    @if(!isset($profile))
    Select Player
    @else
    {{ucwords($profile->name)}}
    @endif
  </div>
  <!-- Dropdown list, initially hidden -->
  <ul class="left-0 mt-2 bg-white border border-gray-300 rounded-md shadow-lg hidden" id="dropdown-list">
    <!-- List items -->
    @foreach(player::orderBy('name')->get() as $player)
    <a href="/profile/<?php echo $player['name'];?>">
      <li id="dropdown-list" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">
          {{ucwords($player['name'])}}
      </li>
    </a>
    @endforeach
  </ul>
</div>
@if(!isset($profile))
@else
<div class="flex justify-center items-center p-10 ">
<div class="flip-card" id="player_card">
  <div id="player_card_inner" class="flip-card-inner">
  <div class="bg-gradient-to-r from-blue-400 to-purple-400 rounded-md flex flex-col justify-center items-center border-solid border-1 h-96 w-64 flip-card-front" id="player_card_basic">
    <div class="text-white text-2xl font-bold mb-4 mt-2">{{ucwords($profile->name)}}</div>
      <div class="flex items-center mb-2">
        <div class="w-8 h-8 bg-gray-300 mr-2 rounded-full"></div>
        <span class="text-gray-300">🙎‍♂️</span>
      </div>
    <div class="flex-grow">
      <div class="mb-2">
        <span class="text-gray-200">Games:</span> {{$profile->games}}
      </div>
      <div class="mb-2">
        <span class="text-gray-200">Wins:</span> {{$profile->wins}}
      </div>
      <div class="mb-2">
        <span class="text-gray-200">Points:</span> {{$profile->points}}
      </div>
      <div class="mb-2">
        <span class="text-gray-200">Winrate</span> {{$profile->winrate}}%
      </div>
    </div>
  </div>
  <div class="bg-gradient-to-r from-blue-400 to-purple-400 rounded-md flex flex-col justify-center items-center border-solid border-1 h-96 w-64 flip-card-back" id="player_card_advanced">
  <div class="text-white text-2xl font-bold mb-4 mt-2">{{ucwords($profile->name)}}</div>
    <div class="flex-grow">
      <div class="mb-2">
        <span class="text-gray-200">Points lost</span> {{$profile->lostpoints}}
      </div>
      <div class="mb-2">
        <span class="text-gray-200">Point rate</span> {{$profile->pointrate}}%
      </div>
      <div class="mb-2">
        <span class="text-gray-200">Blowout games</span> {{$profile->blowout}}
      </div>
      <div class="mb-2">
        <span class="text-gray-200">Close games</span> {{$profile->closegame}}
      </div>
      <div class="mb-2">
        <span class="text-gray-200">Starting serves:</span> {{$profile->serves}}
      </div>
      <div class="mb-2">
        <span class="text-gray-200">Wins on serve:</span> {{$profile->win_on_serve}}
      </div>
      <div class="mb-2">
        <span class="text-gray-200">Wins receiving serve:</span> {{$profile->win_on_recieve}}
      </div>
    </div>
  </div>
  </div>
</div>
</div>

@endif
  <!-- JavaScript to handle dropdown behavior -->
  <script>
    const dropdownTrigger = document.getElementById('dropdown-trigger');
    const dropdownList = document.getElementById('dropdown-list');
    // Show the dropdown list on hover or click
    dropdownTrigger.addEventListener('mouseenter', () => {
      dropdownList.classList.remove('hidden');
    });

    dropdownTrigger.addEventListener('click', () => {
      dropdownList.classList.toggle('hidden');
    });

    // Hide the dropdown list when the mouse leaves the list
    dropdownList.addEventListener('mouseleave', () => {
      dropdownList.classList.add('hidden');
    });
  </script>