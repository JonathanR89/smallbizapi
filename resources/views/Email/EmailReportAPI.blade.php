
<h2>hi</h2>

<h3>Lasts Week{{ count($data['submissionsLastWeek']) }}</h3>
<h3>submissionsLastMonth{{ count($data['submissionsLastMonth']) }}</h3>
<br><br><br>
@php
var_export($data);
//
@endphp
