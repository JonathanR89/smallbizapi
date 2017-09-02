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
                        <th>USED in QQ2</th>
                        <th>Pricing pm</th>
                        <th>Free</th>
                        <th>Column 10</th>
                        <th>Description</th>
                        {{-- <th>LOGO</th> --}}
                        <th>Visit Website Button</th>
                        <th>Pricing To</th>
                        <th>Pricing From</th>
                        <th>Column 14</th>
                        <th>Inactive</th>

                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($vendorsArray as $vendor)
                      @php
                        // dd($vendor);
                      @endphp
                        <tr>
                          <td>{{$vendor->CRM }}</td>
                          @if (isset($vendor->{"USED in QQ2"}))
                            <td>{{$vendor->{"USED in QQ2"} }}</td>
                          @endif
                          @if (@isset($vendor->{"Pricing pm"}))
                            <td>{{$vendor->{"Pricing pm"} }}</td>
                          @endif
                          @if (@isset($vendor->Free))
                            <td>{{$vendor->Free }}</td>
                          @endif
                          {{-- <td>{{$vendor->{"Column 10"} }}</td> --}}
                          @if (@isset($vendor->Description))
                          <td>{{$vendor->Description }}</td>
                          {{-- <td>{{$vendor->LOGO }}</td> --}}
                        @endif
                          @if (@isset($vendor->{"Visit Website Button"}))
                          <td>{{$vendor->{"Visit Website Button"} }}</td>
                        @endif
                          @if (@isset($vendor->{"Pricing To"}))
                            <td>{{$vendor->{"Pricing To"} }}</td>
                          @endif

                          @if (@isset($vendor->{"Pricing From"}))
                          <td>{{$vendor->{"Pricing From"} }}</td>
                        @endif

                        @if (@isset($vendor->{"Column 14"}))
                          <td>{{$vendor->{"Column 14"} }}</td>
                        @endif

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
