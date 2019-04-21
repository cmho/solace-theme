
<section id="downtime-action" class="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-xs-12">
        <div class="breadcrumb">
          <a href="{{ App\App::downtimesLink() }}">Downtime Actions</a> &gt;
          <a href="{{ App\App::downtimesLink() }}#{{ get_post(get_field('game'))->post_name }}">{{ get_post(get_field('game'))->post_title }}</a>
        </div>
      </div>
    </div>
    @if(get_query_var('mode') === 'edit')
      <form class="row" action="{{ esc_url( admin_url('admin-post.php') ) }}" method="POST">
        <input type="hidden" name="id" value="{{ get_the_ID() }}" />
        <input type="hidden" name="action" value="update_downtime" />
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
        <div class="col-md-4 col-xs-12">
          <h2>{!! get_the_title() !!}</h2>
          <div class="form-row">
            <label name="action_type">Action Type</label>
            <select name="action_type">
              <option value="Preserve"{{ get_field('action_type') == 'Preserve' ? ' selected="selected"' : '' }}>Preserve</option>
              <option value="Change"{{ get_field('action_type') == 'Change' ? ' selected="selected"' : '' }}>Change</option>
              <option value="Gather Knowledge"{{ get_field('action_type') == 'Gather Knowledge' ? ' selected="selected"' : '' }}>Gather Knowledge</option>
              <option value="Personal Action"{{ get_field('action_type') == 'Personal Action' ? ' selected="selected"' : '' }}>Personal Action</option>
            </select>
          </div>
        </div>
        <div class="col-md-8 col-xs-12">
          <div class="box">
            <div class="content">
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
                <textarea name="post_content" rows="8">{{ get_the_content() }}</textarea>
              </div>
              <div class="form-row">
                <input type="submit" value="Save" />
              </div>
            </div>
          </div>
        </div>
      </form>
    @else
      <div class="row">
        <div class="col-md-4 col-xs-12">
          <h2>{!! get_the_title() !!}</h2>
          <p class="character"><strong>Character:</strong> {{ get_post(get_field('character'))->post_title }}</p>
          <p class="action-type"><strong>Action Type:</strong> {{ get_field('action_type') }}</p>
        </div>
        <div class="col-md-8 col-xs-12">
          <div class="box">
            <div class="content">
              <p class="assets"><strong>Assets:</strong> {{ get_field('assets') }}</p>
              <p class="goal"><strong>Goal:</strong> {{ get_field('goal') }}</p>
              @php(the_content())
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
</section>
@if(App\App::isAdmin())
  <section id="response" class="yellow">
    <div class="wrapper">
      <div class="row">
        <div class="col-md-4 col-xs-12">
          <h3>Response</h3>
        </div>
        <div class="col-md-8 col-xs-12">
          <form action="{{ esc_url( admin_url('admin-post.php') ) }}" method="POST">
            <textarea name="response">{!! get_field('response') !!}</textarea>
            <input type="hidden" name="id" value="{{ get_the_ID() }}" />
            <input type="hidden" name="action" value="downtime_response" />
            <button type="submit" class="button">Respond</button>
          </form>
        </div>
      </div>
    </div>
  </section>
@endif
