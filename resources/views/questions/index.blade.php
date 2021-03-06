@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <h2>Questions</h2>
                    <div class="ml-auto">
                      <a href="{{route('questions.create')}}" class="btn btn-outline-secondary">Ask Question</a>
                    </div>
                  </div>

                </div>

                <div class="card-body">
                  @include('layouts._messages')

                  {{-- check whether the array is empty. If not, executes the code. If is, runs @empty --}}
                  @forelse ($questions as $question)
                    <div class="media">
                      <div class="d-flex flex-column counters">
                        <div class="vote">
                          <strong> {{$question->votes_count}} </strong> {{Str::plural('vote', $question->votes_count)}}
                        </div>
                        <div class="status {{$question->status}}">
                          <strong> {{$question->answers_count}} </strong> {{Str::plural('answer', $question->answers_count)}}
                        </div>
                        <div class="view">
                         {{$question->views . " " . Str::plural('view', $question->views)}}
                        </div>
                      </div>
                      <div class="media-body">
                        <div class="d-flex align-items-center">
                          <h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>
                          <div class="ml-auto">
                            {{-- Same as: @if(Auth::user()->can('update', $question)) --}}
                            @can ('update', $question)
                              <a href="{{route('questions.edit', $question->id)}}" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan
                            {{-- Same as: @if(Auth::user()->can('delete', $question)) --}}
                            @can ('delete', $question)
                              <form class="form-delete" action="{{route('questions.destroy', $question->id)}}" method="post">
                              @method('DELETE') {{-- OLD WAY: {{method_field('DELETE')}} --}}
                              @csrf {{-- OLD WAY: {{csrf_token()}} --}}
                              <button type="submit" onclick="return confirm('are you sure?')" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                            @endcan
                          </div>
                        </div>

                        <p class="lead">
                          Asked by
                          <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                          <small class="text-muted">{{$question->created_date}}</small>
                        </p>
                        <div class="excerpt">
                            {{-- {!! Str::limit($question->body_html, 250) !!} --}}
                            {{-- OR --}}
                            {{-- better because turns every sort of language into pure string --}}
                            {{-- and will not break if the limit exceeds 250 as it's predecessor would have --}}
                            {{-- {{ Str::limit(strip_tags($question->body_html), 300) }} --}}
                            {{-- making code much simpler --}}
                            {{ $question->excerpt }}
                        </div>
                      </div>
                    </div>
                    <hr>
                  @empty
                      <div class="alert alert-warning">
                          <strong>Sorry!</strong> There are no questions available
                      </div>
                  @endforelse

                  {{$questions->links()}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
