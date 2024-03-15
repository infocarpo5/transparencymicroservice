<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $activeClasses = User::where('role_id', 1)->where('status', 1)->count();
        $activeConsumers = User::where('role_id', 2)->where('status', 1)->count();
        $routesCount = 23;

        return view('home', compact('activeClasses', 'activeConsumers', 'routesCount'));
    }
}
