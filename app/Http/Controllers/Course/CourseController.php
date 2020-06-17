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
use App\Report;
class CourseController extends Controller
{
    
    public function index()
    {
       
        $user = Auth::user();

        if($user->type == 2 || $user->type == 3){
            $page_name = "My instructing courses";
            $course = Course::where('c_teacher_id', Auth::user()->id)->get();

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

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

           
            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();


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
            
           
            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

        $teacher =  DB::table('users')
                    ->where('type', 2)->pluck('name','id');
        
        return view('user.course.create', compact('teacher', 'user','page_name', 'schedule', 'n'));

    }

   
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'c_name' => 'required',
            'c_curriculum' => 'required',
            'c_link' => 'required',
            'c_image' => 'required',
            'schedule' => 'required|array|min:2',
            'teacher' => 'required|array|min:1',
            
        ],[
            'c_name.required' => 'Course name is required!',
            'c_curriculum.required' => 'Course curriculum is required!',
            'c_link.required' => 'Course class link is required!',
            'c_image.required' => 'Course image is required!',
            'schedule.required' => 'Schedule is required',
            'teacher.required' => 'Teacher is required',
        ]);

        
        
        $date1 = date_create($request->start_date);
        $date2 = date_create($request->end_date);
        $interval = date_diff($date1,$date2);
        $days = $interval->format("%R%a");

        foreach($request->teacher as $teach){
            $teacherId = $teach;
        }

        $teacherName = User::find($teacherId);
        

        if($days>30){
            $course = new Course();
            $course->c_name = $request->c_name;
            $course->c_curriculum = $request->c_curriculum;
            $course->c_link = $request->c_link;
            $course->c_teacher_id = $teacherId;
            $course->c_teacher_name = $teacherName->name;
            $course->availability = 0;
            $image = $request->file('c_image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save( public_path('uploads/courses/'.$filename));
            $course->c_image = $filename;
            $course->start_date = $request->start_date;
            $course->end_date = $request->end_date;
            $course->save();
            

            foreach($request->schedule as $value){
                $user_schedules = new UserSchedule();
                $user_schedules->user_id = $teacherId;
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
            $notification->n_user_id = $teacherId;
            $notification->n_status = 0;
            $notification->save();
        
        }
        
        if($days>30){
            return redirect()->action('Course\CourseController@index')->with('success',"Course Created Successfully!");
        }else{
            return redirect()->action('Course\CourseController@create')->with('success',"Course duration must be minimum 1 month!");
        }
    
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
        
         
        

         $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

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

        $date1 = date_create($request->start_date);
        $date2 = date_create($request->end_date);
        $interval = date_diff($date1,$date2);
        $days = $interval->format("%R%a");


        if($days>0){
        $course = Course::find($id);
        $course->c_name = $request->c_name;
        $course->c_curriculum = $request->c_curriculum;
        $course->c_link = $request->c_link;
        $course->start_date = $request->start_date;
        $course->end_date = $request->end_date;
        $course->save();

        DB::table('course_schedules')->where('course_id', $id)->delete();
        DB::table('user_schedules')->where('course_id', $id)->delete();

        foreach($request->schedule as $value){
            $user_schedules = new UserSchedule();
            $user_schedules->user_id =$course->c_teacher_id;
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
        $notification->notification = "Your '".$course->c_name."'has been updated";
        $notification->n_user_id = $course->c_teacher_id;
        $notification->n_status = 0;
        $notification->save();

        $allCourseStudents = DB::select('select * from course_students where c_id=?',[$course->id]);
            foreach($allCourseStudents as $courseStudent){
                $notificationStudent = new Mynotification();
                $notificationStudent->notification = "Your booked course'".$course->c_name."'has been updated";
                $notificationStudent->n_user_id = $courseStudent->s_id;
                $notificationStudent->n_status = 0;
                $notificationStudent->save();
            }
        }

        $status = 0;

        $statusChecker1 =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);
        $statusChecker2 =  DB::select('select * from courses where c_teacher_id=?', [$id, Auth::user()->id]);
        if($statusChecker1 != null || $statusChecker2 != null)
        {
            $status = 1;
        }


       
    
        if($days>30){
            return redirect()->action('Course\CourseController@index')->with(['status'=>$status,'success'=>"Course Updated Successfully!"]);
        }else{
            return redirect()->to('dashboard/course/edit/'.$course->id)->with(['status'=>$status,'success'=>"Minimum course duration is 1 month!"]); 
        }
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

        $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

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

            
            $page_name = "Course Image Update";

            $user = Auth::user();

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

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
       
        $page_name = "Course Image Update";
        $user = Auth::user();

        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        return view('user.course.video', compact('status','user','page_name', 'course', 'n'));
    }

    public function updateStatus(Request $request, $id){
        $course = Course::find($id);
        
        if($request->availability == 'Online'){
            $course->availability = 1;
        }else if($request->availability == 'Offline'){
            $course->availability = 0;
        }else if($request->availability == 'Away'){
            $course->availability = 2;
        }else if($request->availability == 'Busy'){
            $course->availability = 3;
        }        
        $course->save();

       
        $page_name = "Live Class";
        $user = Auth::user();

        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        $allCourseStudents = DB::select('select * from course_students where c_id=?',[$course->id]);
            foreach($allCourseStudents as $courseStudent){
                $notificationStudent = new Mynotification();
                $notificationStudent->notification = "Your booked course'".$course->c_name."' teacher is in ".$request->availability;
                $notificationStudent->n_user_id = $courseStudent->s_id;
                $notificationStudent->n_status = 0;
                $notificationStudent->save();
            }
        


        return view('user.course.video', compact('status','user','page_name', 'course', 'n'));
    }

    public function courseStudent($id){
        $course = Course::find($id);
        
        $page_name = "Course Enrolled Students";
        $user = Auth::user();

        $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

        $students = DB::table('course_students')
                        ->where('c_id', $id)->get();

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        $isTeacher = 0;
        $teacherChecker =  DB::select('select * from courses where id=? and c_teacher_id=?', [$id, Auth::user()->id]);;
        if($teacherChecker != null)
        {
            $isTeacher = 1;
        }
        $message = null;
        return view('user.students.list', compact('isTeacher','message','course','status','user','page_name', 'course', 'n', 'students'));
    }

    public function courseStudentEdit($id, $id1){
        $course = Course::find($id);
        
        $page_name = "Update Result";
        $user = Auth::user();


        $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

        $student = CourseStudent::find($id1);

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        return view('user.students.edit', compact('course','status','user','page_name', 'n', 'student'));
    }




    public function courseStudentStore(Request $request, $id, $id1){
        
        $result = CourseStudent::find($id1);
        $result->s_marks = $request->s_marks;
        $result->s_grade = $request->s_grade;
        $result->save();

        $course = Course::find($id);
       
        $page_name = "Course Enrolled Students";
        $user = Auth::user();

        $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

        $students = DB::table('course_students')
                        ->where('c_id', $id)->get();

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        $isTeacher = 0;
        $teacherChecker =  DB::select('select * from courses where id=? and c_teacher_id=?', [$id, Auth::user()->id]);;
        if($teacherChecker != null)
        {
            $isTeacher = 1;
        }
        $message = null;

        $message = "Student's result is updated successfully!";
        return view('user.students.list', compact('isTeacher','message','course','status','user','page_name', 'course', 'n', 'students'));
    }

    public function courseStudentDelete($id, $id1){
        DB::table('course_students')->where('id', $id1)->delete();
        $course = Course::find($id);
       
        $page_name = "Course Enrolled Students";
        $user = Auth::user();

        $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

        $students = DB::table('course_students')
                        ->where('c_id', $id)->get();

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        $isTeacher = 0;
        $teacherChecker =  DB::select('select * from courses where id=? and c_teacher_id=?', [$id, Auth::user()->id]);;
        if($teacherChecker != null)
        {
            $isTeacher = 1;
        }

       
        $message = "Student deleted successfully!";
        
        return view('user.students.list', compact('isTeacher','message','course','status','user','page_name', 'course', 'n', 'students'));
    }


    //booking
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

        $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();


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



        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();


        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        $message = "You have successfully booked the course. Your course in now under review. It may take 24 hours.";
        

        return view('user.course.success', compact('status','n','page_name', 'user','course', 'schedule', 'selectedPermission','message'));
    }


    public function report($id)
    {
        
        $page_name = 'Report Page';
        $user = Auth::user();
        $course = Course::find($id);

        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();


        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }
        $message = "";

        return view('user.course.report', compact('status','n','page_name', 'user','course', 'message'));
    }

    public function storeReport(Request $request, $id)
    {

        $user = Auth::user();
        $course = Course::find($id);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'reason' => 'required',
            
        ],[
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'reason.required' => 'Reason link is required!',
        ]);


        $report = new Report();
        $report->name = $request->name;
        $report->email = $request->email;
        $report->course_id = $id;
        $report->course_name = $course->c_name;
        $report->report = $request->reason;
        $report->user_id = $user->id;
        $report->save();

        
        $page_name = 'Report Page';
      
      

        $n = DB::table('mynotifications')
        ->where('n_status', 0)
        ->where('n_user_id', $user->id)
        ->count();

        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);;
        if($statusChecker != null)
        {
            $status = 1;
        }

        $message = "Your report has been submitted successfully";
       
        return view('user.course.report', compact('status','n','page_name', 'user','course', 'message'));
        
    }

}
