<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Culinary;
use App\Models\Stay;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalDestinations' => Destination::count(),
            'totalCulinaries' => Culinary::count(),
            'totalStays' => Stay::count(),
            'totalUsers' => User::count(),
            'newDestinations' => Destination::orderBy('id_destinations', 'desc')->take(5)->get(),
            'newCulinaries' => Culinary::orderBy('id_culinaries', 'desc')->take(5)->get(),
            'newStays' => Stay::orderBy('id_stays', 'desc')->take(5)->get(),
            'newUsers' => User::orderBy('id', 'desc')->take(5)->get(),
        ]);
    }
}
