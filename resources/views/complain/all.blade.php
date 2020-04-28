@extends('adminlte::page')
@section('title','All Complains')
@section('content_header')
@include('error')
  <h1>All Complains</h1>
@endsection
@section('content')

{{-- <form id="form">
  <select class="form-control" name="state" id="state_form" >
    <option  disabled selected>choose state</option>
    <option value="2" >solved</option>
    <option value="1" >signed</option>
    <option value="0" >unsigned</option>
  </select>
</form> --}}

  <table class="table datatable">
    <thead>
      <th>#</th>
      <th>Complain Id</th>
      <th>complain title</th>
      @if(!(\Auth::user()->role==2 && $state==3))
        <th>state</th>
      @endif
    </thead>
    <tbody>
      @php($counter=0)
      
          @foreach ($complains as  $index => $complain)
              @if(\Auth::user()->role==1 &&$complain->state!=1)
                @continue
              @endif

              @if(\Auth::user()->role==2 && $state==3 && !count($complain->replies))
                @continue
              @endif
          <tr>
              <td>{{++$counter}})</td>
              <td class="pl-5">{{$complain->id}}</td>
              <td>{{$complain->title}}</td>
              @if(!(\Auth::user()->role==2 && $state==3))
                @if($complain->state<2 && \Auth::user()->role!=0)
                <td>active</td>
                @elseif($complain->state==0)
                <td>unsign</td>
                @elseif($complain->state==1)
                <td>signed</td>
                @elseif($complain->state==2)
                <td>solved</td>
                @endif
            @endif  
              <td>
                @if(\Auth::user()->role==1||\Auth::user()->role==0)
                  @if($complain->state==0 &&\Auth::user()->role==0)
              <button type="button" style="width:20%" class="btn btn-primary btn-sm mr-1 " data-toggle="modal" data-target="#modalPush{{$counter}}"><i class="fas fa-check"></i> Sign</button>
                    <!--Modal: modalPush-->
              <div class="modal fade" id="modalPush{{$counter}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                      aria-hidden="true" data-backdrop="false" >
                      <div class="modal-dialog modal-notify modal-info" role="document" >
                        <!--Content-->
                        <div class="modal-content text-center" >
                          <!--Header-->
                          <div class="modal-header bg-primary d-flex justify-content-center" >
                          <h5 class="heading m-auto">Hello {{\Auth::user()->name}}</h5>
                          <button type="button"  class="btn text-white" data-toggle="modal" data-target="#modalPush{{$counter}}"><i class="fas fa-times"></i></button>

                          </div>
                          <!--Body-->
                          <div class="modal-body">
                            <i class="fas fa-bell fa-4x animated rotateIn mb-4  "style="color:#33b5e5"></i>
                            <p>please choose Employee</p>
                          </div>
                          <!--Footer-->
                          <div class="modal-footer m-auto">
                          <form action="{!!route('complain.sign')!!}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="ComplainId" value="{{$complain->id}}">
                            <select class="form-control"  name="Empolyee_id">
                              <option selected disabled>Select Employee</option>
                              @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                              @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary m-2"><i class="fas fa-check"></i>Sign</button>
                          </form>
                            
                          </div>
                        </div>
                        <!--/.Content-->
                      </div>
                    </div>               
                    @endif
                    @endif
                    <form action="{!! route('complain.details') !!}" method="POST" class="d-inline">
                      @csrf
                      <input type="hidden" name="ComplainId" value="{{$complain->id}}">
                      
                      <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Show</button>
                    </form>
                    {{-- <a href="{!! route('complain.details',$complain->id) !!}" method="post" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Show</a> --}}
                  {{-- @elseif(Auth::user()->role==2 )
                <a href="{!! route('complain.details',$complain->id) !!}" method="post" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Show</a>
                 --}}
                
              </td>
            </tr>
          @endforeach
      </tbody>
    </table>
    {{--<div class="row d-flex justify-content-center ">
      <div class="  ">{{$complains->links()}}</div>
    </div>--}}
    
@endsection
{{-- @section('js')
    <script>
      $('#state_form').on('change',function(){
            $("#form").submit();
        });
    </script>
@endsection --}}







{{-- 
<button type="button"  class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalPush"><i class="fas fa-eye"></i> Show</button>
<!--Modal: modalPush-->
<div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="false" >
  <div class="modal-dialog modal-notify modal-info" role="document" >
    <!--Content-->
    <div class="modal-content text-center" >
      <!--Header-->
      <div class="modal-header gb-primary d-flex justify-content-center" >
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