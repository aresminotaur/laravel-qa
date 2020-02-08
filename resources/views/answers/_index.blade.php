@if ($answersCount > 0)
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

              {{-- vote controls --}}
              @include('shared._vote', [
                'model' => $answer
              ])

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
                          @include('shared._author', [
                            'model' => $answer,
                            'label' => 'answered'
                          ])
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
@endif
