<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select a Math Topic</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Select a Topic</h2>

        <form action="/start-test" method="POST">
            @csrf

            <!-- Select Grade -->
            <label class="block text-gray-700 font-medium">Grade Level:</label>
            <select name="grade_level" class="w-full p-2 border rounded mt-1">
                @foreach($grades as $grade)
                    <option value="{{ $grade }}">{{ $grade }}</option>
                @endforeach
            </select>

            <!-- Select Topic -->
            <label class="block text-gray-700 font-medium mt-4">Topic:</label>
            <select name="topic" class="w-full p-2 border rounded mt-1">
                @foreach($topics as $topic)
                    <option value="{{ $topic }}">{{ $topic }}</option>
                @endforeach
            </select>

            <!-- Start Test Button -->
            <button type="submit" class="bg-blue-500 text-white w-full p-2 mt-4 rounded hover:bg-blue-600">
                Start Test
            </button>
        </form>
    </div>

</body>
</html>
