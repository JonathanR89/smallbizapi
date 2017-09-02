@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    {{-- <div class="row"> --}}
    <div class="panel panel-default">
        <div class="col-md-8 col-md-offset-2 table-responsive">
                <div class="panel-heading">Dashboard</div>
                <a class="btn btn-success pull-right" href="{{ url('/vendor/create') }}">Create new Vendor</a>
                <div class="panel-body">
                  <table style="width: 80%; overflow: auto; table-layout:fixed" class="table table-hover responsive">
                    <thead>
                      <tr>
                        <th>CRM</th>
                        <th>is_available</th>
                        <th>interested</th>
                        <th>edit</th>
                        {{-- <th>interested</th> --}}

                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($vendorsArray as $vendor)
                      @php
                        // dd($vendor);
                      @endphp
                        <tr>
                          <td>{{$vendor->name }}</td>

                        @if (@isset($vendor->is_available))
                          <td>{{$vendor->is_available }}</td>
                        @endif

                        @if (@isset($vendor->interested))
                          <td>{{$vendor->interested }}</td>
                        @endif

                        <td>
                          <a class="btn btn-success" href="{{ url('vendor/show/'.$vendor->id) }}">Edit</a>
                        </td>

                        </tr>
                    @endforeach
                  </tbody>
                  </table>
                </div>
            {{-- </div> --}}
        </div>
    {{-- </div> --}}
  </div>
{{-- </div> --}}
@endsection
