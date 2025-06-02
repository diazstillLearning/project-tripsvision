<?php

namespace App\Http\Controllers\Admin;

use App\Models\Culinary;
use Illuminate\Http\Request;
use App\Models\Destination;
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
            'price_range' => 'required|in:low,medium,high',
            'rating' => 'required|numeric|min:0|max:5',
            'cuisine_type' => 'required',
            'description' => 'required',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('images/culinaries', 'public');
        }

        Culinary::create([
            'name' => $request->name,
            'location' => $request->location,
            'price_range' => $request->price_range,
            'rating' => $request->rating,
            'cuisine_type' => $request->cuisine_type,
            'description' => $request->description,
            'image_url' => $imagePath,
            'id_destinations' => $request->id_destinations, // Jika ada relasi destinasi
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


    // Update culinary yang sudah ada
    public function update(Request $request, $id)
    {
        $culinary = Culinary::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'price_range' => 'required|in:low,medium,high',
            'rating' => 'required|numeric|min:0|max:5',
            'cuisine_type' => 'required',
            'description' => 'required',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $imagePath = $culinary->image_url;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('images/culinaries', 'public');
        }

        $culinary->update([
            'name' => $request->name,
            'location' => $request->location,
            'price_range' => $request->price_range,
            'rating' => $request->rating,
            'cuisine_type' => $request->cuisine_type,
            'description' => $request->description,
            'image_url' => $imagePath,
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
