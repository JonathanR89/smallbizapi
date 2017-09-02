@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="col-md-8 col-md-offset-2 table-responsive">
          {{-- @php
            dd($vendor);
          @endphp --}}
          <div class="panel-heading">
            <h3>
              <a class="btn btn-primary pull-right" href="{{ url('/all-vendors') }}">Back</a>
            Edit
            </h3>
          </div>

          <div class="panel-body">

          {!! Form::open(['method' => 'PUT', 'url' => "vendor/update/$vendor->id", 'class' => 'form-group']) !!}

              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  {!! Form::label('name', 'name') !!}
                  {!! Form::text('name', $vendor->name, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('name') }}</small>
              </div>

              <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                  {!! Form::label('description', 'description') !!}
                  {!! Form::textarea('description', $vendor->description, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('description') }}</small>
              </div>

              <div class="form-group{{ $errors->has('visit_website_url') ? ' has-error' : '' }}">
                  {!! Form::label('visit_website_url', 'visit_website_url') !!}
                  {!! Form::text('visit_website_url', $vendor->visit_website_url , ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('visit_website_url') }}</small>
              </div>

              <div class="form-group{{ $errors->has('price_id') ? ' has-error' : '' }}">
                  {!! Form::label('price_id', 'price_id') !!}
                  {!! Form::select('price_id', $prices, $vendor->price_id, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('price_id') }}</small>
              </div>

              {{-- <div class="form-group{{ $errors->has('price_id') ? ' has-error' : '' }}">
                  {!! Form::label('price_id', 'price_id') !!}
                  {!! Form::text('price_id', $vendor->visit_website_url, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('price_id') }}</small>
              </div> --}}

              {{-- <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                  {!! Form::label('country', 'country') !!}
                  {!! Form::text('country', $vendor->country, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('country') }}</small>
              </div>

              <div class="form-group{{ $errors->has('town') ? ' has-error' : '' }}">
                  {!! Form::label('town', 'town') !!}
                  {!! Form::text('town', $vendor->town, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('town') }}</small>
              </div> --}}

              {{-- <div class="form-group{{ $errors->has('town') ? ' has-error' : '' }}">
                  {!! Form::label('town', 'town') !!}
                  {!! Form::select('town', , "", ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('town') }}</small>
              </div> --}}

              <div class="form-group{{ $errors->has('pricing_pm') ? ' has-error' : '' }}">
                  {!! Form::label('pricing_pm', 'pricing_pm') !!}
                  {!! Form::textarea('pricing_pm', $vendor->pricing_pm, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('description') }}</small>
              </div>

              <div class="form-group{{ $errors->has('industry suitable for') ? ' has-error' : '' }}">
                  {!! Form::label('industry_suitable_for', 'industry_suitable_for') !!}
                  {!! Form::textarea('industry_suitable_for', $vendor->industry_suitable_for, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('industry_suitable_for') }}</small>
              </div>

              <div class="form-group{{ $errors->has('speciality') ? ' has-error' : '' }}">
                  {!! Form::label('speciality', 'speciality') !!}
                  {!! Form::textarea('speciality', $vendor->speciality, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('speciality') }}</small>
              </div>

              {{-- <div class="form-group{{ $errors->has('target_market') ? ' has-error' : '' }}">
                  {!! Form::label('target_market', 'target_market') !!}
                  {!! Form::textarea('target_market', $vendor->target_market, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('target_market') }}</small>
              </div> --}}

              <div class="form-group{{ $errors->has('vendor_email') ? ' has-error' : '' }}">
                  {!! Form::label('vendor_email', 'vendor_email') !!}
                  {!! Form::textarea('vendor_email', $vendor->vendor_email, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('vendor_email') }}</small>
              </div>
              <div class="form-group{{ $errors->has('test_email') ? ' has-error' : '' }}">
                  {!! Form::label('test_email', 'test_email') !!}
                  {!! Form::textarea('test_email', $vendor->test_email, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('test_email') }}</small>
              </div>
              <div class="form-group{{ $errors->has('email_interested') ? ' has-error' : '' }}">
                  {!! Form::label('email_interested', 'email_interested') !!}
                  {!! Form::textarea('email_interested', $vendor->email_interested, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('email_interested') }}</small>
              </div>
              <div class="form-group{{ $errors->has('vertical') ? ' has-error' : '' }}">
                  {!! Form::label('vertical', 'vertical') !!}
                  {!! Form::textarea('vertical', $vendor->vertical, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('vertical') }}</small>
              </div>
              <div class="form-group{{ $errors->has('has_trial_period') ? ' has-error' : '' }}">
                  {!! Form::label('has_trial_period', 'has_trial_period') !!}
                  {!! Form::textarea('has_trial_period', $vendor->has_trial_period, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('has_trial_period') }}</small>
              </div>

              <div class="btn-group pull-right">
                  {{-- {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!} --}}
                  {!! Form::submit("Edit", ['class' => 'btn btn-success']) !!}
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
