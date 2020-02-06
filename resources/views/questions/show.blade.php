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
                  @include('shared._vote', [
                    'model' => $question
                  ])
                  {{-- question body --}}
                  <div class="media-body">
                    {{-- Wth is this? We're making an accessor for this --}}
                    {{-- Got it! --}}
                    {{-- question body --}}
                    {!! $question->body_html !!}

                    {{-- user information --}}
                    <div class="row">
                      <div class="col-4"></div>
                      <div class="col-4"></div>
                      <div class="col-4">
                          @include('shared._author', [
                            'model' => $question,
                            'label' => 'asked by'
                          ])
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
