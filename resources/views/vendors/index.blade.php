@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="col-md-8 col-md-offset-2 table-responsive">
                <div class="panel-heading">
                  <h3>
                    <a class="btn btn-success pull-right" href="{{ url('/vendor/create') }}">Create new Vendor</a>
                    <a class="btn btn-primary pull-right" href="{{ url('/crm_vendors') }}">View Table</a>
                    Current Vendors listing
                  </h3>
                </div>
                <div class="panel-body">
                  <table style="width: 80%; overflow: auto; table-layout:fixed" class="table table-hover responsive">
                    <thead>
                      <tr>
                        <th>CRM</th>
                        <th>is_available</th>
                        <th>interested</th>
                        <th>edit</th>
                        <th>Delete</th>
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
                          @if ($vendor->is_available == 1)
                            <td>YES</td>
                            @else
                              <td>NO</td>
                          @endif
                        @endif

                        @if (@isset($vendor->interested))
                          @if ($vendor->interested == 1)
                            <td>YES</td>
                            @else
                              <td>NO</td>
                          @endif
                        @endif

                        <td>
                          <a class="btn btn-success" href="{{ url('vendor/show/'.$vendor->id) }}">Edit</a>
                        </td>

                        <td>
                          <a class="btn btn-danger" href="{{ url('vendor/'.$vendor->id.'/destroy') }}">Delete</a>
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
