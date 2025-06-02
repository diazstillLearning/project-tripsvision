<?php

namespace App\Http\Controllers\Admin;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DestinationController extends Controller
{
    // Tampilkan daftar destinations
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
        return view('admin\destinations.index', compact(
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

    // Tampilkan form tambah destination
    public function create()
    {
        return view('Admin.destinations.create');
    }

    // Simpan destination baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'category' => 'required',
            'rating' => 'required|numeric|min:0|max:5',
            'description' => 'required',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('images/destinations', 'public');
        }

        Destination::create([
            'name' => $request->name,
            'location' => $request->location,
            'category' => $request->category,
            'rating' => $request->rating,
            'description' => $request->description,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('Admin.destinations.index')->with('success', 'Destination added successfully.');
    }

    // Tampilkan form edit destination
    public function edit($id)
    {
        $destination = Destination::findOrFail($id);
        return view('Admin.destinations.edit', compact('destination'));
    }

    // Update destination yang sudah ada
    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'category' => 'required',
            'rating' => 'required|numeric|min:0|max:5',
            'description' => 'required',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $imagePath = $destination->image_url;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('images/destinations', 'public');
        }

        $destination->update([
            'name' => $request->name,
            'location' => $request->location,
            'category' => $request->category,
            'rating' => $request->rating,
            'description' => $request->description,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('Admin.destinations.index')->with('success', 'Destination updated successfully.');
    }

    // Hapus destination
    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();
        return redirect()->route('Admin.destinations.index')->with('success', 'Destination deleted successfully.');
    }
}
