<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Public landing page
    public function welcome()
    {
        $treatments = Treatment::where('is_active', true)->get();
        return view('welcome', compact('treatments'));
    }

    // Admin dashboard
    public function index()
    {
        return view('admin.dashboard');
    }

    public function homepage()
    {
        return view('homepage');
    }
}