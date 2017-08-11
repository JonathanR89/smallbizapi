@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Consultants
                  <a href="{{ route('add_consultant') }}" class="btn btn-success pull-right" >Add Consultant</a>
                </div>
                <div class="panel-body">
                    {{ $consultants }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
