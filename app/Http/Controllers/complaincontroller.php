<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Complain;
use App\User;
 use \Carbon\Carbon;
use App\ComplainReplays;
use App\Rate;
use App\Reply;
use App\systemRate;

class complaincontroller extends Controller
{   
  public function __construct()
    {
        $this->middleware('auth');
    }
 
  public function index($state)
    { //$state=$request->state;
      if(\Auth::user()->role==0 && $state<3)
      {
        $complains= complain::where('state','=',$state)->get();
        $employees=User::where('role',1)->get();
        return view('complain.all',compact('complains','state','employees'));
      }
      elseif(\Auth::user()->role==1)
      { if($state!=1)
          return redirect()->route('complain.all',1);
        $user=User::find(\Auth::user()->id);
        $complains=$user->EmployeeComplains->sortByDesc('update_at');
      }
      elseif(\Auth::user()->role==2 )
      {
        if($state!=2)
          return redirect()->route('complain.all',2);
        $user=User::find(\Auth::user()->id);
        $complains=$user->CustomerComplains;
        $complains=$complains->sortByDesc('created_at');
      }
      else
        abort(404);
      if(!$complains)
         abort(404);
      else
      
     return view('complain.all',compact('complains','state'));
    }
    public function create()
    {
      if(\Auth::user()->role!=2)
            return redirect()->route('home')->with('error',"You Cann't Open This Page");
        $customer_id=\Auth::user()->id;
        return view('complain.create',compact('customer_id'));
    }
  
    public function store(Request $request)
    {
        $this->validate($request,[
          'title' => 'max:255|required',
          'details' => 'required',
          'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'customer_id' => 'numeric|required',
          
        ]);
        if($request->image){
          $imageName = time().'.'.request()->image->getClientOriginalExtension();
          request()->image->move(public_path('images/complains'), $imageName);
          $image = Complain::create([
              'customer_id' => $request->customer_id,
              'title' => $request->title,
              'details' => $request->details,
              'image' => $imageName,
          ]);
       }
          else{
          $image = Complain::create([
              'customer_id' => $request->customer_id,
              'title' => $request->title,
              'details' => $request->details,
            ]);}
        return redirect(route('home'))->with('message','Your complain Added');
    }
    public function show(Request $request)
    {
      $complain= Complain::find($request->ComplainId);
      if(\Auth::user()->role!=0 && $complain->customer->id!=\Auth::user()->id && $complain->employee->id!=\Auth::user()->id )
        return redirect()->route('home')->with('error',"You Cann't Open This Page");
      if(\Auth::user()->role==1 && $complain->state!=1)
        return abort(404);
      elseif(\Auth::user()->role==1 && $complain->state==1 && $complain->employee->id!=\Auth::user()->id)
        return abort(404);
      $user=Complain::find($request->ComplainId)->customer;
      $employee=Complain::find($request->ComplainId)->employee;
        if(!$complain)
        abort(404);
      else
        return view('complain.details',compact('complain','user','employee'));
        
    }
    public function sign(Request $request)
    {
      
      $complain=Complain::find($request->ComplainId);
      $complain->employee_id=$request->Empolyee_id;
      $complain->state=1;
      $complain->update();
      
      return redirect()->route('complain.all',0)->with('message','The Complain Signed');
    }

    
    public function Rateview(Request $request)
    { 
      if(\Auth::user()->role==2)
      {
        $reply=Reply::find($request->ReplyId);
        $reply->active=0;
        $reply->update();
        \Auth::user()->rate->ActiveReplies--;
        \Auth::user()->rate->update();  
      }

     $complain=Complain::find($request->ComplainId);
      return view('complain/rate',compact('complain'));
      
    }
    public function rate(Request $request)
    {
      if(\Auth::user()->role==2)
        {
          $complain=Complain::find($request->complain_id);
          $complain->update(['rate'=>$request->EmployeeRate]);
          $employee=User::find($request->employee_id);
          $employee->rate->rate=$request->EmployeeRate;
          $employee->rate->number_rate++;
          $employee->rate->update();
          $system_rate=SystemRate::create(['rate'=>$request->SystemRate,'feedback'=>$request->SystemRecomand]);
        }
      elseif(\Auth::user()->role==1)
        {
          // dd($request);
          $customer=User::find($request->customer_id);
          $customer->rate->rate=$request->CustomerRate;
          $customer->rate->number_rate++;
          $customer->rate->update();

          $complain=Complain::find($request->ComplainId);
          $complain->state=2;
          $complain->update();
          $complain->customer->rate->ActiveReplies++;
          $complain->customer->rate->update();
          Reply::create(['complain_id'=>$request->ComplainId,'reply'=>$request->reply]);
        } 
        return redirect()->route('home')->with('message','Thank you for your feedback');
        
    }

    public function replies($active)
    {if(\Auth::user()->role!=2)
        redirect()->route('home')->with('error',"You Cann't Open This Page");
      if($active==1 || $active==0 )
    {
      if(\Auth::user()->rate->ActiveReplies==0 &&$active==1)
         return redirect()->route('complain.replies',0)->with('info',"You Didn't have any active replies");
       $replies=Reply::where('active',$active)->get()->sortByDesc('created_at');
       $customer_replies=array();
       foreach($replies as $reply)
        if($reply->complain->customer_id==\Auth::user()->id)
          $customer_replies[]=$reply;
       $now=\Carbon\Carbon::now();
       return view('complain.replies',compact(['customer_replies','now']));     
    }
    else
    return redirect()->route('complain.replies',0);
      
    }
    public function unsolved(Request $request)
    {
        $complain=Complain::find($request->ComplainId);
        $complain->state=1;
        $complain->update();
        $replies=\Auth::user()->rate->ActiveReplies--;
        \Auth::user()->rate->update();
        $reply=Reply::find($request->ReplyId);
        $reply->active=0;
        $reply->update();
        return redirect()->route('home')->with('message','Thank You We Will Try To Solve It Again ');
    }
    public function solved(Request $request)
    {
        $reply=Reply::find($request->ReplyId);
        $reply->active=0;
        $reply->update();
        $replies=\Auth::user()->rate->ActiveReplies--;
        \Auth::user()->rate->update();
        return redirect()->route('home')->with('message','Thank You We are happy for halpping you:-) ');
    }
   public function SendReply(Request $request)
   {
     $reply=$request->reply;
     $complain=Complain::find($request->ComplainId);
      return view('complain/rate',compact(['complain','reply']));
   } 

    // public function try()
    // {
    // return view('complain.rate');
    // }
    // public function try2()
    // {
      
    //       $complain=Complain::find(10);
    //       $reply='dasdsa';
    // //       $now=\Carbon\Carbon::now();
    // //       $d=$complain->created_at->diffInMinutes($now);
    // return view('complain.rate',compact(['complain','reply']));
    // //   dd($now);
    // }
    
    

}
