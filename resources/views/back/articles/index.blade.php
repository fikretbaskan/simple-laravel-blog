@extends('back.layouts.master')
@section('title','Tüm Makaleler (Aktif)')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><strong>{{$articles->count()}}</strong> makale bulundu: <a href="{{route('admin.trashed')}}" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i> Deleted Article</a></h6>
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
              <th>Status</th>
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
              <!--
                burası açıklama bloğu oldu
                {!! 
                $article->status==0 ? "<span class='text-danger'>Pasif</span>" : "<span class='text-success'>Aktif</span>"
                !!} 
              -->
            <input class="switch" article-id="{{$article->id}}" type="checkbox" data-on="Aktif" data-off="Pasif" data-offstyle="danger" data-onstyle="success" @if ($article->status)
            checked
            @endif  data-toggle="toggle">  
            </td>
              <td>
              <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}" target="_blank" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                <a href="{{route('admin.articles.edit',$article->id)}}" title="Düzenle" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
              <form method="POST" action="{{route('admin.articles.destroy',$article->id)}}">
                @csrf
                @method('DELETE')
                <button type="submit" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
              </form>
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