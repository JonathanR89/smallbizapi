@extends('layouts.app')

@section('content')
  @php
    $options = [
      "multiple" => "multiple",
      "radio" => "radio",
      "text" => "text"
    ];
  @endphp
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/consultants">Consultants</a></li>
                    <li class="breadcrumb-item"><a href="/consultant-questionnaire">Categories</a></li>
                  </ol>
                </div>
                <div class="panel-body">
                  <h2>
                    {{ $category->name }}
                  </h2>
                  <div class="card">
                      <h3>Add Question</h3>
                      {!! Form::open(['method' => 'POST', 'url' => 'consultant-questions', 'class' => 'form-group']) !!}

                          <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                              {!! Form::label('question', 'question') !!}
                              {!! Form::text('question', null, ['class' => 'form-control', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('question') }}</small>
                          </div>

                          <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                              {!! Form::label('type', 'Type') !!}
                              {!! Form::select('type', $options, "", ['class' => 'form-control', 'required' => 'required', ]) !!}
                              <small class="text-danger">{{ $errors->first('type') }}</small>
                          </div>

                          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                              {!! Form::label('name', 'name') !!}
                              {!! Form::text('name', null, ['class' => 'form-control']) !!}
                              <small class="text-danger">{{ $errors->first('name') }}</small>
                          </div>

                          {!! Form::hidden('category_id', "$category->id") !!}

                          <div class="btn-group pull-right">
                              {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                              {!! Form::submit("Add", ['class' => 'btn btn-success']) !!}
                          </div>
                      {!! Form::close() !!}
                  </div>
                </div>
                <h3>Edit Questions</h3>

                @foreach ($questions as $question)
                  {{-- <div class="well"> --}}
                    <h5>{{ $question->question }}</h5>
                    <div class="alert alert-success"  role="alert">
                      <h5> type: {{ $question->type }}</h5>
                      {{-- @php
                        dd($question);
                      @endphp --}}
                      {{-- <a href="{{ route('consultant-questions.destroy', ['id' => $question->id]) }}"   class="btn btn-danger pull-right">Delete</a> --}}
                      {!! Form::open(['method' => 'DELETE',  'url' => "consultant-questions/$question->id",  'class' => 'form-horizontal']) !!}

                          <div class="btn-group pull-right">
                              {{-- {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!} --}}
                              {!! Form::submit("Destroy", ['class' => 'btn btn-danger']) !!}
                          </div>
                      {!! Form::close() !!}

                      <a href="{{ route('consultant-questions.edit', ['id' => $question->id]) }}" style="margin-right:20px;" class="btn btn-primary ">Edit</a>
                    </div>

                  {{-- </div> --}}
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
