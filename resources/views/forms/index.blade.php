@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                  <a href="{{ url('submission-industries') }}">
                  <h3 >
                    Industries
                  </h3>
                </a>


                  {{-- @foreach ($industries as $industry)
                    <div class="card">
                      <a href="{{ url('industry/'.$industry->id) }}">
                        {{$industry->industry_name}}
                      </a>
                    </div>
                    <br>
                  @endforeach --}}

                  {{-- <h3 href="{{ url('submission-industries') }}">User Sizes</h3> --}}
                  {{-- <div class="panel-body"> --}}
                    <a href="{{ url('submission-user-sizes/') }}">
                    <h3 >
                      submission-user-sizes
                    </h3>
                  </a>

                  {{-- @foreach ($userSizes as $userSize)
                    <div class="card">
                      <a href="{{ url('user-size/'.$userSize->id) }}">
                        {{$userSize->user_size}}
                      </a>
                    </div>
                    <br>
                  @endforeach --}}

                  {{-- <h3 href="{{ url('submission-industries') }}">Price Ranges</h3> --}}
                  {{-- <div class="panel-body"> --}}
                    <a href="{{ url('submission-price-ranges') }}">
                    <h3 >
                      Price Ranges
                    </h3>
                  </a>

                  {{-- @foreach ($priceRanges as $priceRange)
                    <div class="card">
                      <a href="{{ url('price-range/'.$priceRange->id) }}">
                        {{$priceRange->price_range}}
                      </a>
                      {!! Form::open(['method' => 'DELETE', 'url' => "price-range/$priceRange->id", 'class' => 'form-horizontal']) !!}

                          <div class="btn-group pull-right">
                              {!! Form::submit("DELETE", ['class' => 'btn btn-danger']) !!}
                          </div>
                      {!! Form::close() !!}
                    </div>
                    <br>
                  @endforeach --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
