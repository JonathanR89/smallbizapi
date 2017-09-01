@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <a class="btn btn-primary pull-right" href="http://qq2-admin.smallbizcrm.com/">
          QQ2 Admin Questions
        </a>
        <div class="panel-heading">
          Edit Industry
          </div>

        <div class="panel-body">
          <div class="card">

            <a href="{{ url('submission-industries') }}">
              <h3 >
                Industries
                <a href="{{ url('submission-industries') }}" class="btn btn-primary pull-right" name="button">Edit Industries</a>

              </h3>
            </a>
          </div>


          <div class="card">

            <a href="{{ url('submission-user-sizes/') }}">
              <h3 >
                User Sizes
                <a href="{{ url('submission-user-sizes') }}" class="btn btn-primary pull-right" name="button">Edit User Sizes</a>

              </h3>
            </a>
          </div>


          <div class="card">

            <a href="{{ url('submission-price-ranges') }}">
              <h3 >
                Price Ranges
                <a href="{{ url('submission-price-ranges') }}" class="btn btn-primary pull-right" name="button">Edit Price Ranges</a>
              </h3>
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
