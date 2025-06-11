<?php

namespace App\Http\Controllers\Admin;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DestinationController extends Controller
{
    public function index()
    {
        $totalDestinations = \App\Models\Destination::count();
        $totalCulinaries = \App\Models\Culinary::count();
        $totalStays = \App\Models\Stay::count();
        $totalUsers = \App\Models\User::count();

        $newDestinations = \App\Models\Destination::latest()->take(5)->get();
        $newCulinaries = \App\Models\Culinary::latest()->take(5)->get();
        $newStays = \App\Models\Stay::latest()->take(5)->get();
        $newUsers = \App\Models\User::latest()->take(5)->get();

        $destinations = Destination::all();

        return view('Admin.destinations.index', compact(
            'totalDestinations',
            'totalCulinaries',
            'totalStays',
            'totalUsers',
            'newDestinations',
            'newCulinaries',
            'newStays',
            'newUsers',
            'destinations'
        ));
    }

    public function create()
    {
        return view('Admin.destinations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'category' => 'required',
            'rating' => 'required|numeric|min:0|max:5',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'image_file' => 'nullable|image|max:2048',
            'image_file2' => 'nullable|image|max:2048',
            'image_file3' => 'nullable|image|max:2048',
        ]);

        $image1 = $request->hasFile('image_file') ? $request->file('image_file')->store('images/destinations', 'public') : null;
        $image2 = $request->hasFile('image_file2') ? $request->file('image_file2')->store('images/destinations', 'public') : null;
        $image3 = $request->hasFile('image_file3') ? $request->file('image_file3')->store('images/destinations', 'public') : null;

        $price = $request->price;
        if ($price <= 100000) {
            $priceRange = 'low';
        } elseif ($price <= 300000) {
            $priceRange = 'medium';
        } else {
            $priceRange = 'high';
        }

        Destination::create([
            'name' => $request->name,
            'location' => $request->location,
            'category' => $request->category,
            'rating' => $request->rating,
            'price' => $price,
            'price_range' => $priceRange,
            'description' => $request->description,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'image_url' => $image1,
            'image_url2' => $image2,
            'image_url3' => $image3,
        ]);

        return redirect()->route('Admin.destinations.index')->with('success', 'Destination added successfully.');
    }

    public function edit($id)
    {
        $destination = Destination::findOrFail($id);
        return view('Admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'category' => 'required',
            'rating' => 'required|numeric|min:0|max:5',
            'price' => 'required|numeric|min:0',
            'price_range'=> 'nullable|string',
            'description' => 'required',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'image_file' => 'nullable|image|max:2048',
            'image_file2' => 'nullable|image|max:2048',
            'image_file3' => 'nullable|image|max:2048',
        ]);

        $image1 = $destination->image_url;
        $image2 = $destination->image_url2;
        $image3 = $destination->image_url3;

        if ($request->hasFile('image_file')) {
            $image1 = $request->file('image_file')->store('images/destinations', 'public');
        }
        if ($request->hasFile('image_file2')) {
            $image2 = $request->file('image_file2')->store('images/destinations', 'public');
        }
        if ($request->hasFile('image_file3')) {
            $image3 = $request->file('image_file3')->store('images/destinations', 'public');
        }

        $price = $request->price;
        if ($price <= 100000) {
            $priceRange = 'low';
        } elseif ($price <= 300000) {
            $priceRange = 'medium';
        } else {
            $priceRange = 'high';
        }

        $destination->update([
            'name' => $request->name,
            'location' => $request->location,
            'category' => $request->category,
            'rating' => $request->rating,
            'price' => $price,
            'price_range' => $priceRange,
            'description' => $request->description,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'image_url' => $image1,
            'image_url2' => $image2,
            'image_url3' => $image3,
        ]);

        return redirect()->route('Admin.destinations.index')->with('success', 'Destination updated successfully.');
    }

    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();
        return redirect()->route('Admin.destinations.index')->with('success', 'Destination deleted successfully.');
    }
}
