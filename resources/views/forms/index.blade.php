@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                  <div class="card">

                  <a href="{{ url('submission-industries') }}">
                  <h3 >
                    Industries
                    <a href="{{ url('submission-industries') }}" class="btn btn-primary pull-right" name="button">Edit Industries</a>

                  </h3>
                </a>
              </div>


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
                  <div class="card">

                    <a href="{{ url('submission-user-sizes/') }}">
                    <h3 >
                       User Sizes
                      <a href="{{ url('submission-user-sizes') }}" class="btn btn-primary pull-right" name="button">Edit User Sizes</a>

                    </h3>
                  </a>
                </div>

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
                  <div class="card">

                    <a href="{{ url('submission-price-ranges') }}">
                    <h3 >
                      Price Ranges
                      <a href="{{ url('submission-price-ranges') }}" class="btn btn-primary pull-right" name="button">Edit Price Ranges</a>
                    </h3>
                  </a>
                </div>

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
