<article @php post_class('content') @endphp>
  <header>
    <h2 class="entry-title"><a href="@php the_permalink() @endphp">@php @the_title() @endphp</a></h2>
    @include('partials/entry-meta')
  </header>
  <div class="entry-summary">
    @php the_excerpt() @endphp
  </div>
</article>
