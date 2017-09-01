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
                      <h3>Add User Sizes</h3>
                      {!! Form::open(['method' => 'POST', 'url' => 'submission-user-sizes', 'class' => 'form-group']) !!}

                          <div class="form-group{{ $errors->has('user_size') ? ' has-error' : '' }}">
                              {!! Form::label('user_size', 'User Size Name') !!}
                              {!! Form::text('user_size', null, ['class' => 'form-control', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('user_size') }}</small>
                          </div>

                          <div class="btn-group pull-right">
                              {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                              {!! Form::submit("Add", ['class' => 'btn btn-success']) !!}
                          </div>
                      {!! Form::close() !!}
                  </div>

                  <br>

                  @foreach ($userSizes as $userSize)
                    <div class="card">
                      <a href="{{ url('submission-user-sizes/'.$userSize->id.'/edit') }}">
                        {{$userSize->user_size}}
                      </a>
                      {!! Form::open(['method' => 'DELETE', 'url' => "submission-user-sizes/$userSize->id", 'class' => 'form-horizontal']) !!}

                          <div class="btn-group pull-right">
                              {!! Form::submit("DELETE", ['class' => 'btn btn-danger']) !!}
                          </div>
                      {!! Form::close() !!}
                      <a class="btn btn-success pull-right" href="{{ url('submission-user-sizes/'.$userSize->id.'/edit') }}">
                      Edit
                      </a>
                    </div>
                    <br>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
