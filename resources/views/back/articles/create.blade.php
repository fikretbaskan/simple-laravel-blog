@extends('back.layouts.master')
@section('title','Makale Oluştur')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
    </div>
    <div class="card-body">

    @if ($errors->any())
        <div class="alert alert-danger">
           @foreach ($errors->all() as $error)
               <li>{{$error}}</li>
           @endforeach
        </div>
    @endif
    <form method="POST" action="{{route('admin.articles.store')}}" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Category</label>
                <select class="form-control" name="category" required>
                    <option selected>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
               </select>
            </div>
            <div class="form-group">
                <label>Article Picture</label>
                <input type="file" name="image" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Article Content</label>
                <textarea class="form-control" id="summernote" name="content"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Create</button>
            </div>
        </form>
</div>
@endsection


@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('js')
<!-- include summernote css/js -->

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
        $('#summernote').summernote(
            {'height':400}
        );
      });
    </script>
@endsection