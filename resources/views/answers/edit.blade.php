@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <h3>Edit Answer - Question: <strong>{{ $question->title }}</strong></h3>
            </div>
            <hr>
            <form class="" action="{{route('questions.answers.update', [$question->id, $answer->id])}}" method="post">
              @csrf
              {{-- If you have only one input to change, use PATCH instead of PUT --}}
              @method('PATCH')
              <div class="form-group">
                <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" rows="8" cols="80"> {{ old('body', $answer->body) }} </textarea>
                @if ($errors->has('body'))
                  <div class="invalid-feedback">
                    <strong>{{$errors->first('body')}}</strong>
                  </div>
                @endif
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-lg btn-primary" name="">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
