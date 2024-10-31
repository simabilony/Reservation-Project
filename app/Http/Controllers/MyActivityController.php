<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyActivityController extends Controller
{
    public function show()
    {
        $activities = auth()->user()->activities()->orderBy('start_time')->get();
        return view('activities.my-activities', compact('activities'));
    }
}
