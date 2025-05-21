<!DOCTYPE html>
<html lang="en">
<head>
    <!-- test -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f8fafc;
        }
        .login-card {
            max-width: 28rem;
            width: 100%;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="login-card bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logonavbar.png') }}" alt="Logo" class="h-16 mx-auto mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Login Admin</h2>
        </div>

        @if (session('error'))
            <div class="mb-6 p-3 bg-red-50 text-red-600 text-sm rounded-md text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
            @csrf
            
            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                       placeholder="admin@example.com"
                       value="{{ old('email') }}" 
                       required>
            </div>
            
            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                       placeholder="••••••••"
                       required>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-500">Lupa password?</a>
            </div>

            <!-- Login Button -->
            <div>
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                    Masuk
                </button>
            </div>
        </form>
    </div>
</body>
</html>