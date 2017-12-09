@extends('layouts.app') @section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>
				SmallBizCRM Admin Overview
			</h3>
			
		</div>
		<div class="panel-body">
			<div class="row">

				<div class="panel panel-default">

					<div class="panel-body">
						{{--
						<center> --}} {!! $submissionHistoryGraph->html() !!} {{-- </center> --}}

					</div>
				</div>


				<div class="col-md-12">
					<div class="row">

						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<br>
								</div>

								<div class="panel-body">

									<center>
										{!! $weeklySubmissionsGraph->html() !!}
									</center>


								</div>
							</div>
						</div>
						<div class="col-md-6">

							<div class="panel panel-default">
								<div class="panel-heading">
									<br>
								</div>
								<div class="panel-body">
									<center>
										{!! $vendorRefferalGraph->html() !!}
									</center>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading"></div>
						<div class="panel-body">
							<center>
								{!! $vendorRefferalVSSubmissionRatioGraph->html() !!}
							</center>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading"></div>
						<div class="panel-body">
							<center>
								{!! $vendorRefferalDailyGraph->html() !!}
							</center>
						</div>
					</div>
				</div>



				{{-- </div> --}}
		</div>
	</div>
</div>
{!! Charts::scripts() !!} {!! $weeklySubmissionsGraph->script() !!} {!! $vendorRefferalGraph->script() !!} {!! $submissionHistoryGraph->script()
!!} {!! $vendorRefferalVSSubmissionRatioGraph->script() !!} {!! $vendorRefferalDailyGraph->script() !!} @endsection