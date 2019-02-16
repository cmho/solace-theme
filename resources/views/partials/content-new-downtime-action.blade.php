<div class="box">
  <div class="content">
    <form action="{{ esc_url( admin_url('admin-post.php') ) }}" method="POST">
      <div class="form-row">
        <label for="post_title">Title</label>
        <input type="text" name="post_title" value="{{ (get_post_type() == 'downtime') ? get_the_title() : '' }}" />
      </div>
      @if(App\App::isAdmin())
        @php
          $characters = get_posts(array(
            'post_type' => 'character',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
          ));
        @endphp
        <div class="form-row">
          <label for="character">Act as Character</label>
          <select name="character">
            @foreach($characters as $character)
              <option value="{{ $character->ID }}">{!! $character->post_title !!}</option>
            @endforeach
          </select>
        </div>
      @else
        @php
          $char = get_posts(array(
            'post_type' => 'character',
            'posts_per_page' => 1,
            'orderby' => 'date_modified',
            'order' => 'DESC',
            'meta_input' => array(
              array(
                'key' => 'status',
                'value' => 'Active'
              )
            )
          ));
          $character = $char[0];
        @endphp
        <input type="hidden" name="character" value="{{ $character->ID }}" />
      @endif
      <input type="hidden" name="game" value="{{ App\App::currentDowntimePeriod()->ID }}" />
      <div class="form-row">
        <label for="action_type">Action Type</label>
        <select name="action_type">
          <option value="Preserve"{{ get_field('action_type') == 'Preserve' ? ' selected="selected"' : '' }}>Preserve</option>
          <option value="Change"{{ get_field('action_type') == 'Change' ? ' selected="selected"' : '' }}>Change</option>
          <option value="Gather Knowledge"{{ get_field('action_type') == 'Gather Knowledge' ? ' selected="selected"' : '' }}>Gather Knowledge</option>
          <option value="Personal Action"{{ get_field('action_type') == 'Personal Action' ? ' selected="selected"' : '' }}>Personal Action</option>
        </select>
      </div>
      <div class="form-row">
        <label for="assets">Assets</label>
        <input type="text" name="assets" value="{{ get_field('assets') }}" />
      </div>
      <div class="form-row">
        <label for="goal">Goal</label>
        <input type="text" name="goal" value="{{ get_field('goal') }}" />
      </div>
      <div class="form-row">
        <label for="post_content">Description</label>
        <textarea name="post_content" rows="8"></textarea>
      </div>
      <div class="form-row">
        @php
          $games = get_posts(array(
            'post_type' => 'game',
            'posts_per_page' => 1,
            'meta_query' => array(
              'relation' => 'AND',
              array(
                'key' => 'downtimes_open',
                'value' => date('Ymd'),
                'compare' => '<=',
                'type' => 'DATE'
              ),
              array(
                'key' => 'downtimes_close',
                'value' => date('Ymd'),
                'compare' => '>=',
                'type' => 'DATE'
              )
            )
          ));
        @endphp
        <input type="hidden" name="game"{{ $games ? 'value="'.$games[0]->ID.'"' : '' }} />
        <input type="hidden" name="action" value="update_downtime" />
        <input type="submit" value="Save" />
      </div>
    </form>
  </div>
</div>
