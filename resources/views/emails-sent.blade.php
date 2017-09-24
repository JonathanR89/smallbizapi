@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
          <h3>
            Total Mails Sent : {{ $emailsSentTotalCount }}
          </h3>

          <table>
            <thead>
              <tr>
                <th>date</th>
                <th>to</th>
                <th>subject</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($emailsSentTotal as $emailSent)
                <tr>
                  <td>{{ $emailSent->date }}</td>
                  <td>{{ $emailSent->to }}</td>
                  <td>{{ $emailSent->subject }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          {{ $emailsSentTotal->links() }}

          {{-- You are logged in! --}}
        </div>
      </div>

    </div>
    <div class="col-md-6">
      <div class="panel panel-default">

        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
          <div class="alert alert-info">
            <h3>Submissions Last Month</h3>
            <h2>{{ $submissionsLastMonth->count() }}</h2>
          </div>
          <div class="alert alert-info">
            <h3>Submissions Last Month</h3>
            <h2>{{ $submissionsLastMonth->count() }}</h2>
          </div>
          <div class="alert alert-info">
            <h3>Pageloads</h3>
            <h2>{{ $pageLoads->count() }}</h2>
            Today <br>
            <h2>{{ $pageLoadsToday->count() }}</h2>
            Average Time in seconds <br>
            <h2>{{ $medianTime }}</h2>
            <div class="row">
              <div class="col-md-5">
            <strong>Most popular page</strong> <br>
            @foreach ($popularPages as $key => $popularPage)
            {{ $popularPage }} <br>
            @endforeach
          </div>
          <div class="col-md-5">
          <strong>  Most time spent</strong> <br>
            @foreach ($maxTime->take(5) as $key => $popularPage)
            {{ $popularPage->page_from }} <strong>{{ gmdate("H:i:s",$popularPage->time_spent) }}</strong> <br>
            @endforeach
          </div>
          </div>

          </div>
          <a href="{{url('referrals-sent')}}">
          <div class="alert alert-info">
            <h3 >Referrals</h3>
            <h2>{{ $vendorRefferals->count() }}</h2>
            {{-- @foreach ($vendorRefferals as $package)
              <h3>{{$package->name}} <br></h3>
            @endforeach --}}
          </div>
        </a>

          <div class="alert alert-info">
            <h3>Popular Vendors</h3>
            @foreach ($packages as $package)

              <h3>{{$package[0]->name}} <br> occurrences: {{ $package['occurrences'] }}</h3>

            @endforeach
            {{-- <h2>{{ $packages }}</h2> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
