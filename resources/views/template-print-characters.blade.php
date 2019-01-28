@extends('layouts.print')

@section('content')
  @foreach(App\Characters::activeList() as $char)
    @include('partials.content-single-character')
  @endforeach
@endsection
