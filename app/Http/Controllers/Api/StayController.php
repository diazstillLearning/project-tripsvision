<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stay;

class StayController extends Controller
{
    // GET: /api/stays
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Stay::latest()->get()
        ]);
    }

    // GET: /api/stays/{id}
    public function show($id)
    {
        $stay = Stay::find($id);
        if (!$stay) {
            return response()->json(['success' => false, 'message' => 'Stay not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $stay]);
    }

    // POST: /api/stays
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'price_range' => 'required|in:low,medium,high',
            'rating' => 'required|numeric|min:0|max:5',
            'amenities' => 'required|string',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'id_destinations' => 'required|exists:destinations,id_destinations'
        ]);

        $stay = Stay::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Stay created successfully',
            'data' => $stay
        ], 201);
    }

    // PUT: /api/stays/{id}
    public function update(Request $request, $id)
    {
        $stay = Stay::find($id);
        if (!$stay) {
            return response()->json(['success' => false, 'message' => 'Stay not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'location' => 'sometimes|string',
            'price_range' => 'sometimes|in:low,medium,high',
            'rating' => 'sometimes|numeric|min:0|max:5',
            'amenities' => 'sometimes|string',
            'description' => 'sometimes|string',
            'image_url' => 'nullable|string',
            'id_destinations' => 'sometimes|exists:destinations,id_destinations'
        ]);

        $stay->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Stay updated successfully',
            'data' => $stay
        ]);
    }

    // DELETE: /api/stays/{id}
    public function destroy($id)
    {
        $stay = Stay::find($id);
        if (!$stay) {
            return response()->json(['success' => false, 'message' => 'Stay not found'], 404);
        }

        $stay->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stay deleted successfully'
        ]);
    }
}
