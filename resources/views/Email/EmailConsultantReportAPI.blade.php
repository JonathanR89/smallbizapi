
<h2>CRM Consulting Enquiry</h2>
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
  <h3>{{ $category->name }}</h3>
    @foreach ($questions as $question)
        @if ($question['category_id'] == $category->id)
          @if ($question['model'] == true)
            <pre>{{ $question['question'] }}</pre>
          @endif
        @endif
    @endforeach
@endforeach
