<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Destination;

class DestinationController extends Controller
{
    // GET: /api/admin/destinations
    public function index()
    {
        $destinations = Destination::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $destinations
        ], 200);
    }

    // POST: /api/admin/destinations
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'category' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
            'description' => 'required|string',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('images/destinations', 'public');
        }

        $destination = Destination::create([
            'name' => $request->name,
            'location' => $request->location,
            'category' => $request->category,
            'rating' => $request->rating,
            'description' => $request->description,
            'image_url' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Destination created successfully.',
            'data' => $destination
        ], 201);
    }

    // GET: /api/admin/destinations/{id}
    public function show($id)
    {
        $destination = Destination::find($id);

        if (!$destination) {
            return response()->json(['success' => false, 'message' => 'Destination not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $destination
        ]);
    }

    // PUT/PATCH: /api/admin/destinations/{id}
    public function update(Request $request, $id)
    {
        $destination = Destination::find($id);

        if (!$destination) {
            return response()->json(['success' => false, 'message' => 'Destination not found'], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'category' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
            'description' => 'required|string',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $imagePath = $destination->image_url;

        if ($request->hasFile('image_file')) {
            // Hapus file lama (jika ada)
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

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

        return response()->json([
            'success' => true,
            'message' => 'Destination updated successfully.',
            'data' => $destination
        ]);
    }

    // DELETE: /api/admin/destinations/{id}
    public function destroy($id)
    {
        $destination = Destination::find($id);

        if (!$destination) {
            return response()->json(['success' => false, 'message' => 'Destination not found'], 404);
        }

        if ($destination->image_url && Storage::disk('public')->exists($destination->image_url)) {
            Storage::disk('public')->delete($destination->image_url);
        }

        $destination->delete();

        return response()->json([
            'success' => true,
            'message' => 'Destination deleted successfully.'
        ]);
    }
}
