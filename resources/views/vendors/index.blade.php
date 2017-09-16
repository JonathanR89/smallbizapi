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
                  <form class="form-group" action="{{ route('search_vendors') }}" method="post">
                    <input class="form-control" type="text" name="search_term">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-default" name="button">Search</button>
                  </form>
                  <table style="overflow: auto; table-layout:fixed" class="table table-hover responsive">
                    <thead>
                      <tr>
                        <th></th>
                        <th>CRM</th>
                        <th>is_available</th>
                        <th>interested</th>
                        <th>edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($vendorsArray as $vendor)

                        <tr>
                          <td style="margin: 10px;" >
                              @if (isset($vendor->image_id))
                                <img src="{{ $vendor->image()->first()->original_filedir }}" height="90" width="90"  class="img thumbnail" alt="">
                              @else
                                <img src="{{ url('uploads/images/clear1.png')}}" height="90" width="90"  class="img thumbnail" alt="">
                              @endif
                            {{-- @isset($vendor->image_id)
                            @endisset --}}
                        </td>
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
                            <a class="btn btn-success" href="{{ url('vendor/'.$vendor->id.'/show') }}">Edit</a>
                          </td>

                          <td>
                            <a class="btn btn-danger" href="{{ url('vendor/'.$vendor->id.'/destroy') }}">Delete</a>
                          </td>

                        </tr>
                      @endforeach
                      {{-- {{ $vendorsArray }} --}}

                    </tbody>
                  </table>
                  <div align="center">

                    {{ $vendorsArray->links() }}
                  </div>

                </div>
              </div>
            </div>
@endsection
