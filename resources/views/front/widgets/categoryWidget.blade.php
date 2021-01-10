@isset($categories)
    

<div class='col-md-3'>
    <div class="card">
      <div class="card-header">
        Categories
      </div>

    <div class="list-group">
      @foreach ($categories as $category )
        <li class="list-group-item @if(Request::segment(2)==$category->slug) active @endIf">
        <a @if(Request::segment(2)!=$category->slug) href="{{ route('category',$category->slug)}}" @endIf>{{$category->name}}</a> <span class="badge bg-dark float-right text-white">{{$category->getArticleCounts()}}</span></li>
      @endforeach
      
    </div>

    </div>
    </div>
    @endisset