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
class CourseController extends Controller
{
    
    public function index()
    {
        //
    }

    public function create()
    {
        $page_name = "Create a new course";
        $user = Auth::user();

        $schedule = Schedule::pluck('time','id');
        return view('teacher.course.create', compact('user','page_name', 'schedule'));

    }

   
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'c_name' => 'required',
            'c_curriculum' => 'required',
            'c_link' => 'required',
            'c_image' => 'required',
            'schedule' => 'required',
            
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
            $course_schedules = new CourseSchedule();
            $course_schedules->course_user_id = Auth::user()->id;
            $course_schedules->schedule_id = $value;
            $course_schedules->save();
        }

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
        $schedule = Schedule::pluck('time','id');
        $selectedPermission = DB::table('course_schedules')
                                ->where('course_schedules.course_user_id', Auth::user()->id)
                                ->pluck('schedule_id')->toArray();
        
        return view('teacher.course.create', compact('page_name', 'user','course', 'schedule', 'selectedPermission'));
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
