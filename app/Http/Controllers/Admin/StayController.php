<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stay;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class StayController extends Controller
{
    public function index()
    {
        $stays = Stay::all();
        return view('Admin.stays.index', compact('stays'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('Admin.stays.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'price' => 'required|numeric|min:0',
            'rating' => 'required|numeric|min:0|max:5',
            'amenities' => 'required|array',
            'description' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image_file' => 'nullable|image|max:2048',
            'image_file2' => 'nullable|image|max:2048',
            'image_file3' => 'nullable|image|max:2048',
        ]);

        // Tentukan price_range otomatis berdasarkan price
        $price = $request->price;
        if ($price <= 100000) {
            $priceRange = 'low';
        } elseif ($price <= 300000) {
            $priceRange = 'medium';
        } else {
            $priceRange = 'high';
        }

        $image1 = $request->file('image_file') ? $request->file('image_file')->store('images/stays', 'public') : null;
        $image2 = $request->file('image_file2') ? $request->file('image_file2')->store('images/stays', 'public') : null;
        $image3 = $request->file('image_file3') ? $request->file('image_file3')->store('images/stays', 'public') : null;

        Stay::create([
            'name' => $request->name,
            'location' => $request->location,
            'price' => $price,
            'price_range' => $priceRange,
            'rating' => $request->rating,
            'amenities' => $request->amenities,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'image_url' => $image1,
            'image_url2' => $image2,
            'image_url3' => $image3,
        ]);

        return redirect()->route('Admin.stays.index')->with('success', 'Stay added successfully.');
    }

    public function edit($id)
    {
        $stay = Stay::findOrFail($id);
        $destinations = Destination::all();
        return view('Admin.stays.edit', compact('stay', 'destinations'));
    }

    public function update(Request $request, $id)
    {
        $stay = Stay::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'price' => 'required|numeric|min:0',
            'rating' => 'required|numeric|min:0|max:5',
            'amenities' => 'required|array',
            'description' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image_file' => 'nullable|image|max:2048',
            'image_file2' => 'nullable|image|max:2048',
            'image_file3' => 'nullable|image|max:2048',
        ]);

        // Hitung price_range dari price baru
        $price = $request->price;
        if ($price <= 100000) {
            $priceRange = 'low';
        } elseif ($price <= 300000) {
            $priceRange = 'medium';
        } else {
            $priceRange = 'high';
        }

        $image1 = $stay->image_url;
        $image2 = $stay->image_url2;
        $image3 = $stay->image_url3;

        if ($request->hasFile('image_file')) {
            $image1 = $request->file('image_file')->store('images/stays', 'public');
        }
        if ($request->hasFile('image_file2')) {
            $image2 = $request->file('image_file2')->store('images/stays', 'public');
        }
        if ($request->hasFile('image_file3')) {
            $image3 = $request->file('image_file3')->store('images/stays', 'public');
        }

        $stay->update([
            'name' => $request->name,
            'location' => $request->location,
            'price' => $price,
            'price_range' => $priceRange,
            'rating' => $request->rating,
            'amenities' => $request->amenities,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'image_url' => $image1,
            'image_url2' => $image2,
            'image_url3' => $image3,
        ]);

        return redirect()->route('Admin.stays.index')->with('success', 'Stay updated successfully.');
    }

    public function destroy($id)
    {
        $stay = Stay::findOrFail($id);
        $stay->delete();
        return redirect()->route('Admin.stays.index')->with('success', 'Stay deleted successfully.');
    }
}
