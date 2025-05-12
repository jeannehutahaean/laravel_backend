@extends('layouts.auth')

@section('content')
    <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Login</h2>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <!-- Email Input -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
            <input type="email" name="email" id="email" class="w-full mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('email') }}" required>
        </div>
        
        <!-- Password Input -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
            <input type="password" name="password" id="password" class="w-full mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
        </div>

        <!-- Login Button -->
        <div class="flex items-center justify-between mt-6">
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Login
            </button>
        </div>
        
        <!-- Forgot Password Link -->
        <div class="mt-4 text-center">
            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Forgot your password?</a>
        </div>
    </form>
@endsection
