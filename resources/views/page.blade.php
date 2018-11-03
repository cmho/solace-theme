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
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="content">
                @include('partials.content-page')
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  @endwhile
@endsection
