<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');  // Gantilah dengan view yang sesuai untuk halaman home
    }
}
