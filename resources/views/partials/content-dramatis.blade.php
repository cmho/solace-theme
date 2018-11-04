@php
  global $post;
@endphp
@if(App\Characters::activeList())
  @foreach(App\Characters::activeList() as $post)
    @php(setup_postdata($post))
    <div class="col-sm-6 col-xs-12">
      <div class="box">
        <div class="content">
          <h3>{{ get_the_title() }}{{ get_field('is_npc') ? " (NPC)" : '' }}</h3>
          @if(get_field('quote'))
            <p class="quote">{{ get_field('quote') }}</p>
          @endif
          {!! get_field('public_blurb') !!}
        </div>
      </div>
    </div>
  @endforeach
  @php(wp_reset_postdata())
@endif
