@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                  <h3>
                    Industries
                  </h3>


                  @foreach ($industries as $industry)
                    <div class="card">
                      <a href="{{ url('industry/'.$industry->id) }}">
                        {{$industry->industry_name}}
                      </a>
                    </div>
                    <br>
                  @endforeach

                  <h3>User Sizes</h3>

                  @foreach ($userSizes as $userSize)
                    <div class="card">
                      <a href="{{ url('user-size/'.$userSize->id) }}">
                        {{$userSize->user_size}}
                      </a>
                    </div>
                    <br>
                  @endforeach

                  <h3>Price Ranges</h3>

                  @foreach ($priceRanges as $priceRange)
                    <div class="card">
                      <a href="{{ url('price-range/'.$priceRange->id) }}">
                        {{$priceRange->price_range}}
                      </a>
                      {!! Form::open(['method' => 'DELETE', 'url' => "price-range/$priceRange->id/delete", 'class' => 'form-horizontal']) !!}

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
