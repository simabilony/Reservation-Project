<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyActivityController extends Controller
{
    public function show()
    {
        return view('activities.my-activities');
    }
}
