<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        $rooms = Room::all();
        return view('blog.index', compact('rooms'));
    }

    public function show($id){
        $room = Room::findOrFail($id);
        return view('blog.singleroom', compact('room'));
    }
}
