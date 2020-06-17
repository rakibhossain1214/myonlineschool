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
use App\AssignmentTeacher;
use App\AssignmentStudent;
Use DB;
use App\Mynotification;
use App\Note;
use Carbon\Carbon;
class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $page_name = 'Course Assignments';
        $user = Auth::user();
        $course = Course::find($id);

        $assignment = DB::table('assignment_teachers')->where('assignment_course_id', $id)->orderBy('id','DESC')->get();

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

        $mymessage = null;
        return view('user.assignment.list', compact('assignment','status','n','page_name', 'user', 'course', 'mymessage'));
    }

  
    public function create($id)
    {
        $page_name = "Add a new Assignment";
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
        $errormessage = null;
        return view('user.assignment.create', compact('status','user','page_name', 'n', 'course', 'errormessage'));
    }

   
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'assignment_title' => 'required',
            'assignment_description' => 'required',
            'assignment_total_marks' => 'required',    
            'assignment_file_teacher' => 'required',  
            'assignment_deadline' => 'required',      
                      
        ],[
            'assignment_title.required' => 'Assignment title is required!',
            'assignment_description.required' => 'Assignment description is required!',
            'assignment_total_marks.required' => 'Assignment total marks is required!',
            'assignment_file_teacher.required' => 'Assignment file is required!',
            'assignment_deadline.required' => 'Assignment deadline is required!',
        ]);
        
        
        $mytime = Carbon::now();
        $date1 = date_create($mytime->toDateString());
        $date2 = date_create($request->assignment_deadline);
        $interval = date_diff($date1,$date2);
        $days = $interval->format("%R%a");
        
        if($request->hasFile('assignment_file_teacher') && $days>0){

            
            $assignment_file_teacher = $request->file('assignment_file_teacher');
            $filename = time().'.'.$assignment_file_teacher->getClientOriginalExtension();
        
            $assignment = new AssignmentTeacher();
            $assignment->assignment_title = $request->assignment_title;
            $assignment->assignment_description = $request->assignment_description;
            $assignment->assignment_total_marks = $request->assignment_total_marks;
            $assignment->assignment_file_teacher = $filename;
            $assignment->assignment_course_id = $id;
            $assignment->assignment_deadline = $request->assignment_deadline;
            $assignment->assignment_teacher_id = Auth::user()->id;
            $destinationPath = 'uploads/courses/assignments/';
            $assignment_file_teacher->move($destinationPath,$assignment_file_teacher->getClientOriginalName());
            $assignment->save();

        
        $page_name = 'Course Assignments';
        $user = Auth::user();
        $course = Course::find($id);

        $assignment = DB::table('assignment_teachers')->where('assignment_course_id', $id)->orderBy('id','DESC')->get();

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
                $notificationStudent->notification = "Your booked course'".$course->c_name."' has posted a new assignment.";
                $notificationStudent->n_user_id = $courseStudent->s_id;
                $notificationStudent->n_status = 0;
                $notificationStudent->save();
            }

        $mymessage = "Assignment is added successfully!";
        return view('user.assignment.list', compact('assignment','status','n','page_name', 'user', 'course', 'mymessage'));
        }else{
            $page_name = "Add a new Assignment";
            $user = Auth::user();
            $course = Course::find($id);
    
            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();
    
            $status = 0;
    
            $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);
            if($statusChecker != null)
            {
                $status = 1;
            }
            $errormessage = "Not a valid date!";
            return view('user.assignment.create', compact('status','user','page_name', 'n', 'course', 'errormessage'));
        }
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
        AssignmentTeacher::where('id', $id1)->delete();
        AssignmentStudent::where('assignment_id', $id1)->delete();

        $page_name = 'Course Assignments';
        $user = Auth::user();
        $course = Course::find($id);

        $assignment = DB::table('assignment_teachers')->where('assignment_course_id', $id)->orderBy('id','DESC')->get();

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

        $mymessage = "Assignment is deleted successfully!";
        return view('user.assignment.list', compact('assignment','status','n','page_name', 'user', 'course', 'mymessage'));
    }

