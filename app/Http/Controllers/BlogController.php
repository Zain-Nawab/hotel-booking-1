<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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

     public function rooms(){
        $rooms = Room::all();
        return view('blog.index', compact('rooms'));
    }

    public function blog(){
        return view('blog.navbar.blog');
    }

    public function detail(){
        return view('blog.navbar.blogdetail');
    }

    public function aboutus(){
        return view('blog.navbar.aboutus');
    }

}
