@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                  <table>
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Name</th>
                        <th>Name</th>
                        <th>Name</th>
                        <th>Name</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($vendors as $vendor)
                      @php
                        dd($vendor);
                      @endphp
                        <tr>
                          <td>test</td>
                          <td>test</td>
                          <td>test</td>
                          <td>test</td>
                          <td>test</td>
                        </tr>
                    @endforeach
                  </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
