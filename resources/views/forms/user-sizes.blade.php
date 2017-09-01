@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    <a href="{{ url('submission-price-ranges') }}">
                    <h3 >
                      Price Ranges
                    </h3>
                  </a>

                  <div class="card">
                      <h3>Add Ranges</h3>
                      {!! Form::open(['method' => 'POST', 'url' => 'submission-price-ranges', 'class' => 'form-group']) !!}

                          <div class="form-group{{ $errors->has('price_range') ? ' has-error' : '' }}">
                              {!! Form::label('price_range', 'price_range') !!}
                              {!! Form::text('price_range', null, ['class' => 'form-control', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('price_range') }}</small>
                          </div>

                          <div class="btn-group pull-right">
                              {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                              {!! Form::submit("Add", ['class' => 'btn btn-success']) !!}
                          </div>
                      {!! Form::close() !!}
                  </div>

                  <br>

                  @foreach ($priceRanges as $priceRange)
                    <div class="card">
                      <a href="{{ url('submission-price-ranges/'.$priceRange->id.'/edit') }}">
                        {{$priceRange->price_range}}
                      </a>
                      {!! Form::open(['method' => 'DELETE', 'url' => "submission-price-ranges/$priceRange->id", 'class' => 'form-horizontal']) !!}

                          <div class="btn-group pull-right">
                              {!! Form::submit("DELETE", ['class' => 'btn btn-danger']) !!}
                          </div>
                      {!! Form::close() !!}
                    </div>
                    <br>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
