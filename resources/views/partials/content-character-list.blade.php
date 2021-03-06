@php
  global $post;
@endphp
<div class="flash"></div>
<div class="button-row right">
  <a href="{{ App\App::newCharacterLink() }}" class="button">New Character</a>
  @if($is_admin)
    <a href="#" class="button" id="send-approvals-button">Send Approvals</a>
  @endif
</div>

<table id="character-table" class="datatable"{{ !$is_admin ? ' data-searching=false data-paging=false' : '' }}>
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
            <a href="{{ get_the_permalink() }}edit">Edit</a>
            @if(get_field('status') == 'Active')
              <a href="{{ App\App::downtimesLink() }}">Downtime Actions</a>
            @endif
            <a href="#" class="delete-link" data-id="{{ get_the_ID() }}">Delete</a>
          </div>
        </td>
        @if($is_admin)
          <td>{{ get_the_author_meta('nickname') }}</td>
        @endif
        <td>{{ get_field('family') }}</td>
        <td>{{ get_field('status') }}</td>
      </tr>
    @endforeach
    @php(wp_reset_postdata())
  </tbody>
</table>
