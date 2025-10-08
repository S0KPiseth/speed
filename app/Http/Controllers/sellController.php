<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sellController
{
    public function index(Request $request)
    {
        return view('pages.sell-car');
    }
    public function inputInfo(Request $request)
    {
        return view('pages.sell-car-info');
    }
    //
}
