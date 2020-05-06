<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\User;
use App\Rate;
use App\Reply;
class viewuserscontroller extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }

  /*this fun take the role to display all users have the same role
    and take the sign to send it to be able to determine the difference  between the display and the sign
    in the users view will detremine using the sign
  */
   PUblic function index($role)
    {
      if(\Auth::user()->role !=0)
        return redirect()->with('error',"You Cann't Open This Page");
      $users= User::where('role','=',$role)->get();
      if(!$users)
        abort(404);
      else
        return(view('admin.users',compact('users')));
    }
    
    public function show($id)
    {if(\Auth::user()->role==2 && $id != \Auth::user()->id)
      return redirect()->route('user.data',\Auth::user()->id);
      $user= User::find($id);
      if(!$user)
         return redirect()->route('home')->with('error',"This Profile Not Found");
      elseif(\Auth::user()->role==1 && $user->role ==0)
        return redirect()->route('home')->with('error',"You Cann't Open This Profile"); 
      else
      { 
          return view('profile.showprofile',compact('user'));
      }
    }

    public function edit()
    {
      $user = User::find(\Auth::user()->id);
      if(!$user)
        abort(404);
      else
        return view('profile.editprofile',compact('user'));
    }
    public function update(Request $request)
    { 
<<<<<<< HEAD
      if($request->email!=\Auth::user()->email)
=======
        if($request->email != \Auth::user()->email)
>>>>>>> e32883e61980de75892bec022496edff107436c7
         $this->validate($request,['email' => ['required', 'string', 'email', 'max:255', 'unique:users'],]);
      if($request->image)
      {
         $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
<<<<<<< HEAD
        // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
=======
//         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
>>>>>>> e32883e61980de75892bec022496edff107436c7
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
        $user=user::find(\Auth::user()->id);
        $request = $request->except('__token');
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images/users'), $imageName);
        $user->update($request);
        $user->image=$imageName;        
        $user->update();
    }
    else {
      $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      ]);
     $user=user::find(\Auth::user()->id);
     $request = $request->except('__token');
     $user->update($request);
    }
     return redirect()->route('user.data',\Auth::user()->id)->with('message','your profile Updated Successfully');
    }



    public function destroy(Request $request)
    {  $user=user::find($request->destroy_id);
      if(!$user)
        return abort(404);
      if(count($user->EmployeeComplains)>0)
      {
        $this->validate($request,[
        'employee_id' => ['required',],
      ]);
    }
    
      if($user->role==1 && count($user->EmployeeComplains)>0)
      { 
        $complains=$user->EmployeeComplains;
        foreach($complains as $complain)

            $complain->update(['employee_id'=>$request->empolyee_id]);
        
      }
    elseif($user->role==2 && count($user->CustomerComplains)>0 )
      {
        $complains=$user->CustomerComplains;
        foreach($complains as $complain) 
          {if(count($complain->replies)>0)
            {
              $replies=Reply::where('complain_id',$complain->id)->get();
              foreach($replies as $reply)
                $reply->delete();
          }
            $complain->delete();
          }
      }  
      if($user->role!=0)
        {
          $rate=rate::where('user_id',$request->destroy_id)->get();
          $rate[0]->delete();
        }
      $user->delete();
      return redirect()->back()->with('message',"It's deleted successfully");
    }




    public function create()
    {
      if(\Auth::user()->role!=0)
        return redirect()->route('home')->with('error',"You Cann't Open This Page");
      return view('admin.create');
    }



    public function store(Request $request)
    {
      $this->validate($request,[
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|min:8',
      'password-confirm' =>'required|min:8|same:password',
      'role' => 'required|integer|max:2|min:0',
      'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
      if(!$request->image){
        $image = user::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Hash::make($request->password),
            'role' => $request->role,
          ]);}
          else{
          $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images/users'), $imageName);
            $image = user::create([
              'name' => $request->name,
              'email' => $request->email,
              'password' => Hash::make($request->password),
              'role' => $request->role,
              'image' => $imageName,
            ]);}
            if($request->role != 0){
              $user=user::where('email',$request->email)->get();
              $image = rate::create([
                'user_id' => $user[0]->id,
              ]);
            }
      return redirect()->route('users',[$request->role,0])->with('message','User Added Successfully');
    }

    
    public function changePassword(Request $request)
    {
      $this->validate($request,[
        'password' => 'required',
        ]);
      $user=user::find($request->id);
      if(Hash::check($request->password,$user->password))
      {
        $this->validate($request,[
          'password' => 'required|min:8',
          'newpassword' => 'required|min:8',
          'confirmpassword' =>'required|min:8|same:newpassword',
          ]);
      $user->update(['password'=>Hash::make($request->newpassword)]);
      return redirect()->route('profile.change.form')->with('message','Your Password Updated');
      }
      else
      {
        return redirect()->route('profile.change.form')->with('error','Wrong Old Password');
      }
    }
    public function ChangeForm()
    {
      return view('profile.changepassword');
    }
    
}
