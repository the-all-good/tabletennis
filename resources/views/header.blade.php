<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <header class="bg-gradient-to-r from-blue-500 to-purple-600  text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-xl font-semibold"><a href="/">Dashboard</a></h1>
      <nav>
        <ul class="flex space-x-4">
          <li><a href="/game" class="hover:text-blue-300">Add Game</a></li>
          <li><a href="/games" class="hover:text-blue-300">View Game</a></li>
          <li><a href="/profile" class="hover:text-blue-300">Player Stats</a></li>
          <li><a href="/archive" class="hover:text-blue-300">Archived</a></li>
        </ul>
      </nav>
    </div>
  </header>