@extends('adminlte::page')
@section('title','All Replies')
@section('content_header')
@include('error')
  <h1>All Replies</h1>
@endsection
@section('content')

  <table class="table datatable">
    <thead>
      <th>#</th>
      <th>Complain Id</th>
      <th></th>
    </thead>
    <tbody>
      @php($counter=0)
      
          @foreach ($customer_replies as  $index => $reply)
          <tr>
              <td>{{++$counter}})</td>
              
              <td class="pl-5">{{$reply->complain_id}}</td>
              
              @if($reply->created_at->diffInYears($now)>0)
              <td class="pl-5">{{$reply->created_at->diffInYears($now)}} Year</td> 
              @elseif($reply->created_at->diffInMonths($now)>0)
              <td class="pl-5">{{$reply->created_at->diffInMonths($now)}} Month</td>
              @elseif($reply->created_at->diffInDays($now)>0)
              <td class="pl-5">{{$reply->created_at->diffInDays($now)}} Day</td>
              @elseif($reply->created_at->diffInHours($now)>0)
              <td class="pl-5">{{$reply->created_at->diffInHours($now)}} Hours</td> 
              @elseif($reply->created_at->diffInMinutes($now)>0)
              <td class="pl-5">{{$reply->created_at->diffInMinutes($now)}} Minutes</td> 
              @else
              <td class="pl-5">now</td> 
            @endif
              <td>
                @if($reply->active)
                <button type="button" class="btn btn-info btn-sm " data-toggle="modal" data-target="#modalPush{{$index}}"><i class="fas fa-eye "></i> Show</button>
                @else
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalPush{{$index}}"><i class="fas fa-eye"></i> Show</button>
                @endif
                <!--Modal: modalPush-->
                <div class="modal fade" id="modalPush{{$index}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                  aria-hidden="true" data-backdrop="false" >
                  <div class="modal-dialog modal-notify modal-info" role="document" >
                    <!--Content-->
                    <div class="modal-content text-center" >
                      <!--Header-->
                      <div class="modal-header bg-primary d-flex justify-content-center" >
                      <h5 class="heading m-auto">Hello {{\Auth::user()->name}}</h5>
                      <button type="button" class="btn  btn-sm" data-toggle="modal" data-target="#modalPush{{$index}}"><i class="fas fa-times text-white"></i></button>
                      </div>
                      <!--Body-->
                      <div class="modal-body">
                        <i class="fas fa-bell fa-4x animated rotateIn mb-4  "style="color:#33b5e5"></i>
                        <p>{{$reply->reply}}</p>
                        <p>Your Complain Solved now If Not Please Tell Us</p>
                      </div>
                      <!--Footer-->
                      @if($reply->active==1)
                      <div class="modal-footer m-auto">
                        <form action="{!!route('rate.view')!!}" method="POST">
                          @csrf
                          <input type="hidden" name="ComplainId" value="{{$reply->complain_id}}">
                          <input type="hidden" name="ReplyId" value="{{$reply->id}}">
                          <button type="submit" class="btn btn-info ml-2">Rate</button>
                        </form>
                        <form action="{!!route('unsolved')!!}" method="POST">
                          @csrf
                          @method('Put')
                          <input type="hidden" name="ComplainId" value="{{$reply->complain_id}}">
                          <input type="hidden" name="ReplyId" value="{{$reply->id}}">
                          <button type="submit" class="btn btn-danger ml-2">UnSolved</button>
                        </form>
                          
                        <form action="{!!route('solved')!!}" method="POST">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="ReplyId" value="{{$reply->id}}">
                          <button type="submit" class="btn btn-success m-2">Solved</button>
                        </form>
                      @endif
                        
                      </div>
                    </div>
                    <!--/.Content-->
                  </div>
                </div>
                <!--Modal: modalPush-->
              </td>
            </tr>
          @endforeach
      </tbody>
    </table>   
@endsection







{{-- 
<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalPush"><i class="fas fa-eye"></i> Show</button>
<!--Modal: modalPush-->
<div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="false" >
  <div class="modal-dialog modal-notify modal-info" role="document" >
    <!--Content-->
    <div class="modal-content text-center" >
      <!--Header-->
      <div class="modal-header btn-primary d-flex justify-content-center" >
      <h5 class="heading m-auto">Hello {{\Auth::user()->name}}</h5>
      </div>
      <!--Body-->
      <div class="modal-body">
        <i class="fas fa-bell fa-4x animated rotateIn mb-4  "style="color:#33b5e5"></i>
        <p>dsadsd</p>
        <p>Your Complain Solved now If Not Please Tell Us</p>
      </div>
      <!--Footer-->
      <div class="modal-footer m-auto">
      <form action="" method="GET">
        <input type="hidden" name="ComplainId" value="{{$complain->id}}">
        <button type="submit" class="btn btn-primary m-2">UnSolved</button>
      </form>
        <a href="{!!route('complain.rate')!!}" class="btn btn-info">Rate</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalPush-->  --}}
