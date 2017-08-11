@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Categories
                  <a href="{{ url('/consultant-questionnaire/create') }}" class="btn btn-success pull-right" >Add Category</a>
                </div>
                <div class="panel-body">
                    @foreach ($categories as $category)
                      <div class="card">
                        <a href="{{ url('consultant/category/'.$category->id) }}">
                          {{$category->name}}
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
