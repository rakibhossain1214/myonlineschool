<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Image;
use App\User;
use App\Message;
Use DB;
use App\Mynotification;

class MessageController extends Controller
{
   
    public function index()
    {
        $page_name = "Received Messages";
        $user = Auth::user();

        $mymessage = Message::where('m_receiver_id', Auth::user()->id)->get();
        
        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();

        return view('user.message.list', compact('user','page_name', 'mymessage', 'n'));
    }

    public function api()
    {
       
        $user = Auth::user();

        $mymessage = Message::where('m_receiver_id', Auth::user()->id)->get();
        
        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();

        $details = array("messages"=>"", "token"=>"");
        $details["messages"] = $mymessage;
        $details["token"] = Auth::user()->createToken(config('vms.myToken'))->accessToken;

        return $details;
    }

    public function sent()
    {
        $page_name = "Sent Messages";
        $user = Auth::user();

        $mymessage = Message::where('m_sender_id', Auth::user()->id)->get();
        
        $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

        return view('user.message.sent', compact('user','page_name', 'mymessage', 'n'));
    }

    public function read($id)
    {
        $page_name = "Received Messages";
        $user = Auth::user();

        $mymessage = Message::find($id);
        $mymessage->m_status = 1;
        $mymessage->save();

        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();

        return view('user.message.read', compact('user','page_name', 'mymessage', 'n'));
    }

   
    public function create()
    {
        $page_name = "Send a new message";
        $user = Auth::user();

        $users = User::pluck('name','id');

        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();

        return view('user.message.create', compact('user','page_name','users', 'n'));
    }

    
    public function store(Request $request)
    {
         
        $this->validate($request, [
            'm_title' => 'required',
            'm_text' => 'required',
            'users' => 'required',
            
        ],[
            'm_title.required' => 'Message title is required!',
            'm_text.required' => 'Message text is required!',
            'users.required' => 'Message receiver is required',
        ]);

        foreach($request->users as $value){
            $message = new Message();
            $message->m_title = $request->m_title;
            $message->m_text = $request->m_text;
            $message->m_sender_id = Auth::user()->id;
            $message->m_sender_name = Auth::user()->name;
            $message->m_receiver_id = $value;
            $tempUser = User::find($value);
            $message->m_receiver_name = $tempUser->name;
            $message->m_status = 0;
            $message->save();
        }

        
        return redirect()->action('Course\MessageController@sent')->with('success',"Message sent Successfully!");

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
