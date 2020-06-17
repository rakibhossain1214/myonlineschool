<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mynotification;
use Auth;
use Carbon\Carbon;
use DB;

class MynotificationController extends Controller
{
   
    public function index()
    {
        $notification = DB::table('mynotifications')
                            ->where('n_user_id', Auth::user()->id)
                            ->orderBy('id','DESC')->get();
        $user =  Auth::user();

        foreach($notification as $val){
            $notificationUpdate = Mynotification::find($val->id);
            $notificationUpdate->n_status = 1;
            $notificationUpdate->save();
        }

        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();

        return view('user.notification.list', compact('notification', 'user', 'n'));
    }

   
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
