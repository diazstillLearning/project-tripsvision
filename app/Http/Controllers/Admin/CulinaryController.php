<?php

namespace App\Http\Controllers\Admin;

use App\Models\Culinary;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CulinaryController extends Controller
{
    // Tampilkan daftar culinary
    public function index()
    {
        $culinaries = Culinary::all();
        return view('Admin.culinaries.index', compact('culinaries'));
    }

    // Tampilkan form tambah culinary
    public function create()
    {
        $destinations = Destination::all();
        return view('Admin.culinaries.create', compact('destinations'));
    }

    // Simpan culinary baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'price' => 'required|numeric|min:0',
            'rating' => 'required|numeric|min:0|max:5',
            'cuisine_type' => 'required',
            'description' => 'required',
            'image_file' => 'nullable|image|max:2048',
            'image_file2' => 'nullable|image|max:2048',
            'image_file3' => 'nullable|image|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Tentukan price_range otomatis
        $price = $request->price;
        if ($price <= 100000) {
            $priceRange = 'low';
        } elseif ($price <= 300000) {
            $priceRange = 'medium';
        } else {
            $priceRange = 'high';
        }

        $image1 = $request->hasFile('image_file') ? $request->file('image_file')->store('images/culinaries', 'public') : null;
        $image2 = $request->hasFile('image_file2') ? $request->file('image_file2')->store('images/culinaries', 'public') : null;
        $image3 = $request->hasFile('image_file3') ? $request->file('image_file3')->store('images/culinaries', 'public') : null;

        Culinary::create([
            'name' => $request->name,
            'location' => $request->location,
            'price' => $price,
            'price_range' => $priceRange,
            'rating' => $request->rating,
            'cuisine_type' => $request->cuisine_type,
            'description' => $request->description,
            'image_url' => $image1,
            'image_url2' => $image2,
            'image_url3' => $image3,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('Admin.culinaries.index')->with('success', 'Culinary added successfully.');
    }

    // Tampilkan form edit culinary
    public function edit($id)
    {
        $culinary = Culinary::findOrFail($id);
        $destinations = Destination::all();
        return view('Admin.culinaries.edit', compact('culinary', 'destinations'));
    }

    // Update culinary
    public function update(Request $request, $id)
    {
        $culinary = Culinary::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'price' => 'required|numeric|min:0',
            'rating' => 'required|numeric|min:0|max:5',
            'cuisine_type' => 'required',
            'description' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image_file' => 'nullable|image|max:2048',
            'image_file2' => 'nullable|image|max:2048',
            'image_file3' => 'nullable|image|max:2048',
        ]);

        $price = $request->price;
        if ($price <= 100000) {
            $priceRange = 'low';
        } elseif ($price <= 300000) {
            $priceRange = 'medium';
        } else {
            $priceRange = 'high';
        }

        $image1 = $culinary->image_url;
        $image2 = $culinary->image_url2;
        $image3 = $culinary->image_url3;

        if ($request->hasFile('image_file')) {
            $image1 = $request->file('image_file')->store('images/culinaries', 'public');
        }
        if ($request->hasFile('image_file2')) {
            $image2 = $request->file('image_file2')->store('images/culinaries', 'public');
        }
        if ($request->hasFile('image_file3')) {
            $image3 = $request->file('image_file3')->store('images/culinaries', 'public');
        }

        $culinary->update([
            'name' => $request->name,
            'location' => $request->location,
            'price' => $price,
            'price_range' => $priceRange,
            'rating' => $request->rating,
            'cuisine_type' => $request->cuisine_type,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'image_url' => $image1,
            'image_url2' => $image2,
            'image_url3' => $image3,
        ]);

        return redirect()->route('Admin.culinaries.index')->with('success', 'Culinary updated successfully.');
    }

    // Hapus culinary
    public function destroy($id)
    {
        $culinary = Culinary::findOrFail($id);
        $culinary->delete();
        return redirect()->route('Admin.culinaries.index')->with('success', 'Culinary deleted successfully.');
    }
}
