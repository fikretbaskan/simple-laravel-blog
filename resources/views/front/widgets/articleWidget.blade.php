
@foreach ($articles as $article)
          
      
          <div class="post-preview">
          <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}">
                <h2 class="post-title">
                  {{$article->title}}
                </h2>
              <img src="{{asset($article->image)}}" class="img-fluid" width="800" height="300"/>
                <h3 class="post-subtitle">
                  {!!Str::limit($article->content,75)!!}
                </h3>
              </a>
              <p class="post-meta">
              Category : <a href="#">{{$article->getCategory->name}}</a>, 
              <span class="float-right"> {{$article->updated_at->diffForHumans()}}</span>
             </p>
              
            </div>
           @if(!$loop->last)
           <hr>
           @endif
            @endforeach
            {{$articles->links("pagination::bootstrap-4")}}