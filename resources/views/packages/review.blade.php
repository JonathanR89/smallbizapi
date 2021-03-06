
<?php ini_set('max_execution_time', 10000);?>
@extends('layouts.app')

@section('content')
  <style media="screen">
    .pagination-links {
      text-align: right;
    }
    .header {
      text-align: center;
    }
  </style>
  <div class="container">
<h1>Packages Displaying the "Read Review"</h1>
<hr>
<div align="right" class="pagination-links">
  {{ $packages->links() }}
</div>
<form class="form-group" action="{{ route('package_search_review') }}" method="post">
    <input class="form-control" type="text" name="search_term">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" class="btn btn-default" name="button">Search</button>
</form>
<div class="header">
  <h4>The checked checkboxes display "Read Review" packages</h4>

</div>

<table id="packages" class="table table-hover" >
    <thead>
    	<tr>
    		<th>Metrics</th>
        	@foreach($packages as $package)
        		<th>
              {{ $package->name}}
              <form  method="post">
                <input
                class="form-control packageReview"
                 type="checkbox"  data-package_id="{{ $package->id }}"
                  {{-- is available is = 0 --}}
                 @if ($package->toggle_review_button == 1)
                   {{ "checked" }}
                 @endif
                 title="Is a displayed package">
              </form>
            </th>
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
                    </td>
            	@endforeach
        	</tr>
    	@endforeach
    </tbody>
</table>

{{ $packages->links() }}

</div>
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

        $.post("{{route('update_package_score')}}", {
            _token:   "{{ csrf_token() }}",
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

    $(".packageInput").click(function(){
    alert("The paragraph was clicked.");
});

$(document).on("click", ".packageReview", function () {

        var valueInput = $(this);
        // Disable the input while saving
        // valueInput.prop("disabled", true);

        $.post("{{route('update_toggle_review')}}", {
            _token:  " {{ csrf_token() }}",

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
