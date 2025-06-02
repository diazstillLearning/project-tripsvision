<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stay;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class StayController extends Controller
{
    // Tampilkan daftar stay
    public function index()
    {
        $stays = Stay::all();
        return view('Admin.stays.index', compact('stays'));
    }

    // Tampilkan form tambah stay
    public function create()
    {
        $destinations = Destination::all();
        return view('Admin.stays.create', compact('destinations'));
    }

    // Simpan stay baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'price_range' => 'required|in:low,medium,high',
            'rating' => 'required|numeric|min:0|max:5',
            'amenities' => 'required|array',
            'description' => 'required',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('images/stays', 'public');
        }

        Stay::create([
            'name' => $request->name,
            'location' => $request->location,
            'price_range' => $request->price_range,
            'rating' => $request->rating,
            'amenities' => $request->amenities,
            'description' => $request->description,
            'image_url' => $imagePath,
            'id_destinations' => $request->id_destinations,
        ]);

        return redirect()->route('Admin.stays.index')->with('success', 'Stay added successfully.');
    }

    // Tampilkan form edit stay
    public function edit($id)
    {
        $stay = Stay::findOrFail($id);
        $destinations = Destination::all();
        return view('Admin.stays.edit', compact('stay', 'destinations'));
    }

    // Update stay yang sudah ada
    public function update(Request $request, $id)
    {
        $stay = Stay::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'price_range' => 'required|in:low,medium,high',
            'rating' => 'required|numeric|min:0|max:5',
            'amenities' => 'required|array',
            'description' => 'required',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $imagePath = $stay->image_url;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('images/stays', 'public');
        }

        $stay->update([
            'name' => $request->name,
            'location' => $request->location,
            'price_range' => $request->price_range,
            'rating' => $request->rating,
            'amenities' => $request->amenities,
            'description' => $request->description,
            'image_url' => $imagePath,
            'id_destinations' => $request->id_destinations,
        ]);

        return redirect()->route('Admin.stays.index')->with('success', 'Stay updated successfully.');
    }

    // Hapus stay
    public function destroy($id)
    {
        $stay = Stay::findOrFail($id);
        $stay->delete();
        return redirect()->route('Admin.stays.index')->with('success', 'Stay deleted successfully.');
    }
}
