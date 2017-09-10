@extends('beautymail::templates.widgets')

@section('content')
  <div align="center" >
  <h2 align="center">CRM Consulting Enquiry</h2>
</div>
  <p style="font-size: 20px">
    This person has visited SmallBizCRM.com and filled out our CRM Consulting Basic Needs
    Analysis Questionnaire. They have expressed interest in your services, as it came
    up as a match to their requirements (see below). Please follow up with them
    soonest. Thank you and good luck!
  </p>
  <p style="font-size: 20px">
    [We'd love any feedback you care to share, be it about the quality of this questionnaire, the lead, the service etc.
    Any suggestions you propose will certainly be seriously considered and, if you approve included, with your accreditation, in our forthcoming contributor page.]
  </p>
    @foreach ($categories as $category)
      @include('beautymail::templates.widgets.articleStart')
      <h2>{{ $category->name }}</h2>
        @foreach ($questions as $question)
            @if ($question['category_id'] == $category->id)
              @if ($question['model'] == true)
                @include('beautymail::templates.widgets.newfeatureStart')
                <p style="font-size: 15px">{{ $question['question'] }}</p>
                @include('beautymail::templates.widgets.newfeatureEnd')
              @endif
            @endif
        @endforeach
        @include('beautymail::templates.widgets.articleEnd')
    @endforeach


@stop
