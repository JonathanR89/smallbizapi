@extends('beautymail::templates.widgets')

@section('content')
  {{-- <h2>CRM Consulting Enquiry</h2> --}}
  <img src="http://smallbizcrm.com/qq2/clear1.png" align="center" width="400" height="88" alt="SmallBizCRM" border="0"  />
  <h2 align="center">CRM Consulting Enquiry</h2>

  {{-- <img src="http://smallbizcrm.com/qq2/clear1.png" height="200" alt="SmallBizCRM" border="0"  /> --}}

  <p>
    This person has visited SmallBizCRM.com and filled out our CRM Consulting Basic Needs
    Analysis Questionnaire. They have expressed interest in your services, as it came
    up as a match to their requirements (see below). Please follow up with them
    soonest. Thank you and good luck!
  </p>
  <p>
    [We'd love any feedback you care to share, be it about the quality of this questionnaire, the lead, the service etc.
    Any suggestions you propose will certainly be seriously considered and, if you approve included, with your accreditation, in our forthcoming contributor page.]
  </p>
@foreach ($categories as $category)
  @include('beautymail::templates.widgets.articleStart')
  <h3>{{ $category->name }}</h3>
    @foreach ($questions as $question)
        @if ($question['category_id'] == $category->id)
          @if ($question['model'] == true)
            @include('beautymail::templates.widgets.newfeatureStart')
            <p>{{ $question['question'] }}</p>
            @include('beautymail::templates.widgets.newfeatureEnd')
          @endif
        @endif
    @endforeach
    @include('beautymail::templates.widgets.articleEnd')
@endforeach


@stop
