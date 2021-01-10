@extends('back.layouts.master')
@section('title','Tüm Sayfalar (Aktif)')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><strong>{{$pages->count()}}</strong> Sayfa bulundu: <a href="" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i> Deleted page</a></h6>
    </div>
    <div class="card-body">
      <div class="alert alert-success" style="display: none" id="orderSuccess">
        Ordered Success!!!
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Order</th>
              <th>Pic</th>   
              <th>Title</th>
              <th>Status</th>
              <th>Process</th>
            </tr>
          </thead>

          <tbody id="orders">
            @foreach ($pages as $p)
          <tr id="page_{{$p->id}}">
            <td align="center"><i class="fa fa-arrows-alt-v fa-3x handle" style="cursor:move"></i></td>
            <td><img src="{{asset($p->image)}}" width="250" height="150"></td>
            <td>{{$p->title}}</td>
            <td>

            <input class="switch" page-id="{{$p->id}}" type="checkbox" data-on="Aktif" data-off="Pasif" data-offstyle="danger" data-onstyle="success" @if ($p->status)
            checked
            @endif  data-toggle="toggle">  
            </td>
              <td>
              <a href="{{route('page',$p->slug)}}" target="_blank" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
              <a href="{{route('admin.page.edit',$p->id)}}" title="Düzenle" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
              <a href="{{route('admin.page.delete',$p->id)}}" type="submit" title="Trash" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
  $('#orders').sortable({
    handle:'.handle',
    update:function(){
    var order =  $('#orders').sortable('serialize');
    //console.log(order);
    $.get("{{route('admin.page.orders')}}?"+order,function(data,status){
    //Animasyonsuz
     /*  $('#orderSuccess').show();
      setTimeout(function(){$('#orderSuccess').hide();},2000); */

    //Animasyonlu
    $("#orderSuccess").show().delay(2000).queue(function(n) {
     $(this).hide(); n();
});
    });
    }
  });
</script>
<script>
  $(function() {
    $('.switch').change(function() {
      //alert(this.getAttribute('page-id'));
      
       $.get("{{route('admin.page.switch')}}", {id:this.getAttribute('page-id')}, function(data, status){
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