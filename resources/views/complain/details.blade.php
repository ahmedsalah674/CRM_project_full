@extends('adminlte::page')
@section('title','Complain Details')
@section('content_header')
  <h1 class="d-inline"><i class="fas fa-align-justify fa-sm text-info"></i>Complain Details:</h1>
  @if(\Auth::user(0)->role==1 && $complain->state==1)
    <div class="d-inline">
      <a href=""class="btn btn-lg btn-outline-primary waves-effects w-25 float-right mr-5 d-inline " data-toggle="modal" data-target="#modalPoll-1"><i class="far fa-comment fa-sm" ></i> Replay</a>
    </div>
    <div class="modal fade right" id="modalPoll-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true" data-backdrop="false" >
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header pb-0 bg-info">
            <p class="heading lead">Complain Solve</p>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"data-backdrop="false"><i class="fas fa-times pt-1"></i></span>
            </button>
          </div>
          <!--Body-->
          <div class="modal-body ">
            <div class="text-center">
              <i class="far fa-file-alt fa-4x mb-3 rotateIn text-info"></i>
              <p>Have you some instructions how to solve this complain?</p>
            </div>
            <hr>
            <p class="text-center">
              <strong>What is the instructions?</strong>
            </p>
            <!--Basic textarea-->
        <form action="{!!route('complain.send.reply')!!}" method="POST">
          @csrf
          {{-- @method('PUT') --}}
          <div class="md-form ">
            <input type="hidden" name="ComplainId" value="{{$complain->id}}">
            <textarea type="text" name="reply" placeholder="IF There Aren't Any Instructions Write Small Massege" class="md-textarea form-control" rows="3" required></textarea>
          </div>
          </div>
            <!--Footer-->
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light m-2">Send
              <i class="fa fa-paper-plane ml-1"></i>
            </button>
            <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
          </div>
        </form>
        </div>
      </div>
    </div>
  @endif  
@endsection

@section('content')
<table class="table ">
  <tbody>
        @if($complain->image != asset('images/complains/'))
        <label><i class="fas fa-image text-info"></i> Complain Image:</label>
        <br>    
        <tr>
          <td class="w-50">
            <a href="{{$complain->image}}"><img src="{{$complain->image}}" alt="Complain Image" height="200" width="320"> </a>
          </td>
        </tr>
    @endif
    <tr>
      <td ><i class="fas fa-signature text-info"></i> <b> Customer Name: </b>  {{ $user->name }}</td>
    @if($complain->state >0)
      <td ><i class="fas fa-signature text-info"></i> <b> Employee Name: </b>  {{ $employee->name }}</td>
    @endif
  </tr>
    <tr>
      <td><i class="fas fa-envelope text-info"></i> <b>Customer Email:</b> {{ $user->email }}</td>
      @if($complain->state >0)
        <td ><i class="fas fa-envelope text-info"></i> <b>Employee Email: </b>  {{ $employee->email }}</td>
      @endif
    </tr>
    <tr>
        <td><i class="fas fa-info-circle text-info"></i> <b>Complain title: </b>{{ $complain->title }}</td>
    </tr>
    <tr>
      <td><i class="fas fa-align-justify text-info"></i> <b>Complain Details: </b>{{ $complain->details }}</td>
    </tr>
    @if($complain->state == 2 )
      <tr>
        <td><i class="fas fa-star text-info"></i> <b>Employee Rate:</b> {{ $complain->rate *10 }}%</td>
      </tr>
    @endif
  </tbody>
</table>
@if($complain->state == 2 )
    <div class="row justify-content-center mb-1" >
      <div class="progress" style="width:70%;border-radius:50px">
        <div class="progress-bar" role="progressbar " style="width: {{$complain->rate *10}}%" aria-valuenow="{{$complain->rate *10}}" aria-valuemin="0" aria-valuemax="100%"></div>
      </div>
    </div>
    {{-- <table class="table">
    <tr >
    <td ><i class="fas fa-star text-info"></i> <b>System Rate:</b> {{ $complain->system_rate }}%</td></tr></table>
    <div class="row justify-content-center pb-4">
      <div class="progress" style="width:70%;border-radius:50px">
        <div class="progress-bar" role="progressbar" style="width:{{$complain->system_rate}} % " aria-valuenow="{{$complain->system_rate}}" aria-valuemin="0" aria-valuemax="30%"></div>
      </div>
    </div> --}}
    
@endif

@endsection
