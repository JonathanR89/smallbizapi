@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Consultants Add
                </div>
                <div class="panel-body">
                    {!! Form::open(['method' => 'POST', 'url' => 'consultant-questionnaire', 'class' => 'form-group']) !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'name') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('name') }}</small>
                        </div>

                        <div class="form-group{{ $errors->has('subheading') ? ' has-error' : '' }}">
                            {!! Form::label('subheading', 'subheading') !!}
                            {!! Form::textarea('subheading', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('subheading') }}</small>
                        </div>

                        <div class="btn-group pull-right">
                            {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                            {!! Form::submit("Add", ['class' => 'btn btn-success']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
