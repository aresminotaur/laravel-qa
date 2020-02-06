@can ('accept', $model)
    {{-- we are submitting the following form when we click this button --}}
    <a type="submit" title="Mark this answer as best answer" class="status {{ $model->status }} mt-2" onclick="event.preventDefault(); document.getElementById('accept-answer-{{$model->id}}').submit();">
      <i class="fas fa-check fa-2x"></i>
    </a>

    <form style="" action="{{route('answers.accept', $model->id)}}" method="post" id="accept-answer-{{$model->id}}">
      @csrf
    </form>
@else
    @if ($model->is_best)
      <a class="status {{ $model->status }} mt-2" style="cursor:pointer;">
        <i class="fas fa-check fa-2x"></i>
      </a>
    @endif
@endcan
