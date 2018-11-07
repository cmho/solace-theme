@if(have_rows('sections'))
  @php
    $count = 1;
  @endphp
  @while(have_rows('sections'))
    @php(the_row())
    
    @php
      $count++;
    @endphp
  @endwhile
@endif
