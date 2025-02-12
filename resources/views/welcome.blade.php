<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Zanimliva Matematika</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-600 text-white flex items-center justify-center h-screen">
    <div class="text-center" x-data="{ showWelcome: true }">
        <h1 class="text-5xl font-bold mb-4" x-show="showWelcome">Welcome to Zanimliva Matematika</h1>
        <p class="text-lg" x-show="showWelcome">An engaging way to learn and master mathematics!</p>
        
        <button class="mt-6 px-6 py-3 bg-white text-blue-600 font-bold rounded-lg shadow-lg hover:bg-gray-200" 
                @click="showWelcome = !showWelcome">
            Get Started
        </button>
        
        <div x-show="!showWelcome" class="mt-6">
            <p class="text-lg">Explore our interactive courses and quizzes.</p>
            <a href="/courses" class="mt-4 px-6 py-3 bg-yellow-400 text-black font-bold rounded-lg shadow-lg hover:bg-yellow-500">Start Learning</a>
        </div>

        <div x-show="!showWelcome" class="mt-6">
            <p class="text-lg">Explore our interactive courses and quizzes.</p>
            <a href="/games" class="mt-4 px-6 py-3 bg-yellow-400 text-black font-bold rounded-lg shadow-lg hover:bg-yellow-500">GAMES</a>
        </div>
    </div>
</body>
</html>
