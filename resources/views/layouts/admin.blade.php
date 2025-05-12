<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow-md px-4 py-3">
        <div class="flex justify-between items-center">
            <div class="text-xl font-bold text-orange-600">Admin Panel</div>
            <div>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="p-6">
        @yield('content')
    </main>

</body>
</html>
