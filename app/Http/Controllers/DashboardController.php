<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Auth;
use Image;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Mynotification;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $notification = DB::table('mynotifications')
                        ->where('n_status', 0)->count();

        return view('user.profile.profile', array('user' => Auth::user(), 'n' => $notification));
    }

    public function updateAvatar(Request $request)
    {
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save( public_path('uploads/avatars/'.$filename));
        
            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();

            $notification = DB::table('mynotifications')
                        ->where('n_status', 0)->count();
            $n = $notification;
            return view('user.profile.profile', compact('user', 'n'));
        }
    }

    public function location(){
            
            $notification = DB::table('mynotifications')
            ->where('n_status', 0)->count();

            return view('user.profile.mylocation', array('user' => Auth::user(), 'n' => $notification));
    }


    public function edit($id)
    {
        $page_name = 'Profile Edit';
        $user = User::find($id);
        
        $notification = DB::table('mynotifications')
                    ->where('n_status', 0)->count();
        
        $n = $notification;

        return view('user.profile.edit', compact('page_name', 'user', 'n'));
    }

   
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ],[
            'name.required' => 'Name field is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required'
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->action('DashboardController@index')->with('success', 'Profile updated successfully!');
    }

    
}
