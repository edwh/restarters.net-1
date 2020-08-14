<div class="card card-talk">
  <div class="card-body @if( strtotime($hot_topic->created_at) > strtotime('-4 days') ) created-recently @endif d-flex flex-row align-items-start align-items-md-center">
    <div class="mr-auto">
      <h5>
        <a href="{{ env('DISCOURSE_URL') }}/session/sso?return_path={{ env('DISCOURSE_URL') }}/t/{{ $hot_topic->slug }}/{{ $hot_topic->id }}">
          @if ($hot_topic->unicode_title)
            {{ $hot_topic->unicode_title }}
          @else
            {{ $hot_topic->title }}
          @endif
        </a>
      </h5>

      <div class="card-talk-summary">
        @if( isset($hot_topics['talk_categories'][$hot_topic->category_id]) )
          <span class="rectangle-tag">
            <span style="background: #{{ $hot_topics['talk_categories'][$hot_topic->category_id]->color }};"></span>
            {{ $hot_topics['talk_categories'][$hot_topic->category_id]->name }}
          </span>
        @endif

        @if (! empty($hot_topic->tags))
          @foreach ($hot_topic->tags as $tag)
            <span class="tag">
              {{ $tag }}
            </span>
          @endforeach
        @endif
      </div>
    </div>

    <div class="d-none d-md-block mr-50">
      <div class="avatar-images-list">
        @foreach ($hot_topic->posters as $user)
          <img class="rounded-circle" src="{{ $user->avatar_url }}">
        @endforeach
      </div>
    </div>

    <div class="d-flex flex-column-reverse flex-md-row align-items-center">
      <div class="replies mr-0 mr-md-35">
        {{ $hot_topic->posts_count }}
      </div>

      <div>
        {{ $hot_topic->friendly_date }}
      </div>
    </div>
  </div>
</div>
