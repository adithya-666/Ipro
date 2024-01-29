<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class managerController extends Controller
{
    public function index()
    {
        $this->authorize('manager');
        return view('dashboard.manager');
    }
}
