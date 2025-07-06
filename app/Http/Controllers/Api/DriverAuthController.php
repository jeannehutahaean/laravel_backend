<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Driver; // pastikan ini model tabel driver
use Illuminate\Support\Facades\Auth;

class DriverAuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $driver = Driver::where('driver_email', $request->email)->first();
    
        if (!$driver || !Hash::check($request->password, $driver->driver_password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }
    
        $token = $driver->createToken('driver_token')->plainTextToken;
    
        return response()->json([
            'token' => $token,
            'user'  => $driver
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_name'        => 'required|string|max:100',
            'driver_username'    => 'required|string|max:50|unique:drivers,driver_username',
            'driver_email'       => 'required|email|unique:drivers,driver_email',
            'driver_password'    => 'required|string|min:6',
            'driver_no_ktp'      => 'nullable|string|max:50',
            'driver_no_kk'       => 'nullable|string|max:50',
            'driver_address'     => 'nullable|string',
            'driver_birthplace'  => 'nullable|string|max:100',
            'driver_birthdate'   => 'nullable|date',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $driver = Driver::create([
            'driver_name'        => $request->driver_name,
            'driver_username'    => $request->driver_username,
            'driver_email'       => $request->driver_email,
            'driver_password'    => Hash::make($request->driver_password),
            'driver_no_ktp'      => $request->driver_no_ktp,
            'driver_no_kk'       => $request->driver_no_kk,
            'driver_address'     => $request->driver_address,
            'driver_birthplace'  => $request->driver_birthplace,
            'driver_birthdate'   => $request->driver_birthdate,
            'driver_photo_profile' => '', // <--- ini tambahan
            'driver_photo_ktp'     => '',
            'driver_photo_kk'      => '',
        ]);
    
        $token = $driver->createToken('driver_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Registrasi berhasil',
            'token' => $token,
            'user'  => $driver
        ], 201);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
}
