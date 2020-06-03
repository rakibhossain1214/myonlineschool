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
use App\UserSchedule;
Use DB;
use App\Mynotification;
use App\CourseStudent;
use App\Checkout;

class CourseController extends Controller
{
    
    public function index()
    {
       
        $user = Auth::user();

        if($user->type == 2){
            $page_name = "My instructing courses";
            $course = Course::where('c_teacher_id', Auth::user()->id)->get();

            $notificationCount = DB::table('mynotifications')
            ->where('n_status', 0)->count();
            $n = $notificationCount;

            return view('user.course.list', compact('user','page_name', 'course', 'n'));
        }
        else if($user->type == 1){
            $page_name = "My Courses";
            
            
            $courseSt = DB::table('course_students')->where('s_id', Auth::user()->id)->get();
            
            $courses = Course::all();

            $course = null;
            
            $k=0;
            foreach($courseSt as $value){
                foreach($courses as $val){
                    if($val->id == $value->c_id){
                        $course[$k] = $val;
                        $k++;
                    } 
                }
                
            }

           
            $notificationCount = DB::table('mynotifications')
            ->where('n_status', 0)->count();
            $n = $notificationCount;


            return view('user.course.liststudent', compact('user','page_name', 'course', 'n'));
        }
       
       
    }

    public function create()
    {
        $page_name = "Create a new course";
        $user = Auth::user();       

        $selectedPermission = DB::table('user_schedules')
                                ->where('user_schedules.user_id', Auth::user()->id)
                                ->pluck('schedule_id')->toArray();
        
        $totalSchedule = Schedule::all();
        $schedule = Schedule::pluck('time','id');

        
        $k=0;
        
            foreach($selectedPermission as $val){
                foreach($totalSchedule as $value){
                    if($value->id == $val){
                        $schedule[$k] = null;
                        $k++;
                    }
                } 
            }
            
           
        $notificationCount = DB::table('mynotifications')
                                ->where('n_status', 0)->count();
        $n = $notificationCount;

        return view('user.course.create', compact('user','page_name', 'schedule', 'n'));

    }

   
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'c_name' => 'required',
            'c_curriculum' => 'required',
            'c_link' => 'required',
            'c_image' => 'required',
            'schedule' => 'required|array|min:2',
            
        ],[
            'c_name.required' => 'Course name is required!',
            'c_curriculum.required' => 'Course curriculum is required!',
            'c_link.required' => 'Course class link is required!',
            'c_image.required' => 'Course image is required!',
            'schedule.required' => 'Schedule is required',
        ]);

        $course = new Course();
        $course->c_name = $request->c_name;
        $course->c_curriculum = $request->c_curriculum;
        $course->c_link = $request->c_link;
        $course->c_teacher_id = Auth::user()->id;
        $course->c_teacher_name = Auth::user()->name;
        $image = $request->file('c_image');
        $filename = time().'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save( public_path('uploads/courses/'.$filename));
        $course->c_image = $filename;
        $course->save();
        

        foreach($request->schedule as $value){
            $user_schedules = new UserSchedule();
            $user_schedules->user_id = Auth::user()->id;
            $user_schedules->schedule_id = $value;
            $user_schedules->course_id = $course->id;
            $user_schedules->save();
        }

        foreach($request->schedule as $value){
            $course_schedules = new CourseSchedule();
            $course_schedules->course_id = $course->id;
            $course_schedules->schedule_id = $value;
            $course_schedules->save();
        }

        $notification = new Mynotification();
        $notification->notification = "You have created a new course!";
        $notification->n_user_id = Auth::user()->id;
        $notification->n_status = 0;
        $notification->save();

    
        

        return redirect()->action('Course\CourseController@index')->with('success',"Course Created Successfully!");

    
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        
        
        $page_name = 'Course Edit';
        $user = Auth::user();
        $course = Course::find($id);
        
        $selectedPermission = DB::table('user_schedules')
                                ->where('user_schedules.user_id', Auth::user()->id)
                                ->pluck('schedule_id')->toArray();

        $selectedSchedule = DB::table('course_schedules')
                                ->where('course_schedules.course_id', $id)
                                ->pluck('schedule_id')->toArray();
                       


        $totalSchedule = Schedule::all();
        $schedule = Schedule::pluck('time','id');

        
        $k=0;
        
            foreach($selectedSchedule as $val){
                foreach($totalSchedule as $value){
                    if($value->id == $val){
                        $courseSelectedPermission[$k] = $value->where('id', $val)->pluck('time');
                        $schedule[$k] = null;   
                        $k++;
                    }
                } 
            }
        
         
        

        $notificationCount = DB::table('mynotifications')
                                ->where('n_status', 0)->count();
        $n = $notificationCount;

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }


        return view('user.course.edit', compact('status','n','page_name', 'user','course', 'schedule', 'courseSelectedPermission'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'c_name' => 'required',
            'c_curriculum' => 'required',
            'c_link' => 'required',
            'schedule' => 'required|array|min:2',
            
        ],[
            'c_name.required' => 'Course name is required!',
            'c_curriculum.required' => 'Course curriculum is required!',
            'c_link.required' => 'Course class link is required!',
            'schedule.required' => 'Schedule is required',
        ]);

        $course = Course::find($id);
        $course->c_name = $request->c_name;
        $course->c_curriculum = $request->c_curriculum;
        $course->c_link = $request->c_link;
        $course->c_teacher_id = Auth::user()->id;
        $course->c_teacher_name = Auth::user()->name;
        
        $course->save();

        DB::table('course_schedules')->where('course_id', $id)->delete();
        DB::table('user_schedules')->where('course_id', $id)->delete();

        foreach($request->schedule as $value){
            $user_schedules = new UserSchedule();
            $user_schedules->user_id = Auth::user()->id;
            $user_schedules->schedule_id = $value;
            $user_schedules->course_id = $id;
            $user_schedules->save();
        }

        foreach($request->schedule as $value){
            $course_schedules = new CourseSchedule();
            $course_schedules->course_id = $id;
            $course_schedules->schedule_id = $value;
            $course_schedules->save();
        }

        $notification = new Mynotification();
        $notification->notification = "You have updated '".$course->c_name."'";
        $notification->n_user_id = Auth::user()->id;
        $notification->n_status = 0;
        $notification->save();

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }


        return redirect()->action('Course\CourseController@index')->with(['status'=>$status,'success'=>"Course Updated Successfully!"]);
    }

   
    public function destroy($id)
    {
        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        UserSchedule::where('course_id', $id)->delete();
        CourseSchedule::where('course_id', $id)->delete();
        Course::where('id', $id)->delete();

        return redirect()->action('Course\CourseController@index')->with(['status'=>$status,'success'=>"Course Deleted Successfully!"]);
    }

