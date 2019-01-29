<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Funnel;
use App\Tag;

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
     * @return Response
     */
    public function show()
    {
        $funnels = Funnel::where('user_id', Auth::id())->paginate(20);
        $tags = Tag::where('user_id', Auth::id())->get();
        return view('home', compact(['funnels', 'tags']));
    }
}
