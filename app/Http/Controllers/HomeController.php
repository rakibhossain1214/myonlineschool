<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Course;
use App\Application;
class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        $user = Auth::user();
        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();
        return view('home.home', compact('n', 'user'));
    }

    public function allCourses()
    {
        $user = Auth::user();
        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();
        $courses = Course::all();
        return view('home.allcourses', compact('n', 'user', 'courses'));
    }

    public function terms()
    {
        $user = Auth::user();
        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();
        $courses = Course::all();
        return view('home.terms', compact('n', 'user', 'courses'));
    }

    public function privacy()
    {
        $user = Auth::user();
        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();
        $courses = Course::all();
        return view('home.privacy', compact('n', 'user', 'courses'));
    }

    public function apply()
    {
        $user = Auth::user();
        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();

        $success = null;

        return view('home.apply', compact('success','n', 'user'));
    }

    public function applyStore(Request $request)
    {

        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'reason' => 'required',
            'cv' => 'required'
            
        ],[
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'reason.required' => 'Reason link is required!',
            'cv.required' => 'Resume is required!'
        ]);


        $application = new Application();
        $application->name = $request->name;
        $application->email = $request->email;
        $application->reason = $request->reason;
        $application->user_id = $user->id;

        $application_file = $request->file('cv');
        
        $filename = time().'.'.$application_file->getClientOriginalExtension();
        $application->cv = $filename;
        $destinationPath = 'uploads/applications/';
        $application_file->move($destinationPath,$application_file->getClientOriginalName());
        $application->save();

        
        $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

        $message = "Your application has been submitted successfully";
        return redirect()->action('HomeController@apply')->with(['success'=>$message, 'n'=>$n, 'user'=>$user]);
        
    }
}
