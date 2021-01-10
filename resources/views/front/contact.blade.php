@extends('front.layouts.master')
@section('title','Contact')
@section('bg',asset('front/img/contact-bg.jpg'))
@section('content')

      <div class="col-md-8">
        @if (session('success'))
          <div class="alert alert-success">
              {{session('success')}}
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
              <li>{{$error}}</li>
                @endforeach
              </ul>
          </div>
        @endif

        

        <p>Want to get in touch? Fill out the form below to send me a message and I will get back to you as soon as possible!</p>
      <form method="POST" action="{{route('contact.post')}}">
        @csrf
          <div class="control-group">
            <div class="form-group controls">
              <label>Name</label>
              <input type="text" class="form-control" value="{{old('name')}}" placeholder="Name" name="name" required>
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group controls">
              <label>Email Address</label>
              <input type="email" class="form-control" value="{{old('email')}}" placeholder="Email Address" name="email" required>
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group col-xs-12 controls">
              <label>Topic</label>
              <select class="form-control" name="topic">
                <option @if(old('topic')=="Information") selected @endif>Information</option>
                <option @if(old('topic')=="Support") selected @endif>Support</option>
                <option @if(old('topic')=="Global") selected @endif>Global</option>
              </select>
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group  controls">
              <label>Message</label>
              <textarea rows="5" class="form-control" placeholder="Message" name="message" required>{{old('message')}}</textarea>
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <br>
          <div id="success"></div>
          <button type="submit" class="btn btn-primary" id="sendMessageButton">Send</button>
        </form>
      </div>
      <div class="col-md-4">
      
      </div>

@endsection