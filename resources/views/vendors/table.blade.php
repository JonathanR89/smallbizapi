@extends('layouts.app')

@section('content')
  <div class="panel panel-default">
    <div class="table-responsive">

      <a href="{{ url('all-vendors') }}"></a>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>CRM</th>
            <th>USED in QQ2</th>
            <th>Pricing pm</th>
            <th>Description</th>
            <th>Visit Website Button</th>
            <th>interested</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($vendorsArray as $vendor)

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

              @if (@isset($vendor->description))
                <td>{{$vendor->description }}</td>
              @endif
                <td>{{$vendor->visit_website_url }}</td>
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
    </div>

  @endsection
