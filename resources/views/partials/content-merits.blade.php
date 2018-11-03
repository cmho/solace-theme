<article>
  @if(App\Merits::list())
    @foreach(App\Merits::list() as $post)
      <h3>{{ get_the_title() }} {{ join(", ", get_field('allowed_ratings')) }}</h3>
      {{ get_field('prerequisites') ? '<strong>Prerequisites:</strong> '.get_field('prerequisites') : '' }}
      {{ get_the_content() }}
    @endforeach
  @endif
</article>
