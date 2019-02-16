<section id="downtime-action" class="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-xs-12">
        <div class="breadcrumb">
          <a href="{{ App\App::downtimesLink() }}">Downtime Actions</a> &gt;
          <a href="{{ App\App::downtimesLink() }}#{{ get_field('game')->post_name }}">{{ get_field('game')->post_title }}</a>
        </div>
      </div>
      <div class="col-md-4 col-xs-12">
        <h2>{!! get_the_title() !!}</h2>
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
  </div>
</section>
@if($_GET['mode'] == 'respond' && App\App::isAdmin())
  <section id="respond" class="yellow">
    <div class="wrapper">
      <div class="row">
        <div class="col-md-4 col-xs-12">
          <h3>Response</h3>
        </div>
        <div class="col-md-8 col-xs-12">
          <form action="{{ esc_url( admin_url('admin-post.php') ) }}" method="POST">
            <textarea name="response">{!! get_field('response') !!}</textarea>
            <button type="submit" class="button">Respond</button>
            <input type="hidden" name="action" value="downtime_response" />
          </form>
        </div>
      </div>
    </div>
  </section>
@endif
