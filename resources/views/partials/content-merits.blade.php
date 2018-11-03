@php
  global $post;
@endphp
<article>
  @if(App\Merits::list())
    @foreach(App\Merits::list() as $post)
      @php(setup_postdata($post))
      <h3>{{ get_the_title() }} ({{ App\Merit::dots() }})</h3>
      {!! get_field('prerequisites') ? '<strong>Prerequisites:</strong> '.get_field('prerequisites') : '' !!}
      {{ get_field('description') }}
    @endforeach
    @php(wp_reset_postdata())
  @endif
</article>
