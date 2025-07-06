<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load font Orbiton dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        orbiton: ['Orbitron', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    @yield('styles')
</head>
<body class="bg-white text-black">

<nav class="bg-gray-100 fixed top-0 w-full z-50 shadow">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <div class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-black font-bold text-lg">
          <img class="h-8 w-auto mr-2" src="{{ asset('images/logonavbar.png') }}" alt="Logo">
          <span class="font-orbiton">Jedda Tracking</span>
        </a>
        <div class="hidden md:block ml-10">
          <div class="flex items-baseline space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-300 text-black' : 'text-gray-700 hover:bg-gray-200 hover:text-black' }} px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
            <a href="{{ route('admin.vehicles.index') }}" class="{{ request()->routeIs('admin.vehicles.*') ? 'bg-gray-300 text-black' : 'text-gray-700 hover:bg-gray-200 hover:text-black' }} px-3 py-2 rounded-md text-sm font-medium">Kendaraan</a>
            <a href="{{ route('admin.routes.index') }}" class="{{ request()->routeIs('admin.routes.*') ? 'bg-gray-300 text-black' : 'text-gray-700 hover:bg-gray-200 hover:text-black' }} px-3 py-2 rounded-md text-sm font-medium">Rute</a>
            <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'bg-gray-300 text-black' : 'text-gray-700 hover:bg-gray-200 hover:text-black' }} px-3 py-2 rounded-md text-sm font-medium">Laporan</a>
           <a href="{{ route('admin.notifications.index') }}" class="{{ request()->routeIs('admin.notifications.*') ? 'bg-gray-300 text-black' : 'text-gray-700 hover:bg-gray-200 hover:text-black' }} px-3 py-2 rounded-md text-sm font-medium">Notifikasi</a>
          </div>
        </div>
      </div>

      <div class="flex items-center space-x-4">
        <!-- Notification button -->
        <button class="bg-gray-100 p-1 rounded-full text-gray-500 hover:text-black focus:outline-none focus:ring-2 focus:ring-black">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.85 23.85 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
          </svg>
        </button>

        <!-- Logout button -->
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm font-medium">Logout</button>
        </form>
      </div>
    </div>
  </div>
</nav>

<main class="pt-20 px-4 sm:px-6 lg:px-8">
    @yield('content')
</main>

@yield('scripts')

</body>
</html>