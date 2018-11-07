@extends('layouts.app')

@section('content')
  <section class="grey">
    <div class="wrapper">
      <div class="row center-xs">
        <div class="col-xs-12">
          @include('partials.page-header')
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="content">
              @if (!have_posts())
                <div class="alert alert-warning">
                  {{ __('Sorry, but the page you were trying to view does not exist.', 'sage') }}
                </div>
                {!! get_search_form(false) !!}
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection