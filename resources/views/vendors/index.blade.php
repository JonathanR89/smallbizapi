@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    {{-- <div class="row"> --}}
    <div class="panel panel-default">
        <div class="col-md-8 col-md-offset-2 table-responsive">
                {{-- <div class="panel-heading">Dashboard</div> --}}
                {{-- <div class="panel-body"> --}}
                  <table style="width: 80%; overflow: auto; table-layout:fixed" class="table table-hover responsive">
                    <thead>
                      <tr>
                        <th>CRM</th>
                        {{-- <th>USED in QQ2</th>
                        <th>Pricing pm</th>
                        <th>Free</th>
                        <th>Column 10</th>
                        <th>Description</th>
                        {{-- <th>LOGO</th> --}}
                        {{-- <th>Visit Website Button</th>
                        <th>Pricing To</th>
                        <th>Pricing From</th>
                        <th>Column 14</th> --}}
                        <th>Status</th>

                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($vendorsArray as $vendor)
                      @php
                        // dd($vendor);
                      @endphp
                        <tr>
                          <td>{{$vendor->CRM }}</td>

                        @if (@isset($vendor->Inactive))
                          <td>{{$vendor->Inactive }}</td>
                        @endif

                        </tr>
                    @endforeach
                  </tbody>
                  </table>
                </div>
            {{-- </div> --}}
        </div>
    {{-- </div> --}}
  {{-- </div> --}}
{{-- </div> --}}
@endsection
