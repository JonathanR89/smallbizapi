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

                  @foreach ($priceRanges as $priceRange)
                    <div class="card">
                      <a href="{{ url('price-range/'.$priceRange->id) }}">
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
