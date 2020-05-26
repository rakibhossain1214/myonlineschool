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

        $notificationCount = DB::table('mynotifications')
                                ->where('n_status', 0)->count();
        $n = $notificationCount;

        return view('teacher.notes.list', compact('n','page_name', 'user', 'course', 'note'));
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

        $notificationCount = DB::table('mynotifications')
        ->where('n_status', 0)->count();
        $n = $notificationCount;

        return view('teacher.notes.create', compact('user','page_name', 'n', 'course'));
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

            $notificationCount = DB::table('mynotifications')
                                    ->where('n_status', 0)->count();
            $n = $notificationCount;

            return view('teacher.notes.list', compact('n','page_name', 'user', 'course', 'note'));
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
    public function destroy($id)
    {
        //
    }
}
