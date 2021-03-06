@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                  <a href="{{ url('question-selects') }}">
                  <h3 >
                  Back
                  </h3>
                </a>

                  <div class="card">
                      <h3>Edit   {{$industry->industry_name}}</h3>
                      {!! Form::open(['method' => 'PUT', 'url' => "submission-industries/$industry->id", 'class' => 'form-group']) !!}

                          <div class="form-group{{ $errors->has('industry_name') ? ' has-error' : '' }}">
                            {!! Form::label('industry_name', 'Industry Name') !!}
                              {!! Form::text('industry_name', $industry->industry_name, ['class' => 'form-control', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('industry_name') }}</small>
                          </div>

                          <div class="btn-group pull-right">
                              {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                              {!! Form::submit("Edit", ['class' => 'btn btn-success']) !!}
                          </div>
                      {!! Form::close() !!}
                  </div>

                  <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
