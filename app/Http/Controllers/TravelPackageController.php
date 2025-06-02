<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use App\Models\Destination;
use App\Models\Culinary;
use App\Models\Stay;
use Illuminate\Http\Request;

class TravelPackageController extends Controller
{
    // Tampilkan semua travel package di dashboard user
    public function index()
    {
        $packages = TravelPackage::with(['destinations', 'culinaries', 'stays'])->get();
        return view('user.dashboard', compact('packages'));
    }

    // Rekomendasi berdasarkan lokasi dan budget
    public function recommendations(Request $request)
    {
        $location = $request->input('location');
        $maxPrice = $request->input('budget');

        $recommendedPackages = TravelPackage::with(['destinations', 'culinaries', 'stays'])
            ->where('total_price', '<=', $maxPrice)
            ->whereHas('destinations', function ($query) use ($location) {
                $query->where('location', 'like', '%' . $location . '%');
            })
            ->get();

        return view('user.recommendations', compact('recommendedPackages', 'location', 'maxPrice'));
    }
}
