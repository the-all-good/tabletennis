<?php
    use App\Models\player;
    require(resource_path('views').'/header.blade.php');
?>
@if (session('status'))
  <div class="alert alert-danger bg-red-500 border-l-4 border-red-700 text-white p-4">
    {{session('status')}}
  </div>
@endif
<div class="relative">
  <div class="bg-white p-4 rounded-lg shadow-md cursor-pointer" id="dropdown-trigger">
    Select Player
  </div>
  <!-- Dropdown list, initially hidden -->
  <ul class="left-0 mt-2 bg-white border border-gray-300 rounded-md shadow-lg hidden" id="dropdown-list">
    <!-- List items -->
    @foreach(player::orderBy('name')->get() as $player)
    <a href="/profile/<?php echo $player['name'];?>">
      <li id="dropdown-list" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">
          {{ucfirst($player['name'])}}
      </li>
    </a>
    @endforeach
  </ul>
</div>










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