<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Culinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CulinaryController extends Controller
{
    // GET: /api/culinaries - Tampilkan semua culinary
    public function index()
    {
        $culinaries = Culinary::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $culinaries
        ]);
    }

    // POST: /api/culinaries - Simpan culinary baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'price_range' => 'required|in:low,medium,high',
            'rating' => 'required|numeric|min:0|max:5',
            'cuisine_type' => 'required|string',
            'description' => 'required|string',
            'image_file' => 'nullable|image|max:2048',
            'id_destinations' => 'nullable|exists:destinations,id_destinations',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('images/culinaries', 'public');
        }

        $culinary = Culinary::create([
            'name' => $request->name,
            'location' => $request->location,
            'price_range' => $request->price_range,
            'rating' => $request->rating,
            'cuisine_type' => $request->cuisine_type,
            'description' => $request->description,
            'image_url' => $imagePath,
            'id_destinations' => $request->id_destinations,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Culinary created successfully.',
            'data' => $culinary
        ], 201);
    }

    // GET: /api/culinaries/{id} - Tampilkan detail culinary
    public function show($id)
    {
        $culinary = Culinary::find($id);

        if (!$culinary) {
            return response()->json(['success' => false, 'message' => 'Culinary not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $culinary]);
    }

    // PUT/PATCH: /api/culinaries/{id} - Update culinary
    public function update(Request $request, $id)
    {
        $culinary = Culinary::find($id);

        if (!$culinary) {
            return response()->json(['success' => false, 'message' => 'Culinary not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string',
            'location' => 'sometimes|required|string',
            'price_range' => 'sometimes|required|in:low,medium,high',
            'rating' => 'sometimes|required|numeric|min:0|max:5',
            'cuisine_type' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'image_file' => 'nullable|image|max:2048',
            'id_destinations' => 'nullable|exists:destinations,id_destinations',
        ]);

        $imagePath = $culinary->image_url;

        if ($request->hasFile('image_file')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image_file')->store('images/culinaries', 'public');
        }

        $culinary->update(array_merge(
            $request->only(['name', 'location', 'price_range', 'rating', 'cuisine_type', 'description', 'id_destinations']),
            ['image_url' => $imagePath]
        ));

        return response()->json([
            'success' => true,
            'message' => 'Culinary updated successfully.',
            'data' => $culinary
        ]);
    }

    // DELETE: /api/culinaries/{id} - Hapus culinary
    public function destroy($id)
    {
        $culinary = Culinary::find($id);

        if (!$culinary) {
            return response()->json(['success' => false, 'message' => 'Culinary not found'], 404);
        }

        if ($culinary->image_url && Storage::disk('public')->exists($culinary->image_url)) {
            Storage::disk('public')->delete($culinary->image_url);
        }

        $culinary->delete();

        return response()->json([
            'success' => true,
            'message' => 'Culinary deleted successfully.'
        ]);
    }
}
