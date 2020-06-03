<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Image;
use App\User;
use App\Course;
use App\Schedule;
use App\CourseSchedule;
Use DB;
use App\Mynotification;
use App\Notice;

class NoticeController extends Controller
{
    
    public function index($id)
    {
        $page_name = 'Notice Page';
        $user = Auth::user();
        $course = Course::find($id);

        $notice = DB::table('notices')->where('notice_course_id', $id)->orderBy('id','DESC')->get();

        $notificationCount = DB::table('mynotifications')
                                ->where('n_status', 0)->count();
        $n = $notificationCount;


        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        return view('user.notice.list', compact('status','n','page_name', 'user', 'course', 'notice'));
    }

    
    public function create($id)
    {
        $page_name = "Post a new notice";
        $user = Auth::user();
        $course = Course::find($id);

        $notificationCount = DB::table('mynotifications')
        ->where('n_status', 0)->count();
        $n = $notificationCount;

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        return view('user.notice.create', compact('status','user','page_name', 'n', 'course'));
    }

    
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'notice_title' => 'required',
            'notice_content' => 'required',            
        ],[
            'notice_title.required' => 'Notice title is required!',
            'notice_content.required' => 'Notice content is required!',
        ]);

            $notice = new Notice();
            $notice->notice_title = $request->notice_title;
            $notice->notice_content = $request->notice_content;
            $notice->notice_course_id = $id;
            $notice->save();
        

        $page_name = 'Notice Page';
        $user = Auth::user();
        $course = Course::find($id);

        $notice = DB::table('notices')->where('notice_course_id', $id)->orderBy('id','DESC')->get();

        $notificationCount = DB::table('mynotifications')
                                ->where('n_status', 0)->count();
        $n = $notificationCount;

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }
        
        return view('user.notice.list',  compact('status','n','page_name', 'user', 'course', 'notice'))->with('success',"Notice posted Successfully!");
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

    
    public function destroy($id, $id1)
    {
        Notice::where('id', $id1)->delete();

        $page_name = 'Notice Page';
        $user = Auth::user();
        $course = Course::find($id);

        $notice = DB::table('notices')->where('notice_course_id', $id)->orderBy('id','DESC')->get();

        $notificationCount = DB::table('mynotifications')
                                ->where('n_status', 0)->count();
        $n = $notificationCount;

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }
        
        return view('user.notice.list',  compact('status','n','page_name', 'user', 'course', 'notice'))->with('success',"Notice posted Successfully!");
    }
}
