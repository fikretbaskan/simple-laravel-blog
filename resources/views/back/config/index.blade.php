@extends('back.layouts.master')
@section('title','Settings')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Settings</h6>
    </div>
    <div class="card-body">
     <form action="{{route('admin.settings.update')}}" method="POST" enctype="multipart/form-data">
       @csrf
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Site Title</label>
          <input type="text" name="title" required class="form-control" value="{{$config->title}}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Site Active</label>
            <select name="active" class="form-control">
              <option value="1" @if ($config->active)
                  selected
              @endif>Active</option>
              <option value="0" @if (!$config->active)
                selected
            @endif>Deactive</option>
            </select>
          </div>
        </div>
      </div> 
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Site Logo</label>
          <input type="file" name="logo" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Site Favicon</label>
            <input type="file" name="favicon" class="form-control">
          </div>
        </div>
      </div> 
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Facebook</label>
          <input type="text" name="facebook" class="form-control" value="{{$config->facebook}}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Twitter</label>
          <input type="text" name="twitter" class="form-control" value="{{$config->twitter}}">
          </div>
        </div>
      </div>  
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Githup</label>
          <input type="text" name="github" class="form-control" value="{{$config->github}}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Linkedin</label>
          <input type="text" name="linkedin" class="form-control" value="{{$config->linkedin}}">
          </div>
        </div>
      </div>  
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Youtube</label>
          <input type="text" name="youtube" class="form-control" value="{{$config->youtube}}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Instagram</label>
          <input type="text" name="instagram" class="form-control" value="{{$config->instagram}}">
          </div>
        </div>
      </div>  
      <div class="form-group">
        <button class="btn btn-success btn-block">Update</button>
      </div>
     </form> 
    </div>
</div>
@endsection
