@extends('front.layouts.master')
@section('title',$category->name. ' Kategorisi | '.count($articles).' yazı bulundu.')
@section('content')

@include('front.widgets.categoryWidget')
    <div class="col-md-9 mx-auto">

@if (count($articles)>0)  
  @include('front.widgets.articleWidget')
  @else

  <div class="alert alert-danger"><h2>Bu kategoriye ait yazı bulunamadı.</h2></div>

   @endif
  </div>
   @endsection