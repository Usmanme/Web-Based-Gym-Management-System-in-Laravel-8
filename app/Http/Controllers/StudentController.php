<?php

namespace App\Http\Controllers;
use Stripe;
use Session;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Member;
use App\Models\Trainer;
use Illuminate\Http\Request;
use App\Models\AttendanceModel;
use app\Models\LeaveformModel;
use App\Models\Admin;


use DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     
     */
    function memberlogin()
    {
        return view('memberlogin');
    }
    function trainerlogin()
    {
        return view('trainerlogin');
    }
    function adminlogin()
    {
        return view('adminlogin');
    }
    public function index()
    {
        return view('index');
    }
    function leaveform()
    {
        return view('leaveform');
    }
    function first()
    {
        return view('first');
    }

    function trainerregister()
    {
        return view('trainerregister');
    }

    //Function to show Admin Dashboard
    function admindashboard(Request $request)
    {
        return view ('admindashboard');
       
        
      
    }
    //Function to show Home on which Payment View
    function home(Request $request)
    {
        return view('home');
    }
 
   //Function to show Attendance Record
    function attendancerecord()
    {
        $memb = AttendanceModel::all();
        return view('attendancerecord', compact('memb'));
       
    }

    function memberattendance()   
    {
        $mem = AttendanceModel::all();
        return view('memberattendance', compact('mem'));
        return view('memberattendance');
    }
  
 
   
//Function to Store new Member Data
    public function store(Request $request)
    {
        
       $add=Member::create([
           'name'=>$request->input('name'),
           'email'=>$request->input('email'),
           'password'=>$request->input('password'),
           'confirmpassword'=>$request->input('confirmpassword'),
           'phone'=>$request->input('phone'),
           'shift'=>$request->input('shift'),
       ]);
        return redirect()->route('index')
        ->with('success','Member Record Crearted Successfully');

    
    }
       //Function to show Trainer Data
       function trainerdata(Request $request)
       {
        $trainer = Trainer::all();
        return view('trainerdata', compact('trainer'));
          
       }
    public function create(Request $request)
    {
        // $request->validate([
        //     'name'=>'required',
        //     'email'=>'required|email|unique:admins',
        //     'password'=>'required|min:5|max:12',
        //     'confirmpassword'=>'required|min:5|max:12',
        // ]);
        
        $add=Trainer::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),
            'confirmpassword'=>$request->input('confirmpassword'),
            'phone'=>$request->input('phone'),
            'shift'=>$request->input('shift'),
        ]);
        
         return back();
         
       
    }
    //Function to Show Dashboard 
    function dashboard(Request $request)
    {
        $id=session()->get('member')->id;
        $data=Member::where('id',$id)->first();
        return view('dashboard',['data'=> $data]);
    }
 
    //Function to show Member Data
    function memberdata(Request $request)
    {
        
        $member = Member::all();
        return view('memberdata', compact('member'));
     
    }

    

//Function to Check the User or Admin or Trainer
   public function check(Request $request)
   {
     
    $member=Member::where('email',$request->email)->where('password',$request->password)->first();
    $admin=Admin::where('email',$request->email)->where('password',$request->password)->first();
    $trainer=Trainer::where('email',$request->email)->where('password',$request->password)->first();

       if ($member)
        {
            
            $request->session()->put('member',$member);
            return redirect()->route('dashboard');
   
        }

        elseif ($admin)
        {
        $request->session()->put('admin',$admin);
        $id=session()->get('admin')->id;
        $data=Member::where('id',$id)->first();
        return view('admindashboard', compact('admin'));
        }

        else
        {
            $request->session()->put('trainer',$trainer);
             $id=session()->get('trainer')->id;
             $data=trainer::where('id',$id)->first();
             return view('trainerdashboard', compact('trainer'));


        }
 

}
//Working on this part

//Function to Update & Edit Member Data
function edit(Request $request, Member $post,$id)
{

    
    $post=Member::find($id);
    $post->name = $request->name;
    $post->email = $request->email;
    $post->password = $request->password;
    $post->phone = $request->phone;
    $post->shift = $request->shift;
  
    $post->save();
    return redirect('memberdata');
 
}

public function update(Request $request, Member $post,$id)
{
    $posts=Member::find($id);
    return view ('updatemember',['posts'=>$posts]);
    
    
  

}

//Function to Update & Edit Trainer Data
function editt(Request $request, Trainer $post,$id)
{

    
    $post=Trainer::find($id);
    $post->name = $request->name;
    $post->email = $request->email;
    $post->password = $request->password;
    $post->phone = $request->phone;
    $post->shift = $request->shift;
    $post->save();
    return redirect('trainerdata');
}

public function updated(Request $request, Trainer $post,$id)
{
    $posts=Trainer::find($id);
    return view ('updatetrainer',['posts'=>$posts]);
 

}



//Function to Mark Present
public function present(AttendanceModel $dd,$id)
{

    $update=AttendanceModel::where('id',$id)->first();
        $update->status='Present';
        $update->save();
          return back();
       
}
//Function to Mark Absent
public function absent(AttendanceModel $add,$id)
{
   
    $update=AttendanceModel::where('id',$id)>where('date',date('Y-m-d'))->first();
    $update->status='Absent';
    $update->save();
     return back();
  
}
//Function to Delete Trainer
public function destroy(Trainer $dd,$id)
{
  
    $dd=Trainer::find($id);
    $dd->delete();
    return back();
    

}
//Function to Delete Member
public function dlt(Member $dd,$id)
{
    $dd=Member::find($id);
    $dd->delete();
    
    return back();

}
//Upload Image Function
public function upload(Request $request)
{
    
    if($request->hasfile('image')){
        $id=session()->get('member')->id;
        $userid=Member::where('id',$id)->first();
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = time().'.'.$extension;
        $file->move('uploads/students/',$filename);
        $userid->image = $filename;
        $userid->save();
        return back();        
    }


}
//Function for Logout Member
public function logout(Request $request)
{
    return view('memberlogin');
}
//Function for Logout Trainer
public function lg(Request $request)
{
    return view ('trainerlogin');
}
//Function for Logout Admin
public function log(Request $request)
{
   
    return redirect('adminlogin');
}



}