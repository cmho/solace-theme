@if(have_rows('sections'))
  @php
    $count = 1;
  @endphp
  @while(have_rows('sections'))
    @php(the_row())
    @if(get_row_layout() == 'single_text_column')
      
    @endif
    @php
      $count++;
    @endphp
  @endwhile
@endif
