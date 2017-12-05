@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">

          <div class="panel panel-default">

            <div class="panel-body">
              <center>
                {!! $submissionHistoryGraph->html() !!}
              </center>

            </div>
          </div>

    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
          {{-- <table class="table responsive">
            <thead>
              <tr>
                <th>date</th>
                <th>pageTitle</th>
                <th>pageViews</th>
                <th>visitors</th>

              </tr>
            </thead>
            <tbody>
              @foreach ($analyticsData as $key => $data)
                <tr>
                  <td>{{ $data['date'] }}</td>
                  <td>{{ $data['pageTitle'] }}</td>
                  <td>{{ $data['pageViews'] }}</td>
                  <td>{{ $data['visitors'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table> --}}
          {{-- <center>
                {!! $submissionHistoryGraph->html() !!}
            </center>
          <center>
                {!! $submissionUseLineGraph->html() !!}
            </center> --}}
            <center>
                  {!! $weeklySubmissionsGraph->html() !!}
              </center>

        </div>
      </div>

      <div class="panel panel-default">

        <div class="panel-body">
          <strong>Top Refferers</strong> <br>
          <table class="table responsive">
            <thead>
              <tr>
                <th>url</th>
                <th>pageViews</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($topReferrers as $key => $data)
                <tr>
                  <td>{{ $data['url'] }}</td>
                  <td>{{ $data['pageViews'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="panel panel-default">

        <div class="panel-body">
          <strong>Top Browsers</strong> <br>
          <table class="table responsive">
            <thead>
              <tr>
                <th>browser</th>
                <th>sessions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($topBrowsers as $key => $data)
                <tr>
                  <td>{{ $data['browser'] }}</td>
                  <td>{{ $data['sessions'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <div class="col-md-6">
      <div class="panel panel-default">

        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <div class="alert alert-info">
                  <h3>Submissions Last Month</h3>
                  <h2>{{ $submissionsLastMonth->count() }}</h2>
                </div>
              </div>
              <div class="col-md-6">
                <div class="alert alert-info">
                  <h3>Submissions Last Week</h3>
                  <h2>{{ $submissionsLastWeek->count() }}</h2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="alert alert-info">
                  <h3>Total Submissions</h3>
                  <h2>{{ $totalSubmissionsOldNew->count() }}</h2>
                </div>
              </div>
              <div class="col-md-6">
                <div class="alert alert-info">
                  <h3>New Platform <br> Submissions </h3>
                  <h2>{{ $totalSubmissions->count() }}</h2>
                </div>
              </div>
            </div>
            {{-- <div class="row">
              <div class="col-md-6">
                <div class="alert alert-info">
                  <h3>Submissions <br> Today </h3>
                  <h2>{{ $submissionsToday->count() }}</h2>
                </div>
              </div>
              <div class="col-md-6">
                <div class="alert alert-info">
                  <h3>Submissions <br> Yesterday</h3>
                  <h2>{{ $submissionsYesterday->count() }}</h2>
                </div>
              </div>
            </div> --}}
            <div class="row">
              <div class="col-md-6">
                <div class="alert alert-info">
                  <h3>Submissions <br> Today </h3>
                  <h2>{{ $submissionsTodayNEW->count() }}</h2>
                </div>
              </div>
              <div class="col-md-6">
                <div class="alert alert-info">
                  <h3>Submissions <br> Yesterday</h3>
                  <h2>{{ $submissionsYesterdayNEW->count() }}</h2>
                </div>
              </div>
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
            {{-- @foreach ($popularPages as $key => $popularPage)
            {{ $popularPage }} <br>
            @endforeach --}}
            <table>
              <thead>
                <tr>
                  <th>url</th>
                  <th>pageTitle</th>
                  <th>pageViews</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($popularPages as $key => $popularPage)
                  <tr>
                    <td>{{ $popularPage['url'] }}</td>
                    <td>{{ $popularPage['pageTitle'] }}</td>
                    <td>{{ $popularPage['pageViews'] }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>

          </div>
          </div>
          <div class="row">
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
  <div class="row">
    <div class="row">
      <div class="col-md-5">
        <h3>
          Total Mails Sent : {{ $emailsSentTotalCount }}
        </h3>

        <table class="table responsive">
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

  </div>
  </div>
</div>
</div>
{!! Charts::scripts() !!}
{!! $weeklySubmissionsGraph->script() !!}
{!! $submissionUseLineGraph->script() !!}
{!! $submissionHistoryGraph->script() !!}
@endsection
