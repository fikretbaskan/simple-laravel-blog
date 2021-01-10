@extends('front.layouts.master')
@section('title',$article->title)
@section('bg',asset($article->image))
@section('content')
    
    @include('front.widgets.categoryWidget')

    <!-- Post Content -->

          <div class="col-md-9 mx-auto">
           {!!$article->content!!}
           <span class="text-danger">Okunma sayısı : <b>{{$article->hit}}</b></span>
          </div>

@endsection