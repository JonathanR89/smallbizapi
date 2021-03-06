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

                  <div class="card">
                      {{-- <h3>Edit: <br> {{ $question->name }}</h3> --}}
                      {{-- <h3>Add Question</h3> --}}
                      {!! Form::open(['method' => 'PUT', 'url' => "consultant-questions/$question->id", 'class' => 'form-group']) !!}

                          <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                              {!! Form::label('question', 'question') !!}
                              {!! Form::text('question', $question->question, ['class' => 'form-control', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('question') }}</small>
                          </div>

                          <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                              {!! Form::label('type', 'Type') !!}
                              {!! Form::select('type', $options, "$question->type", ['class' => 'form-control', 'required' => 'required', ]) !!}
                              <small class="text-danger">{{ $errors->first('type') }}</small>
                          </div>

                          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                              {!! Form::label('name', 'name') !!}
                              {!! Form::text('name', $question->name, ['class' => 'form-control']) !!}
                              <small class="text-danger">{{ $errors->first('name') }}</small>
                          </div>

                          {!! Form::hidden('category_id', "$question->category_id") !!}

                          <div class="btn-group pull-right">
                              {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                              {!! Form::submit("Update", ['class' => 'btn btn-success']) !!}
                          </div>
                      {!! Form::close() !!}

                  </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
