<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timer;
use Auth;

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
        return view('home');
    }
    public function saveTime(Request $request)
    {
        $userId = Auth::user()->id;
        $duration = $request->storeTime;
        $type = $request->type;
        // var_dump($request->storeTime);
        $timer = new Timer;
        $timer->user_id = $userId;
        $timer->duration = $duration;
        $timer->type = $type;
        $timer->save();
    }
    public function showLog()
    {
        $userId = Auth::user()->id;
        $userTimers = Timer::where('user_id', '=', $userId)
                            ->orderBy('created_at','desc')
                            ->limit(5)
                            ->get();
        return $userTimers->toJson();
        var_dump($userTimers);
    }
}