//course
    public function view($id)
    {
        
        $page_name = 'Course Page';
        $user = Auth::user();
        $course = Course::find($id);
        
        $selectedPermission = DB::table('course_schedules')
                                ->where('course_schedules.course_id', $id)
                                ->pluck('schedule_id')->toArray();

        $totalschedule = Schedule::all();

        $i=0;
        foreach($selectedPermission as $val){
            foreach($totalschedule as $s){
                if($val==$s->id){
                    $schedule[$i] = $s->where('id', $val)->pluck('time');
                    $i++;
                }
            }

        }

        $notificationCount = DB::table('mynotifications')
                                ->where('n_status', 0)->count();
        $n = $notificationCount;


        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }
        $message = "";

        return view('user.course.view', compact('status','n','page_name', 'user','course', 'schedule', 'selectedPermission', 'message'));
    }

    public function updateCoursePhoto(Request $request, $id)
    {
        if($request->hasFile('c_image')){
            $c_image = $request->file('c_image');
            $filename = time().'.'.$c_image->getClientOriginalExtension();
            Image::make($c_image)->resize(300,300)->save( public_path('uploads/courses/'.$filename));
        
            $course = Course::find($id);
            $course->c_image = $filename;
            $course->save();

            $notification = DB::table('mynotifications')
                        ->where('n_status', 0)->count();
            $n = $notification;
            
            $page_name = "Course Image Update";

            $user = Auth::user();

            $selectedPermission = DB::table('user_schedules')
                                ->where('user_schedules.course_id', $id)
                                ->pluck('schedule_id')->toArray();

            $totalschedule = Schedule::all();
            $i=0;
            foreach($selectedPermission as $val){
                foreach($totalschedule as $s){
                    if($val==$s->id){
                        $schedule[$i] = $s->where('id', $val)->pluck('time');
                        $i++;
                    }
                }

            }

            $status = 0;

            $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
            if($statusChecker != null)
            {
                $status = 1;
            }

            return view('user.course.view', compact('status','user','page_name', 'course', 'n', 'schedule'));
        }
    }

    public function video($id){

        $course = Course::find($id);
        $notification = DB::table('mynotifications')
                            ->where('n_status', 0)->count();
        $n = $notification;
        $page_name = "Course Image Update";
        $user = Auth::user();

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        return view('user.course.video', compact('status','user','page_name', 'course', 'n'));
    }

    public function courseStudent($id){
        $course = Course::find($id);
        $notification = DB::table('mynotifications')
                            ->where('n_status', 0)->count();
        $n = $notification;
        $page_name = "Course Enrolled Students";
        $user = Auth::user();

        $students = DB::table('course_students')
                        ->where('c_id', $id)->get();

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        return view('user.students.list', compact('status','user','page_name', 'course', 'n', 'students'));
    }


    public function bookCourse($id){
        $page_name = 'Book Your Course';
        $user = Auth::user();
        $course = Course::find($id);
        
        $selectedPermission = DB::table('course_schedules')
                                ->where('course_schedules.course_id', $id)
                                ->pluck('schedule_id')->toArray();

        $totalschedule = Schedule::all();

        $i=0;
        foreach($selectedPermission as $val){
            foreach($totalschedule as $s){
                if($val==$s->id){
                    $schedule[$i] = $s->where('id', $val)->pluck('time');
                    $i++;
                }
            }

        }

        $notificationCount = DB::table('mynotifications')
                                ->where('n_status', 0)->count();
        $n = $notificationCount;


        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        //userschedule save

        $userSelectedPermission = DB::table('user_schedules')
                                ->where('user_schedules.user_id', Auth::user()->id)
                                ->pluck('schedule_id')->toArray();

        $timeClash = 0;
        foreach($selectedPermission as $sp){
            foreach($userSelectedPermission as $usp){
                if($sp == $usp){
                    $timeClash = 1;
                }
            }
        }

        if($timeClash == 0){
            return view('user.course.book', compact('status','n','page_name', 'user','course', 'schedule', 'selectedPermission'));
        }else{
            $message = "You cannot book this course. You have other classes in this time.";
            return view('user.course.success', compact('status','n','page_name', 'user','course', 'schedule', 'selectedPermission','message'));
        }
        
    }
    

    public function bookCourseStore( Request $request, $id){

        $this->validate($request, [
            's_name' => 'required',
            's_email' => 'required',
            'amount' => 'required',
            'bkash_account' => 'required',
            'trx_id' => 'required',
            
        ],[
            's_name.required' => 'Student name is required!',
            's_email.required' => 'Student curriculum is required!',
            'amount.required' => 'Amount is required!',
            'bkash_account.required' => 'Bkash Account is required!',
            'trx_id.required' => 'Transaction id is required',
        ]);

        $course = Course::find($id);

        $checkout = new Checkout();
        $checkout->c_id = $course->id;
        $checkout->c_name = $course->c_name;
        $checkout->s_id = Auth::user()->id;
        $checkout->s_name = $request->s_name;
        $checkout->s_email = $request->s_email;
        $checkout->amount = $request->amount;
        $checkout->bkash_account = $request->bkash_account;
        $checkout->trx_id = $request->trx_id;
        $checkout->order_status = 0;
        $checkout->save();

        $page_name = 'Course Page';
        $user = Auth::user();
        $course = Course::find($id);
        
        $selectedPermission = DB::table('course_schedules')
                                ->where('course_schedules.course_id', $id)
                                ->pluck('schedule_id')->toArray();

        $totalschedule = Schedule::all();

        $i=0;
        foreach($selectedPermission as $val){
            foreach($totalschedule as $s){
                if($val==$s->id){
                    $schedule[$i] = $s->where('id', $val)->pluck('time');
                    $i++;
                }
            }

        }

//user-schedule        
        foreach($selectedPermission as $value){
            $user_schedules = new UserSchedule();
            $user_schedules->user_id = Auth::user()->id;
            $user_schedules->schedule_id = $value;
            $user_schedules->course_id = $id;
            $user_schedules->save();
        }



        $notificationCount = DB::table('mynotifications')
                                ->where('n_status', 0)->count();
        $n = $notificationCount;


        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        $message = "You have successfully booked the course. Your course in now under review. It may take 24 hours.";
        

        return view('user.course.success', compact('status','n','page_name', 'user','course', 'schedule', 'selectedPermission','message'));
    }


    

}
