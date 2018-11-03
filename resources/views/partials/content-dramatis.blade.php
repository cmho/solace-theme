@php
  global $post;
@endphp
@if(App\Characters::list())
  @foreach(App\Characters::list() as $post)
    @php(setup_postdata($post))
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="box">
        <div class="content">
          <h3>{{ get_the_title() }}{{ get_field('is_npc') ? " (NPC)" : '' }}</h3>
          @if(get_field('quote'))
            <p><em>{{ get_field('quote') }}</em></p>
          @endif
          {{ get_field('public_blurb') }}
        </div>
      </div>
    </div>
  @endforeach
  @php(wp_reset_postdata())
@endif
