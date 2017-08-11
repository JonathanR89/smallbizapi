@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Consultants
                  {{-- <a href="{{ route('add_consultant_questionnaire_question') }}" class="btn btn-success pull-right" >add_consultant_questionnaire_question</a> --}}
                </div>
                <div class="panel-body">
                  <h2>
                    {{ $category->name }}
                  </h2>
                  <div class="card">
                      <h3>Add Question</h3>
                      {!! Form::open(['method' => 'POST', 'route' => 'routeName', 'class' => 'form-horizontal']) !!}

                          boottext

                          <div class="btn-group pull-right">
                              {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                              {!! Form::submit("Add", ['class' => 'btn btn-success']) !!}
                          </div>
                      {!! Form::close() !!}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
