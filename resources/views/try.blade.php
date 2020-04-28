@extends('adminlte::page')
@section('content')
{{-- <div class="card text-center col-7 m-auto">
    <div class="card-header">
      Featured
    </div>
    <div class="card-body">
      <h5 class="card-title">We have masseage for you:</h5>
      <p class="card-text">Complain Replay</p>
      <p class="card-text">Your Complain number id is solved if not Please tell us.</p>
      <form action=""></form>
      <a href="#!" class="btn btn-primary float-right">Rate</a>
      <a href="#!" class="btn btn-primary float-left">UnSolved</a></form>
    </div>
    <div class="card-footer text-muted">
       2 Days Ago
    </div>
  </div>     --}}
  {{-- <div class="card text-center col-md-7 m-auto">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="#">Active</a>
        </li>
        <li class="nav-item" style="display:r">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="#">Active</a>
                </li>
                <li class="nav-item">
                  
                </li>
                <li class="nav-item">
                  <a class="nav-link disabled" href="#">Disabled</a>
                </li>
              </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <h5 class="card-title">Special title treatment</h5>
      <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
  </div> --}}
{{--   
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPoll-1">Launch
    modal</button>
  
  <!-- Modal: modalPoll -->
  <div class="modal fade right" id="modalPoll-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <p class="heading lead">Feedback request
          </p>
  
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"data-backdrop="false" class="white-text">×</span>
          </button>
        </div>
  
        <!--Body-->
        <div class="modal-body ">
          <div class="text-center">
            <i class="far fa-file-alt fa-4x mb-3 animated rotateIn"></i>
            <p>
              <strong>Your opinion matters</strong>
            </p>
            <p>Have some ideas how to improve our product?
              <strong>Give us your feedback.</strong>
            </p>
          </div>
  
          <hr>
  
          <!-- Radio -->
          <p class="text-center">
            <strong>Your rating</strong>
          </p>
          <div class="form-check mb-4">
            <input class="form-check-input" name="group1" type="radio" id="radio-179" value="option1" checked>
            <label class="form-check-label" for="radio-179">Very good</label>
          </div>
  
          <div class="form-check mb-4">
            <input class="form-check-input" name="group1" type="radio" id="radio-279" value="option2">
            <label class="form-check-label" for="radio-279">Good</label>
          </div>
  
          <div class="form-check mb-4">
            <input class="form-check-input" name="group1" type="radio" id="radio-379" value="option3">
            <label class="form-check-label" for="radio-379">Mediocre</label>
          </div>
          <div class="form-check mb-4">
            <input class="form-check-input" name="group1" type="radio" id="radio-479" value="option4">
            <label class="form-check-label" for="radio-479">Bad</label>
          </div>
          <div class="form-check mb-4">
            <input class="form-check-input" name="group1" type="radio" id="radio-579" value="option5">
            <label class="form-check-label" for="radio-579">Very bad</label>
          </div>
          <!-- Radio -->
  
          <p class="text-center">
            <strong>What could we improve?</strong>
          </p>
          <!--Basic textarea-->
          <div class="md-form">
            <textarea type="text" id="form79textarea" class="md-textarea form-control" rows="3"></textarea>
            <label for="form79textarea">Your message</label>
          </div>
  
        </div>
  
        <!--Footer-->
        <div class="modal-footer justify-content-center">
          <a type="button" class="btn btn-primary waves-effect waves-light">Send
            <i class="fa fa-paper-plane ml-1"></i>
          </a>
          <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
        </div>
      </div>
    </div>
  </div>  --}}
  <!-- Modal: modalPoll -->
<!-- Button trigger modal-->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPush">Launch modal</button>


<!--Modal: modalPush-->
<div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="false" >
  <div class="modal-dialog modal-notify modal-info" role="document" >
    <!--Content-->
    <div class="modal-content text-center" >
      <!--Header-->
      <div class="modal-header btn-primary d-flex justify-content-center" >
      <p class="heading">Hello {{\Auth::user()->name}}</p>
        
      </div>

      <!--Body-->
      <div class="modal-body">

        <i class="fas fa-bell fa-4x animated rotateIn mb-4  "style="color:#33b5e5"></i>
        
        <p>dsadsd</p>
        <p>Your Complain Solved now If Not Please Tell Us</p>

      </div>

      <!--Footer-->
      <div class="modal-footer m-auto">
          <h1></h1>
      <form action="" method="GET">
        <input type="hidden" name="UserId" value="{{\Auth::user()->id}}">
        <input type="hidden" name="ComplainId" value="{{}}">
        <button type="submit" class="btn btn-primary m-2">UnSolved</button>
      </form>
        <a href="{!!route('complain.rate')!!}" class="btn btn-info">Rate</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div> --}}
<!--Modal: modalPush-->
{{-- <div class="md-form purple-border-focus">
  <i class="fas fa-pencil-alt prefix"></i>
  
  <textarea id="form10" class="md-textarea form-control" rows="3"></textarea>
  
</div>  --}}
@endsection   