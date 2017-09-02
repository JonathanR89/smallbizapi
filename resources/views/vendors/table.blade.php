@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    {{-- <div class="row"> --}}
    <div class="panel panel-default">
        <div class="table-responsive">
                {{-- <div class="panel-heading">Dashboard</div> --}}
                {{-- <div class="panel-body"> --}}
                <a href="{{ url('all-vendors') }}"></a>
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>CRM</th>
                        <th>USED in QQ2</th>
                        <th>Pricing pm</th>
                        {{-- <th>Free</th> --}}
                        {{-- <th>Column 10</th> --}}
                        <th>Description</th>
                        {{-- <th>LOGO</th> --}}
                        <th>Visit Website Button</th>
                        {{-- <th>Pricing To</th> --}}
                        {{-- <th>Pricing From</th> --}}
                        {{-- <th>Column 14</th> --}}
                        <th>interested</th>

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
                            @if ($vendor->is_available !== 1)
                              <td>YES</td>
                            @else
                              <td>NO</td>
                            @endif
                          @endif
                          <td>{{$vendor->pricing_pm }}</td>
                          {{-- <td>{{$vendor->name }}</td> --}}
                          {{-- @if (isset($vendor->{"USED in QQ2"}))
                            <td>{{$vendor->{"USED in QQ2"} }}</td>
                          @endif --}}
                          {{-- @if (@isset($vendor->{"Pricing pm"}))
                            <td>{{$vendor->{"Pricing pm"} }}</td>
                          @endif
                          @if (@isset($vendor->Free))
                            <td>{{$vendor->Free }}</td>
                          @endif --}}
                          {{-- <td>{{$vendor->{"Column 10"} }}</td> --}}
                          @if (@isset($vendor->description))
                          <td>{{$vendor->description }}</td>
                          {{-- <td>{{$vendor->LOGO }}</td> --}}
                        @endif
                        <td>{{$vendor->visit_website_url }}</td>

                          {{-- @if (@isset($vendor->{"Pricing To"}))
                            <td>{{$vendor->{"Pricing To"} }}</td>
                          @endif

                          {{-- @if (@isset($vendor->{"Pricing From"})) --}}
                          {{-- <td>{{$vendor->{"Pricing From"} }}</td>
                        @endif  --}}

                        {{-- @if (@isset($vendor->{"Column 14"}))
                          <td>{{$vendor->{"Column 14"} }}</td>
                        @endif --}}

                        @if (@isset($vendor->interested))
                          @if ($vendor->interested == 1)
                            <td>YES</td>
                            @else
                              <td>NO</td>
                          @endif
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
