@extends('back.layouts.master')
@section('title','Tüm Makaleler (Silinmiş)')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><strong>{{$articles->count()}}</strong> makale bulundu: <a href="{{route('admin.articles.index')}}" class="btn btn-success btn-sm"><i class="fa fa-trash"></i> Active Article</a></h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Pic</th>
              <th>category</th>
              <th>Title</th>
              <th>Hit</th>
              <th>Created At</th>
            
              <th>Process</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($articles as $article)
            <tr>
            <td><img src="{{asset($article->image)}}" width="250" height="150"></td>
            <td>{{$article->getCategory->name}}</td>
              <td>{{$article->title}}</td>
              <td>{{$article->hit}}</td>
            <td>{{$article->created_at}}</td>
           
              <td>
              <a href="{{route('admin.recovery',$article->id)}}" type="submit" title="Recycle" class="btn btn-sm btn-primary"><i class="fa fa-recycle"></i></a>
              <a href="{{route('admin.hardDestroy',$article->id)}}" type="submit" title="Trash" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
              </td>
            </tr> 
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
  $(function() {
    $('.switch').change(function() {
      //alert(this.getAttribute('article-id'));
      
       $.get("{{route('admin.switch')}}", {id:this.getAttribute('article-id')}, function(data, status){
        console.log(data);
      }); 
    /*   var sonuc = 0;
      if(this.checked)
        sonuc=1;
      else
        sonuc=0;
      alert(sonuc); */
    })
  })
</script>
@endsection