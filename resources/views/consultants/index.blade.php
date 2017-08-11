@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Consultants
                  <a href="{{ route('add_consultant') }}" class="btn btn-success pull-right" >Add Consultant</a>
                  <a href="{{ route('consultant_questionnaire') }}" class="btn btn-success pull-right" >Consultant Questionnaire Questions</a>
                </div>
                <div class="panel-body">
                    @foreach ($consultants as $consultant)
                      <div class="card">
                        <a href="{{ url('consultant/'.$consultant->id) }}">
                          {{$consultant->name}}
                        </a>
                      </div>
                      <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
