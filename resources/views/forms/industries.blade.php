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
                  <div class="row">
                  <div class="card">
                      <h3>Add industries</h3>
                      {!! Form::open(['method' => 'POST', 'url' => 'submission-industries', 'class' => 'form-group']) !!}

                          <div class="form-group{{ $errors->has('industry_name') ? ' has-error' : '' }}">
                              {!! Form::label('industry_name', 'Industry Name') !!}
                              {!! Form::text('industry_name', null, ['class' => 'form-control']) !!}
                              <small class="text-danger">{{ $errors->first('industry_name') }}</small>
                          </div>

                          <div class="btn-group pull-right">
                              {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                              {!! Form::submit("Add", ['class' => 'btn btn-success']) !!}
                          </div>
                      {!! Form::close() !!}
                  </div>
                  </div>

                  <br>

                  @foreach ($industries as $industry)
                    <div class="row">
                      <div class="col-6 col-md-6 col-sx-12 col-sm-12">
                      <a class="text-center" href="{{ url('submission-industries/'.$industry->id.'/edit') }}">
                        {{$industry->industry_name ? $industry->industry_name : 'default'}}
                      </a>
                      </div>
                      <div class="col-6 col-md-6 col-sx-12 col-sm-12">
                      {!! Form::open(['method' => 'DELETE', 'url' => "submission-industries/$industry->id", 'class' => 'form-horizontal']) !!}

                          <div class="btn-group pull-right">
                              {!! Form::submit("DELETE", ['class' => 'btn btn-danger']) !!}
                          </div>
                      {!! Form::close() !!}

                      <a class = "btn btn-success pull-right" href="{{ url('submission-industries/'.$industry->id.'/edit') }}">
                        Edit
                      </a>
                      </div>
                    </div>
                    <br>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
