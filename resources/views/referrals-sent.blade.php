@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
          <div class="alert alert-info">
            <h3 >Referrals</h3>
            <h2>Total {{ $vendorRefferals->count() }}</h2>
            <h2>Today {{ $vendorRefferalsLastDay->count() }}</h2>
            <hr>
            @foreach ($popularPackageRefferals as $package)
              <h3>{{$package->package_name}} <br></h3>
              <h3>{{$package->occurrences}} <br></h3>
            @endforeach
          </div>
      </div>

    </div>

  </div>
</div>
</div>
@endsection
