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
use App\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $page_name = 'Upload Notes';
        $user = Auth::user();
        $course = Course::find($id);

        $note = DB::table('notes')->where('note_course_id', $id)->orderBy('id','DESC')->get();

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

        return view('user.notes.list', compact('status','n','page_name', 'user', 'course', 'note'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $page_name = "Post a new notice";
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

        return view('user.notes.create', compact('status','user','page_name', 'n', 'course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'note_title' => 'required',
            'note_content' => 'required',            
        ],[
            'note_title.required' => 'Note title is required!',
            'note_content.required' => 'Note content is required!',
        ]);
        
        if($request->hasFile('note_content')){
            $note_content = $request->file('note_content');
            $filename = time().'.'.$note_content->getClientOriginalExtension();
        
            $mynote = new Note();
            $mynote->note_title = $request->note_title;
            $mynote->note_content = $filename;
            $mynote->note_course_id = $id;
            $destinationPath = 'uploads/courses/notes';
            $note_content->move($destinationPath,$note_content->getClientOriginalName());

            $mynote->save();

            $page_name = 'Upload Notes';
            $user = Auth::user();
            $course = Course::find($id);

            $note = DB::table('notes')->where('note_course_id', $id)->orderBy('id','DESC')->get();

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
                $notificationStudent->notification = "Your booked course'".$course->c_name."' has posted a new note! ";
                $notificationStudent->n_user_id = $courseStudent->s_id;
                $notificationStudent->n_status = 0;
                $notificationStudent->save();
            }

            return view('user.notes.list', compact('status','n','page_name', 'user', 'course', 'note'));
            }
    }


    public function download($id, $id1)
    {
        $destination = public_path('uploads\courses\notes');
        $pathToFile = $destination.$id1;
        return response()->download($pathToFile, $id1);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $id1)
    {
        Note::where('id', $id1)->delete();

        $page_name = 'Note Page';
        $user = Auth::user();
        $course = Course::find($id);

        $note = DB::table('notes')->where('note_course_id', $id)->orderBy('id','DESC')->get();

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
        
        return view('user.notes.list',  compact('status','n','page_name', 'user', 'course', 'note'))->with('success',"Note deleted Successfully!");
    }
}
