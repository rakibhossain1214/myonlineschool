<?php

namespace App\Http\Controllers\Admin;

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
use App\Checkout;
use Carbon\Carbon;
use App\CourseStudent;
use App\Application;
use App\Report;

use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if($user->type == 3){
            $page_name = "All courses";
            $course = Course::all();

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

           
            return view('user.course.list', compact('user','page_name', 'course', 'n'));
        }
       
    }

    public function checkout()
    {
        $user = Auth::user();

        if($user->type == 3){
            $page_name = "Manage Bookings";
            $checkout = DB::select('Select * from checkouts order by id desc');

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            return view('user.admin.checkoutlist', compact('user','page_name', 'checkout', 'n'));
        }
       
    }

    public function manage($id)
    {
        $checkout = Checkout::find($id);

        if($checkout->order_status == 0){
            $checkout->order_status = 1;
            $message = "Booking is Approved Successfully!";

            $courseStudent = new CourseStudent();
            $courseStudent->c_id = $checkout->c_id;
            $courseStudent->s_id = $checkout->s_id;
            $courseStudent->s_name = $checkout->s_name;
            $courseStudent->s_marks = 0;
            $courseStudent->s_grade = "-";
            $courseStudent->save();
        }else{
            $checkout->order_status = 0;
            $message = "Booking is Rejected Successfully!";
            DB::table('course_students')->where('c_id', $checkout->c_id)->delete();
           
        }
        $checkout->save();


        
        return redirect()->action('Admin\AdminController@checkout')->with(['success'=>$message]);
       
    }

    public function delete($id)
    {
        Checkout::where('id', $id)->delete();
        
        $message = "Booking is deleted successfully!";
        return redirect()->action('Admin\AdminController@checkout')->with(['success'=>$message]);
       
    }

