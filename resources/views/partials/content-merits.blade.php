@php
  global $post;
@endphp
<article>
  {!! category_description(get_field('category_to_show')) !!}

  @if(App\Merits::list())
    @foreach(App\Merits::list() as $post)
      @php(setup_postdata($post))
      <h3>{{ get_the_title() }} ({{ App\Merit::dots() }})</h3>
      @if(get_field('prerequisites'))
        <p>{!! get_field('prerequisites') ? '<strong>Prerequisites:</strong> '.get_field('prerequisites') : '' !!}</p>
      @endif
      {!! get_field('description') !!}
    @endforeach
    @php(wp_reset_postdata())
  @endif
</article>
