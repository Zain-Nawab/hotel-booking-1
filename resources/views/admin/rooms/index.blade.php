@extends('admin.layout')

@section('content')
<div class="w-full px-4 py-6">
    <div class=" items-center mb-6">
        <h1 class="text-2xl font-bold">All Rooms</h1>
        <a href="{{ route('room.create') }}"
           class="btn btn-md btn-success">
            + Add New Room
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="w-full bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Room #</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Image</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($rooms as $room)
                    <tr>
                        <td class="px-4 py-2">{{ $room->room_number }}</td>
                        <td class="px-4 py-2 capitalize">{{ $room->type }}</td>
                        <td class="px-4 py-2">${{ number_format($room->price, 2) }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            @if ($room->image)
                                <img src="{{ asset('storage/' . $room->image) }}" alt="Room Image"
                                     class="w-16 h-12 object-cover rounded-md border">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                   class="text-blue-600 hover:underline text-sm">Edit</a>
                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No rooms found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection