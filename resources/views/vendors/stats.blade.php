@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="col-md-8 col-md-offset-2 table-responsive">

          <div class="panel-heading">
            <h2>Vendors without data</h2>
          </div>

          <div class="panel-body">
            <div class="row">
            @foreach ($info as $key => $vendors)

              {{-- <a href="{{ route('show_vendor_incomplete', [$vendor['id']])}}"></a> --}}
                <div class="col-md-4">
                  <div class="alert alert-{{ collect(['danger', 'success', 'warning'])->random() }}">
                    <strong>{{ $key }}</strong> Missing: {{ $vendors->count() }}
                    
                      @foreach ($vendors as $vendor)
                        <a href="{{ url('vendor/'.$vendor->id.'/show') }}">
                        {{ $vendor->name }} <br>
                      </a>
                      @endforeach
                      
                  </div>
                </div>
              {{-- @php
                dd($key);
              @endphp --}}

            @endforeach
              {{-- <a href="{{ route('show_vendor_incomplete', [$vendor['id']])}}"></a> --}}
                <div class="col-md-4" @section('name')

                @show>
                  <div sss class="panel-collapse">

                  <div id="demo"  class="alert  alert-{{ collect(['danger', 'success', 'warning'])->random() }}">
                    <a data-toggle="collapse" href="#collapse">
                      <strong>Missing Images</strong> Missing: {{ collect($infoimage)->count() }}
                    </a>

                    <div id="collapse" class="panel-collapse collapse">
                      @foreach ($infoimage as $vendor)
                          <a href="{{ url('vendor/'.$vendor->id.'/show') }}">
                            {{ $vendor->name }} <br>
                          </a>

                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="">

            </div>
        </div>
        </div>

      </div>


@endsection
