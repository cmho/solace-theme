{{--
  Template Name: Character Creation Template
--}}

@php
  $is_admin = in_array('administrator', $user->roles);
@endphp

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <section class="grey">
      <div class="wrapper">
        <div class="row center-xs">
          <div class="col-xs-12">
            @include('partials.page-header')
          </div>
        </div>
      </div>
    </section>
    @if($_GET['method'] == 'wizard')

    @else

    @endif
  @endwhile
@endsection
