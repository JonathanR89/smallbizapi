@extends('beautymail::templates.ark')

@section('content')

  @include('beautymail::templates.ark.contentStart')
  <div align="center" >
    <img src="http://smallbizcrm.com/qq2/clear1.png" align="center" width="400" height="88" alt="SmallBizCRM" border="0"  />
  </div>
  @include('beautymail::templates.ark.contentEnd')

    @include('beautymail::templates.ark.heading', [
		'heading' => 'CRM Consulting Enquiry',
		'level' => 'h1'
	])

    @include('beautymail::templates.ark.contentStart')

        {{-- <h4 class="secondary"><strong>Hello World</strong></h4>
        <p>This is a test</p> --}}

        <p>
          <strong>
            Dear Devin,
          </strong>
          <br>

          Thank you for taking the time to visit SmallBizCRM.com and complete our new CRM Finder Needs Analysis questionnaire.
          Did it help you get closer to selecting a suitable CRM for your business? Any feedback you'd be prepared to share to help us refine our CRM Finder tool would be much appreciated.
          Based on the answers you provided, here is the link again to your suggested CRM's: http://smallbizcrm.com/qq2/results.php?key=3ba6f70087cc7cebf55e6a71eb36c4cb

          If you still need more advice or assistance with your CRM quest, please don't hesitate to give me a shout. You can simply reply to this email.
          Thanks again for your time.

          Best wishes</p>

    @include('beautymail::templates.ark.contentEnd')

    @include('beautymail::templates.ark.heading', [
		'heading' => 'Another headline',
		'level' => 'h2'
	])

    @include('beautymail::templates.ark.contentStart')

        <h4 class="secondary"><strong>Hello World again</strong></h4>
        <p>This is another test</p>

    @include('beautymail::templates.ark.contentEnd')

@stop
