<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // public function  __construct() {
    //     $this->middleware(['auth']);
    // }

    public function index() {


        $username = Auth::user()->name;
        $title = 'RGS';
        return view('dashboard.index', [
            'name' => $username,
            'title' => $title
        ]);
    }
}
