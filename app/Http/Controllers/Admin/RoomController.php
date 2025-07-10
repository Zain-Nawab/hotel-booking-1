<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $query = Room::query();

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('room_number', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%");
            });
        }

            // Handle type filter - Match the frontend parameter
            if ($request->has('type_filter') && !empty($request->type_filter)) {
                $query->where('type', $request->type_filter);
            }

        // Handle status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Handle sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSorts = ['room_number', 'type', 'price_per_night', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $rooms = $query->paginate(15);

        // For AJAX requests (if you want to implement live search)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.rooms.partials.room-table', compact('rooms'))->render(),
                'pagination' => $rooms->links()->render()
            ]);
        }

        return view('admin.rooms.index', compact('rooms'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required',
            'type' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Room::create([
            'room_number' => $validated['room_number'],
            'type' => $validated['type'],
            'price_per_night' => $validated['price'],
            'description' => $validated['description'],
            'image' => $validated['image']->store('rooms', 'public'),
        ]);
        return redirect()->route('room.index')->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        return view('admin.rooms.updateroom', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_number' => 'required',
            'type' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        //if has image than delete olad 
        if(request()->hasFile('image') && $room->image) {
            // Delete old image
            Storage::disk('public')->delete($room->image);
        }

        $room->update([
            'room_number' => $validated['room_number'],
            'type' => $validated['type'],
            'price_per_night' => $validated['price'],
            'description' => $validated['description'],
            'image' => $validated['image'] ? $validated['image']->store('rooms', 'public') : $room->image,
        ]);

        return redirect()->route('room.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        //check if has image and delete it
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }
        
        $room->delete();

        return redirect()->route('room.index')->with('success', 'Room deleted successfully.');
    }
}
