@extends('master')

@section('content')



        <div class="section_title text-center">
            <h2 class="title_color">Hotel Accomodation</h2>
            <p>We all live in an age that belongs to the young at heart. Life that is becoming extremely fast, </p>
        </div>

<div class="row mb-5">

    @foreach ($rooms as $room)
        <div class="col-md-4 mb-4">
    <div class="card h-100 shadow-lg">
        <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top" alt="{{ $room->name }}">
        <div class="card-body">
            <h5 class="card-title"> {{ $room->type }}</h5>
            <p class="card-text " style=" color:#52c5fd; font-weight: bold; "  ><strong>${{ $room->price_per_night }}/night</strong></p>
            <p class="card-text">{{ Str::limit($room->description, 100) }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-primary btn-md">View Details</a>
            <a href="{{ route('room.booking', $room->id) }}" class="btn theme_btn button_hover btn-sm" style="border-radius:5px; " >Book Now</a>
        </div>
    </div>
</div>
    @endforeach

</div>

@endsection