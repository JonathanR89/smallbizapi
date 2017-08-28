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
                        <a href="{{ url('consultant-questionnaire/'.$category->id) }}">
                          {{$category->name}}
                        </a>
                        <a href="{{ route('consultant-questionnaire.destroy', ['id' => $category->id]) }}"   class="btn btn-danger pull-right">Delete</a>
                        <a href="{{ route('consultant-questionnaire.edit', ['id' => $category->id]) }}" style="margin-right:20px;" class="btn btn-primary pull-right">Edit</a>
                        <a href="{{  url('consultant-questionnaire/'.$category->id)}}"  style="margin-right:20px;" class="btn btn-primary pull-right">Add Questions</a>
                      </div>
                      <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
