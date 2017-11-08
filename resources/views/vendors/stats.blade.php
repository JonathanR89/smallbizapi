@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="col-md-8 col-md-offset-2 table-responsive">

          <div class="panel-heading">

          </div>

          <div class="panel-body">
            <div class="row">
            @foreach ($info as $key => $count)
                <div class="col-md-4">
                  <div class="alert alert-{{ collect(['danger', 'success', 'warning'])->random() }}">
                    <strong>{{ $key }}</strong> Missing: {{ $count }}
                  </div>
                </div>
              {{-- @php
                dd($key);
              @endphp --}}

            @endforeach
          </div>
            <div class="">

            </div>
        </div>
        </div>

      </div>


@endsection
