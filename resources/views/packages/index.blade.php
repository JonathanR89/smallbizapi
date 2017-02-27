
<?php ini_set('max_execution_time', 10000);?>
@extends('layouts.app')

@section('content')
<h1>Packages</h1>
<p class="lead">Packages</p>
<hr>
<table id="packages" class="table table-hover" >
    <thead>
    	<tr>
    		<th>Metrics</th>
        {{-- @php
        dd($packages);
        @endphp --}}
        	@foreach($packages as $package)
        		<th>
              <form class="form-control" method="post">
                <input type="checkbox" data-package_id="{{ $package->id }}" id="packageAvailability" value="1" >
              </form>
              {{ $package->name}}</th>
        	@endforeach
        </tr>
    </thead>
    <tbody>
    	@foreach($metrics as $metric)
    		<tr>
    			<td><b>{{ $metric->name }}</b></td>
    			@foreach($packages as $package)
    				<?php $score = $packageMetrics->where('metric_id', $metric->id)->where('package_id', $package->id)->first()?>
    				<td>

                        <!--
                            Devin:
                            So here is the permission piece.
                            Edit the hasAccessTo() method on the User model to your taste.
                        -->

                            <!--
                                Devin:
                                Here we build the input.
                                I put down the metric and package down to use in the ajax call
                            -->
                            <form method="post">
                                {{ csrf_field() }}
                                <input
                                type="text"
                                class="form-control packageInput"
                                value="{{ $score ? $score->score : 0 }}"
                                data-package_id="{{ $package->id }}"
                                data-metric_id="{{ $metric->id }}"
                            />
                            </form>

                            <!--
                                Devin:
                                If the person does not have permission simply display the current score
                            -->
                    </td>
            	@endforeach
        	</tr>
    	@endforeach
    </tbody>
</table>

<script type="text/javascript">

    /**
     * Devin:
     * Here is the ajax when someone blurs (exits) a input
     */
     $.ajaxSetup({
         headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
        });
    $(document).on("blur", ".packageInput", function () {

        var valueInput = $(this);
        // Disable the input while saving
        valueInput.prop("disabled", true);

        $.post('/update_package_score', {
            _token:   {{ csrf_token() }}
            metric_id: valueInput.data("metric_id"),
            package_id: valueInput.data("package_id"),
            score: valueInput.val()

        }, function (response){
            // Re-Enable the input after saving
            valueInput.prop("disabled", false);

            if(response.success) {
                // Do what you need if successful
            } else {
                // Do what you need if unsuccessful
            }
        });
    });

    $(document).on("click", ".packageAvailability", function () {

        var valueInput = $(this);
        // Disable the input while saving
        valueInput.prop("disabled", true);

        $.post('/update_package_availability', {
            _token:   {{ csrf_token() }},

            package_id: valueInput.data("package_id"),
            // score: valueInput.val()

        }, function (response){
            // Re-Enable the input after saving
            valueInput.prop("disabled", false);

            if(response.success) {
                // Do what you need if successful
            } else {
                // Do what you need if unsuccessful
            }
        });
    });



</script>

@endsection