//users

    public function users()
    {
        $user = Auth::user();

        if($user->type == 3){
            $page_name = "Manage Users";
            $allusers = User::all();

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            return view('user.admin.userlist', compact('user','page_name', 'allusers', 'n'));
        }
       
    }


    public function userEdit($id)
    {
        $user = Auth::user();

        if($user->type == 3){
            $page_name = "Manage Users";
            $edituser = User::find($id);

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            return view('user.admin.edit', compact('user','page_name', 'edituser', 'n'));
        }
       
    }
    

    public function userEditStore(Request $request, $id)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'type' => 'required',
            'password' => 'required',
            
        ],[
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'type.required' => 'Type is required!',
            'password.required' => 'Password is required',
        ]);

        // Hash::make($data['password']),

        if($user->type == 3){
            $page_name = "Manage Users";
            $edituser = User::find($id);
            $edituser->name = $request->name;
            $edituser->email = $request->email;
            if($request->type == "Student"){
                $edituser->type = 1;
            }else if($request->type == "Teacher"){
                $edituser->type = 2;
            }else if($request->type == "Admin"){
                $edituser->type = 3;
            }
            $edituser->password = Hash::make($request->password);
            $edituser->save();

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            $message = "User updated successfully!";
        return redirect()->action('Admin\AdminController@users')->with(['success'=>$message]);
        }
       
    }
    

    public function addUser()
    {
        $user = Auth::user();

        if($user->type == 3){
            $page_name = "Add Users";
            

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            return view('user.admin.add', compact('user','page_name', 'n'));
        }
       
    }

    public function storeUser(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'type' => 'required',
            'password' => 'required',
            
        ],[
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'type.required' => 'Type is required!',
            'password.required' => 'Password is required',
        ]);

        if($user->type == 3){
            $page_name = "Add Users";
            

            $edituser = new User;
            $edituser->name = $request->name;
            $edituser->email = $request->email;
            if($request->type == "Student"){
                $edituser->type = 1;
            }else if($request->type == "Teacher"){
                $edituser->type = 2;
            }else if($request->type == "Admin"){
                $edituser->type = 3;
            }
            $edituser->password = Hash::make($request->password);
            $edituser->save();

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            $message = "User Added successfully!";
            return redirect()->action('Admin\AdminController@users')->with(['success'=>$message]);
        }
       
    }

    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        
        $message = "User is deleted successfully!";
        return redirect()->action('Admin\AdminController@users')->with(['success'=>$message]);
       
    }
    
    public function applicationList()
    {
        $user = Auth::user();

        if($user->type == 3){
            $page_name = "Manage Applications";
            $allapplications = Application::all();

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();
            return view('user.admin.applicationlist', compact('user','page_name', 'allapplications', 'n'));
        }
       
    }

    public function applicationUpdate($id)
    {
        $user = Auth::user();

        if($user->type == 3){
            $page_name = "Manage Applications";
            $edituser = User::find($id);

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            return view('user.admin.applicationupdate', compact('user','page_name', 'edituser', 'n'));
        }
       
    }

    public function storeApplication(Request $request, $id)
    {
        $user = Auth::user();

        // Hash::make($data['password']),

        if($user->type == 3){
            $page_name = "Manage Applications";
            $edituser = User::find($id);
            $edituser->type = 2;
            $edituser->save();

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            DB::table('applications')->where('user_id', $id)->delete();

            $message = "Application updated successfully!";
        return redirect()->action('Admin\AdminController@applicationList')->with(['success'=>$message]);
        }
       
    }


    public function reportList()
    {
        $user = Auth::user();

        if($user->type == 3){
            $page_name = "See Reports";
            $allreports = Report::all();

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();
            return view('user.admin.reportlist', compact('user','page_name', 'allreports', 'n'));
        }
       
    }


    public function teacherList()
    {
        $user = Auth::user();

        if($user->type == 3){
            $page_name = "See Reports";

            
            $allteachers = DB::table('users')->where('type', 2)->get();

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            return view('user.admin.teacherlist', compact('user','page_name', 'allteachers', 'n'));
        }
       
    }

    public function teacherEdit($id)
    {
        $user = Auth::user();

        if($user->type == 3){
            $page_name = "See Reports";

            
            $teacher = User::find($id);

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            return view('user.admin.teacherEdit', compact('user','page_name', 'teacher', 'n'));
        }
       
    }


    public function teacherStore(Request $request, $id)
    {
        $user = Auth::user();

        if($user->type == 3){
            $page_name = "See Reports";

            
            $teacher = User::find($id);
            $teacher->salary = $request->salary;
            $teacher->save(); 

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            return redirect()->action('Admin\AdminController@teacherList')->with(['success'=>'Salary is updated successfully!']);
        }
       
    }

    public function teacherDelete($id)
    {
        $user = Auth::user();

        if($user->type == 3){
            DB::table('users')->where('id', $id)->delete();

            return redirect()->action('Admin\AdminController@teacherList')->with(['success'=>'Teacher is deleted successfully!']);
        }
       
    }

    public function withdrawSalary($id)
    {
        $user = Auth::user();

        if($user->type == 2){
            $page_name = "Withdraw Salary";

            
            $teacher = User::find($id);

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();

            $message = null;
            return view('user.admin.withdrawsalary', compact('message','user','page_name', 'teacher', 'n'));
        }
       
    }
    

    public function withdrawStore(Request $request, $id)
    {
        $user = Auth::user();

        $this->validate($request, [
            'salary' => 'required',
            'account' => 'required|min:11',
            
        ],[
            'salary.required' => 'Amount is required!',
            'account.required' => 'Account number is required!',
            
        ]);


        if($user->type == 2){
            $page_name = "Withdraw Salary";

            
            $teacher = User::find($id);
            $teacher->salary = $teacher->salary - $request->salary;
            $teacher->save(); 

            $n = DB::table('mynotifications')
            ->where('n_status', 0)
            ->where('n_user_id', $user->id)
            ->count();
            
            $message = "Salary is withdrawn successfully";
            return view('user.admin.withdrawsalary', compact('message','user','page_name', 'teacher', 'n'));
        }
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
