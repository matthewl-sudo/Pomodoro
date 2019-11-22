<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timer;
use App\Profile;
use Auth;
use DB;
use App\User;

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
        // var_dump($userTimers);
    }
    public function showExp()
    {
        $userId = Auth::user()->id;
        $timers = Timer::where('user_id', '=', $userId)->get();

        $arrayTimers = [];
        foreach ($timers as $key => $timer) { // store only the durations(int) into an array
            $arrayTimers[] = $timers[$key]['duration'];
        }


        $experience = array_sum($arrayTimers);
        if ($experience >= 100) {   //get level from "experience points"
            $level = round($experience/100) + 1;
        }
        else {
            $level = 1;  //set default level as level 1
        }

        $newProfile = Profile::where('user_id','!=', $userId)->first();
        $newLevel = Profile::where('user_id', '=', $userId)
                           ->first();

        if (isset($newProfile)) {
            $profile = new Profile;
            $profile->user_id = $userId;
            $profile->level = $level;
            $profile->save();
        }
        elseif (isset($newLevel)) {
            $updateProfile = Profile::where('user_id', '=', $userId)->firstOrFail();
            $updateProfile->level = $level;
            $updateProfile->save();
        }
        else {

        }

        $str_exp = strval($experience); //Convert Int value to String
        $progressbar = substr($str_exp, -2); //Takes the last two digits
        $showProfile = [];
        $showProfile[] = $level;    // Store Level
        $showProfile[] = $progressbar; //ProgressBar value needs to be <=100 to take last two digits.
        $showProfile[] = $experience; //Total experience points Int
        // print_r($showProfile);
        return json_encode($showProfile);
    }
    public function showLeaderBoards()
    {
        $userId = Auth::user()->id;
        $users = DB::table('timers')->pluck('duration','user_id');

        // $timers = Timer::where('user_id', '!=', $userId)->sum('duration'); //total completed timer excluding current user
        $users = User::all();
        $leaders = [];
        foreach ($users as $user) {
            $timers = Timer::where('user_id', '=', $user->id)->sum('duration');
            $leader = new \stdClass;
            $leader->name = $user->name;
            $leader->duration = $timers;
            $leaders[] = $leader;
        }
        usort($leaders, function($a,$b){
            return $a->duration < $b->duration;
        });
        $topTen = array_slice($leaders, -10);
        // var_dump($topTen);
        return json_encode($topTen);
    }
}
