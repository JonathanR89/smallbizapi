@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="col-md-8 col-md-offset-2 table-responsive">

          <div class="panel-heading">
            <div class="alert alert-info">

            <h3>
              <a class="btn btn-primary pull-right" href="{{ url('/all-vendors') }}">Back</a>
              create new vendor
            </h3>

          </div>
          </div>
          <div class="panel-body">

          {!! Form::open(['method' => 'POST', 'route' => 'save_vendor', 'enctype' => "multipart/form-data", 'class' => 'form-group']) !!}

              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  {!! Form::label('name', 'name') !!}
                  {!! Form::text('name', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('name') }}</small>
              </div>

              <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                  {!! Form::label('description', 'description') !!}
                  {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('description') }}</small>
              </div>

              <div class="form-group{{ $errors->has('visit_website_url') ? ' has-error' : '' }}">
                  {!! Form::label('visit_website_url', 'visit_website_url') !!}
                  {!! Form::text('visit_website_url', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('visit_website_url') }}</small>
              </div>

              {{-- <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                  {!! Form::label('price', 'price') !!}
                  {!! Form::text('price', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('price') }}</small>
              </div> --}}

              <div class="form-group{{ $errors->has('price_id') ? ' has-error' : '' }}">
                  {!! Form::label('price_id', 'price_id') !!}
                  {!! Form::select('price_id', $prices, '', ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('price_id') }}</small>
              </div>

              {{-- <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                  {!! Form::label('country', 'country') !!}
                  {!! Form::text('country', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('country') }}</small>
              </div>

              <div class="form-group{{ $errors->has('town') ? ' has-error' : '' }}">
                  {!! Form::label('town', 'town') !!}
                  {!! Form::text('town', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('town') }}</small>
              </div> --}}

              {{-- <div class="form-group{{ $errors->has('town') ? ' has-error' : '' }}">
                  {!! Form::label('town', 'town') !!}
                  {!! Form::select('town', , "", ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('town') }}</small>
              </div> --}}

              {{-- <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                  {!! Form::label('pricing_pm', 'description') !!}
                  {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('description') }}</small>
              </div> --}}

              <div class="form-group{{ $errors->has('industry suitable for') ? ' has-error' : '' }}">
                  {!! Form::label('industry_id', 'industry') !!}
                  {!! Form::select('industry_id', $industries, '', ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('industry_id') }}</small>
              </div>

              <div class="form-group{{ $errors->has('speciality') ? ' has-error' : '' }}">
                  {!! Form::label('speciality', 'speciality') !!}
                  {!! Form::textarea('speciality', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('speciality') }}</small>
              </div>

              {{-- <div class="form-group{{ $errors->has('target_market') ? ' has-error' : '' }}">
                  {!! Form::label('target_market', 'target_market') !!}
                  {!! Form::textarea('target_market', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('target_market') }}</small>
              </div> --}}

              <div class="form-group{{ $errors->has('vendor_email') ? ' has-error' : '' }}">
                  {!! Form::label('vendor_email', 'vendor_email') !!}
                  {!! Form::textarea('vendor_email', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('vendor_email') }}</small>
              </div>

              <div class="form-group">
                <div class="alert alert-info">
                  <h3>Multiple emails can be added, but must be separated by comma</h3>
                </div>
              </div>
              <div class="form-group{{ $errors->has('test_email') ? ' has-error' : '' }}">
                  {!! Form::label('test_email', 'test_email') !!}
                  {!! Form::textarea('test_email', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('test_email') }}</small>
              </div>
              <div class="form-group{{ $errors->has('email_interested') ? ' has-error' : '' }}">
                  {!! Form::label('email_interested', 'email_interested') !!}
                  {!! Form::textarea('email_interested', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('email_interested') }}</small>
              </div>
              {{-- <div class="form-group{{ $errors->has('vertical') ? ' has-error' : '' }}">
                  {!! Form::label('vertical', 'vertical') !!}
                  {!! Form::text('vertical', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('vertical') }}</small>
              </div> --}}
              <div class="form-group{{ $errors->has('has_trial_period') ? ' has-error' : '' }}">
                  {!! Form::label('has_trial_period', 'has_trial_period') !!}
                  {!! Form::select('has_trial_period', ['yes', 'no'], '', ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('has_trial_period') }}</small>
              </div>

              {{-- <div class="form-group{{ $errors->has('vendor_profile_image') ? ' has-error' : '' }}">
                {!! Form::label('vendor_profile_image', 'File label') !!}
                {!! Form::file('file', ['required' => 'required']) !!}
                <p class="help-block">Help block text</p>
                <small class="text-danger">{{ $errors->first('vendor_profile_image') }}</small>
              </div> --}}

              <div class="form-group{{ $errors->has('profilePic') ? ' has-error' : '' }}">
                  {!! Form::label('profilePic', 'File label', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                          {{ Form::file('profilePic', ['required' => 'required']) }}
                          <p class="help-block">Help block text</p>
                          <small class="text-danger">{{ $errors->first('profilePic') }}</small>
                      </div>
              </div>

              <div class="btn-group pull-right">
                  {{-- {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!} --}}
                  {!! Form::submit("create", ['class' => 'btn btn-success']) !!}
              </div>
          {!! Form::close() !!}

        </div>
        </div>

      </div>



      {{-- name
      description
      created
      modified
      visit_website_url
      price
      price_id
      country
      town
      pricing_pm
      industry_suitable_for
      speciality
      target_market
      vendor_email
      test_email
      email_interested
      vertical
      has_trial_period --}}
@endsection
