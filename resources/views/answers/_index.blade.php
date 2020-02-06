<div class="row mt-4">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h2>{{ $answersCount . " " . Str::plural('Answer', $answersCount) }}</h2>
        </div>
        <hr>
        @include('layouts._messages')
        @foreach ($answers as $answer)

          {{-- answer vote controls --}}
          <div class="media">

              <div class="d-flex flex-column vote-controls">
                  <a title="This answer is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }} " onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{ $answer->id }}').submit();">
                    {{-- using font awesome --}}
                    <i class="fas fa-caret-up fa-3x"></i>
                  </a>
                  <form style="" action="/answers/{{$answer->id}}/vote" method="post" id="up-vote-answer-{{ $answer->id }}">
                    @csrf
                    {{-- sending that stupid request vote to controller --}}
                    <input type="hidden" name="vote" value="1">
                  </form>

                  <span class="votes-count">{{ $answer->votes_count }}</span>
                  <a title="This answer is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }} " onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{ $answer->id }}').submit();">
                    <i class="fas fa-caret-down fa-3x"></i>
                  </a>
                  <form style="" action="/answers/{{$answer->id}}/vote" method="post" id="down-vote-answer-{{ $answer->id }}">
                    @csrf
                    <input type="hidden" name="vote" value="-1">
                  </form>

                  @can ('accept', $answer)
                      {{-- we are submitting the following form when we click this button --}}
                      <a type="submit" title="Mark this answer as best answer" class="status {{ $answer->status }} mt-2" onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit();">
                        <i class="fas fa-check fa-2x"></i>
                      </a>

                      <form style="" action="{{route('answers.accept', $answer->id)}}" method="post" id="accept-answer-{{$answer->id}}">
                        @csrf
                      </form>
                  @else
                      @if ($answer->is_best)
                        <a class="status {{ $answer->status }} mt-2" style="cursor:pointer;">
                          <i class="fas fa-check fa-2x"></i>
                        </a>
                      @endif
                  @endcan

              </div>

              {{-- answer body --}}
              <div class="media-body">
                  {{-- answer body --}}
                  {!! $answer->body_html !!}

                  {{-- other controls --}}
                  <div class="row">
                      <div class="col-4">
                            @can('update', $answer)
                                <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info"> Edit </a>
                            @endcan

                            @can('delete', $answer)
                                <form class="form-delete" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" onclick="return confirm('are you sure?')" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endcan
                      </div>
                      <div class="col-4">

                      </div>
                      <div class="col-4">
                            <span class="text-muted"> Answered {{ $answer->created_date }} </span>
                            <div class="media mt-2">
                                    <a href="{{ $answer->user->url }}" class="pr-2">
                                          <img src="{{ $answer->user->avatar }}" alt="">
                                    </a>
                                    <div class="media-body mt-1">
                                      <a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
                                    </div>
                            </div>
                      </div>
                  </div>
              </div>

          </div>
          <hr>
        @endforeach
      </div>
    </div>
  </div>
</div>
