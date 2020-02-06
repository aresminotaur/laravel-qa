{{-- favorite --}}
<a title="Click to mark as favorite (Click again to undo)" class="favorite mt-3 {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}" onclick="event.preventDefault(); document.getElementById('favorite-{{ $name }}-{{ $model->id }}').submit();">
  <i class="fas fa-star fa-3x"></i>
</a>
<span class="favorites-count mt-1">{{ $model->favorites_count }}</span>
<form style="" action="/questions/{{$model->id}}/favorites" method="post" id="favorite-question-{{ $model->id }}">
  @csrf
  {{-- if the question is not favorited only 'post' method will go --}}
  {{-- and if it is 'delete' will go too --}}
  @if ($model->is_favorited)
    @method('DELETE')
  @endif
</form>
