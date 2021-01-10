@extends('back.layouts.master')
@section('title','Tüm Kategoriler')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">New Category Create</h6>
            </div>
            <div class="card-body">
            <form action="{{route('admin.category.create')}}" method="POST">
              @csrf
                <div class="form-group">
                  <label for="">Category Name</label>
                  <input type="text" class="form-control" name="category" required>
                </div>
                <div class="form-group">
                  <input type="submit" value="Create" class="btn btn-block btn-primary ">
                </div>
              </form>
            </div>
        </div>
     </div>
     <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Category Name</th>
                        <th>Article Count</th>
                        <th>Status</th>
                        <th>Preferences</th>
                      </tr>
                    </thead>
          
                    <tbody>
                      @foreach ($categories as $category)
                      <tr>
                        <td>{{$category->name}}</td>
                        <td>{{$category->getArticleCounts()}}</td>
                     
                      <td>
                      <input class="switch" category-id="{{$category->id}}" type="checkbox" data-on="Aktif" data-off="Pasif" data-offstyle="danger" data-onstyle="success" @if ($category->status)
                      checked
                      @endif  data-toggle="toggle">  
                      </td>
                        <td>
                        <a category-id="{{$category->id}}" title="Edit" class="btn btn-sm btn-primary text-white edit-click"><i class="fa fa-edit"></i></a>
                        <a category-id="{{$category->id}}" category-name="{{$category->name}}" category-count="{{$category->getArticleCounts()}}" title="Delete" class="btn btn-sm btn-danger text-white delete-click"><i class="fa fa-times"></i></a>
                        </td>
                      </tr> 
                      @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
     </div>
</div>

<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form method="POST" action="{{route('admin.category.update')}}">
        @csrf
      <div class="modal-body">
       
          <div class="form-group">
            <label for="category">Category Name</label>
            <input id="category" type="text" class="form-control" name="category">
            <input type="hidden" name="id" id="category_id" />
          </div>
          <div class="form-group">
            <label for="slug">Category Slug</label>
            <input id="slug" type="text" class="form-control" name="slug">
          </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    
      <div class="modal-body">
       
       <div id="articleAlert"></div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <form action="{{route('admin.category.delete')}}" method="POST" >
        @csrf
        <input type="hidden" name="deleteId" id="deleteId">
          <button type="submit" class="btn btn-danger" id="deleteBtn">Delete</button>
        </form>
      </div>
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
    $('.delete-click').click(function(){
       let id=this.getAttribute('category-id');
       let count=this.getAttribute('category-count');
       let name=this.getAttribute('category-name');
      //alert(count);
      if (id==12) {
        $('#articleAlert').html(name+' Category Not Deleted!!!');
        $('#deleteBtn').hide();
        $('#deleteModel').modal();
        return;
      }

      $('.modal-footer').show();
      $('#deleteId').val(id);
      if(count>0){
          $('#articleAlert').html('Is '+count+' count article available. Are you sure delete?');
      }else{
        $('#articleAlert').html('Are you sure delete?');
      }
    
    $('#deleteModel').modal();
    });
    $('.edit-click').click(function(){
      let id=this.getAttribute('category-id');
      $.ajax({
        type:'GET',
        url:"{{route('admin.category.getdata')}}",
        data:{id:id},
        success:function(data){
          console.log(data);
          $('#category').val(data.name);
          $('#slug').val(data.slug);
          $('#category_id').val(data.id);
          $('#editModel').modal();
        }
      });
    });

    $('.switch').change(function() {
       $.get("{{route('admin.category.switch')}}", {id:this.getAttribute('category-id')}, function(data, status){
        console.log(data);
      }); 
    })
  })
</script>
@endsection