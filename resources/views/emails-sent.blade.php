@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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
    </div>
</div>
@endsection
