@extends('layouts.app')

@section('content')
<div class="container">
    {{-- QUESTION --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="card-title">
                  <div class="d-flex align-items-center">
                    <h1>{{ $question->title }}</h1>
                    <div class="ml-auto">
                      <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">Back</a>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="media">
                  {{-- vote controls --}}
                  <div class="d-flex flex-column vote-controls">
                    <a title="This question is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }} " onclick="event.preventDefault(); document.getElementById('up-vote-question-{{ $question->id }}').submit();">
                      {{-- using font awesome --}}
                      <i class="fas fa-caret-up fa-3x"></i>
                    </a>
                    <form style="" action="/questions/{{$question->id}}/vote" method="post" id="up-vote-question-{{ $question->id }}">
                      @csrf
                      {{-- sending that stupid request vote to controller --}}
                      <input type="hidden" name="vote" value="1">
                    </form>

                    <span class="votes-count">{{ $question->votes_count }}</span>
                    <a title="This question is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }} " onclick="event.preventDefault(); document.getElementById('down-vote-question-{{ $question->id }}').submit();">
                      <i class="fas fa-caret-down fa-3x"></i>
                    </a>
                    <form style="" action="/questions/{{$question->id}}/vote" method="post" id="down-vote-question-{{ $question->id }}">
                      @csrf
                      <input type="hidden" name="vote" value="-1">
                    </form>

                    {{-- favorite --}}
                    <a title="Click to mark as favorite (Click again to undo)" class="favorite mt-3 {{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '') }}" onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $question->id }}').submit();">
                      <i class="fas fa-star fa-3x"></i>
                    </a>
                    <span class="favorites-count mt-1">{{ $question->favorites_count }}</span>
                    <form style="" action="/questions/{{$question->id}}/favorites" method="post" id="favorite-question-{{ $question->id }}">
                      @csrf
                      {{-- if the question is not favorited only 'post' method will go --}}
                      {{-- and if it is 'delete' will go too --}}
                      @if ($question->is_favorited)
                        @method('DELETE')
                      @endif
                    </form>

                  </div>
                  {{-- question body --}}
                  <div class="media-body">
                    {{-- Wth is this? We're making an accessor for this --}}
                    {{-- Got it! --}}
                    {{-- question body --}}
                    {!! $question->body_html !!}

                    {{-- user information --}}
                    <div class="float-right">
                      <span class="text-muted"> {{ $question->created_date }} </span>
                      <div class="media mt-2">
                        <a href="{{ $question->user->url }}" class="pr-2">
                          <img src="{{ $question->user->avatar }}" alt="">
                        </a>
                        <div class="media-body mt-1">
                          <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>

    {{-- ANSWER --}}
    @include('answers._index', [
      'answersCount' => $question->answers_count,
      'answers' => $question->answers
    ]);
    @include('answers._create')
</div>
@endsection
