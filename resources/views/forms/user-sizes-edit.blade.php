@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    <a href="{{ url('submission-user-sizes') }}">
                    <h3 >
                      submission-user-sizes
                    </h3>
                  </a>

                  <div class="card">
                      {{-- <h3>Add Ranges</h3> --}}
                      {!! Form::open(['method' => 'PUT', 'url' => "submission-user-sizes/$userSize->id", 'class' => 'form-group']) !!}

                          <div class="form-group{{ $errors->has('user_size') ? ' has-error' : '' }}">
                              {!! Form::label('user_size', 'user_size') !!}
                              {!! Form::text('user_size', $userSize->user_size, ['class' => 'form-control', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('user_size') }}</small>
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