//assignment-student

    public function submit($id, $id1)
    {
        $page_name = 'Submit Assignment';
        $user = Auth::user();
        $course = Course::find($id);

        $assignment = AssignmentTeacher::find($id1);

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
        $errormessage = null;
        return view('user.assignment.submit', compact('errormessage','assignment','status','n','page_name', 'user', 'course'));
    }


    public function assignmentStore(Request $request, $id, $id1)
    {
        $this->validate($request, [
            'assignment_file_student' => 'required',        
        ],[
            'assignment_file_student.required' => 'Assignment file is required!',
        ]);
        
        
        $assignmentTeacher = AssignmentTeacher::find($id1);
        
        $mytime = Carbon::now();
        $date1 = date_create($mytime->toDateString());
        $date2 = date_create($assignmentTeacher->assignment_deadline);
        $interval = date_diff($date1,$date2);
        $days = $interval->format("%R%a");
        

        if($request->hasFile('assignment_file_student') && $days>0){

            
            $assignment_file_student= $request->file('assignment_file_student');
            $filename = time().'.'.$assignment_file_student->getClientOriginalExtension();
        
            $assignment = new AssignmentStudent();
            $assignment->assignment_course_id = $id;
            $assignment->assignment_teacher_id = $assignmentTeacher->assignment_teacher_id;
            $assignment->assignment_student_id = Auth::user()->id;
            $assignment->assignment_total_marks = $assignmentTeacher->assignment_total_marks;
            $assignment->assignment_obtained_marks = 0;
            $assignment->assignment_title = $assignmentTeacher->assignment_title;
            $assignment->assignment_id = $assignmentTeacher->id;
            $assignment->assignment_file_student = $filename;
            $destinationPath = 'uploads/courses/assignments/submissions/';
            $assignment_file_student->move($destinationPath,$assignment_file_student->getClientOriginalName());
            $assignment->save();

        
        $page_name = 'Course Assignments';
        $user = Auth::user();
        $course = Course::find($id);

        $assignment = AssignmentTeacher::find($id1);

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

       
            
            $notificationStudent = new Mynotification();
            $notificationStudent->notification = "An assinment is submitted to your instructing course '".$course->c_name."'";
            $notificationStudent->n_user_id = $course->c_teacher_id;
            $notificationStudent->n_status = 0;
            $notificationStudent->save();
            
        
        $errormessage = "Assignment Submitted Successfully!";
        return view('user.assignment.submit', compact('errormessage','assignment','status','n','page_name', 'user', 'course'));
        
        }else{

        $page_name = 'Submit Assignment';
        $user = Auth::user();
        $course = Course::find($id);

        $assignment = AssignmentTeacher::find($id1);

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
        $errormessage = "Assignment date is expired!";
        return view('user.assignment.submit', compact('errormessage','assignment','status','n','page_name', 'user', 'course'));
        }
    }

    //marks
    public function assignmentMarks($id)
    {
        $page_name = 'Assignment Marks';
        $user = Auth::user();
        $course = Course::find($id);

        $assignment = DB::select('select * from assignment_students where assignment_course_id=? and assignment_student_id=? order by created_at desc', [$id, Auth::user()->id]);

        $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();
        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);
        if($statusChecker != null)
        {
            $status = 1;
        }
        
        return view('user.assignment.marks', compact('assignment','status','n','page_name', 'user', 'course'));
    }

    //submissions
    public function assignmentSubmissions($id,$id1)
    {
        $page_name = 'Assignment Marks';
        $user = Auth::user();
        $course = Course::find($id);

        
        $assignment = DB::select('select * from assignment_students where assignment_id=? order by created_at desc', [$id1]);

        $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();
        $status = 0;

        $statusChecker =  DB::select('select * from course_students where c_id=? and s_id=?', [$id, Auth::user()->id]);
        if($statusChecker != null)
        {
            $status = 1;
        }
        
        return view('user.assignment.submission', compact('assignment','status','n','page_name', 'user', 'course'));
    }

//evaluation
    public function evaluate($id, $id1)
    {
        $page_name = 'Submit Assignment';
        $user = Auth::user();
        $course = Course::find($id);

        $assignment = DB::select('select * from assignment_students where id=?',[$id1]);
        
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
        $errormessage = null;
        return view('user.assignment.evaluate', compact('errormessage','assignment','status','n','page_name', 'user', 'course'));
    }


    public function evaluateStore(Request $request, $id, $id1)
    {
        $this->validate($request, [
            'assignment_obtained_marks' => 'required',        
        ],[
            'assignment_obtained_marks.required' => 'Assignment obtained marks is required!',
        ]);
        
        
        $assignmentStudent = AssignmentStudent::find($id1);
        
        $marksOk = 1;
        
        if($request->assignment_obtained_marks > $assignmentStudent->assignment_total_marks){
            $marksOk = 0;
        }
        
        
        if($marksOk == 1){
        
            $assignment = AssignmentStudent::find($id1);
            $assignment->assignment_obtained_marks = $request->assignment_obtained_marks;
            $assignment->save();

        
            $page_name = 'Submit Assignment';
            $user = Auth::user();
            $course = Course::find($id);
    
            $assignment = DB::select('select * from assignment_students where id=?',[$id1]);
            
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


           
                $notificationStudent = new Mynotification();
                $notificationStudent->notification = "Your booked course'".$course->c_name."' teacher has updated your assignment marks";
                $notificationStudent->n_user_id = $assignmentStudent->assignment_student_id;
                $notificationStudent->n_status = 0;
                $notificationStudent->save();
            
            

            $errormessage = "Marks given successfully!";
            return view('user.assignment.evaluate', compact('errormessage','assignment','status','n','page_name', 'user', 'course'));
        
        }else{

            $page_name = 'Submit Assignment';
            $user = Auth::user();
            $course = Course::find($id);
    
            $assignment = DB::select('select * from assignment_students where id=?',[$id1]);
            
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
            $errormessage = "Obtained marks is not valid!";
            return view('user.assignment.evaluate', compact('errormessage','assignment','status','n','page_name', 'user', 'course'));
        }
    }
}
