@php
  global $post;
@endphp

<section id="character-list" class="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-xs-12">
        <table id="character-table" class="datatable">
          <thead>
            <tr>
              <th>Name</th>
              @if($is_admin)
                <th>Player</th>
              @endif
              <th>Family</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach(App\Characters::list() as $post)
              @php(setup_postdata($post))
              <tr>
                <td>
                  <div class="name"><a href="{{ get_the_permalink() }}">{!! get_the_title() !!}</a></div>
                  <div class="controls">
                    <a href="{{ get_the_permalink() }}?mode=edit">Edit</a>
                    @if(get_field('status') == 'Active')
                      <a href="#">Downtime Actions</a>
                    @endif
                    <a href="#" class="delete-link">Delete</a>
                  </div>
                </td>
                @if($is_admin)
                  <td>{{ get_the_author() }}</td>
                @endif
                <td>{{ get_field('family') }}</td>
                <td>{{ get_field('status') }}</td>
              </tr>
            @endforeach
            @php(wp_reset_postdata())
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
