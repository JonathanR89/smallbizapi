@extends('layouts.app')

@section('content')
  @php
    $options = \App\Package::pluck('name')->toArray();
    $options = array_combine($options, $options);
  @endphp
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Consultants Add
                </div>
                <div class="panel-body">
                    {!! Form::open(['method' => 'POST', 'route' => 'save_consultant', 'class' => 'form-group']) !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'name') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('name') }}</small>
                        </div>

                        <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                            {!! Form::label('surname', 'surname') !!}
                            {!! Form::text('surname', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('surname') }}</small>
                        </div>

                        <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                            {!! Form::label('company', 'company') !!}
                            {!! Form::text('company', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('company') }}</small>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email', 'email') !!}
                            {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                        </div>

                        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                            {!! Form::label('country', 'country') !!}
                            {!! Form::text('country', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('country') }}</small>
                        </div>

                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            {!! Form::label('phone_number', 'phone number') !!}
                            {!! Form::text('phone_number', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('phone_number') }}</small>
                        </div>

                        <div class="form-group{{ $errors->has('specialises_in') ? ' has-error' : '' }}">
                            {!! Form::label('specialises_in', 'specialises_in') !!}
                            {!! Form::select('specialises_in', $options, "", ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('specialises_in') }}</small>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description', 'description') !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('description') }}</small>
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
