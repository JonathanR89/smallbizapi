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
                      Edit Price Ranges
                    </h3>
                  </a>

                  <div class="card">
                      <h3>Add Ranges</h3>
                      {!! Form::open(['method' => 'PUT', 'url' => "submission-price-ranges/ $priceRange->id", 'class' => 'form-group']) !!}

                          <div class="form-group{{ $errors->has('price_range') ? ' has-error' : '' }}">
                              {!! Form::label('price_range', 'price_range') !!}
                              {!! Form::text('price_range', $priceRange->price_range, ['class' => 'form-control', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('price_range') }}</small>
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
