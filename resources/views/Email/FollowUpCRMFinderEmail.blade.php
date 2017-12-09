@extends('beautymail::templates.ark')

@section('content')

  @include('beautymail::templates.ark.contentStart')
  {{-- <div align="center" >
    <img src="http://smallbizcrm.com/qq2/clear1.png" align="center" width="400" height="88" alt="SmallBizCRM" border="0"  />
  </div> --}}
  @include('beautymail::templates.ark.contentEnd')

    @include('beautymail::templates.ark.heading', [
		'heading' => 'CRM Finder Enquiry',
		'level' => 'h1'
	])

    @include('beautymail::templates.ark.contentStart')
    <div align="left">
    <img src="https://www.smallbizcrm.com/wp-content/uploads/2015/06/SBCRM-Logo-final-blue-green-300X66.png"  width="300" height="66" />
  </div>
    <p>
      <strong>
        Dear {{ $name }},
      </strong>
      <br> <br>
    </p>

    <p>
      Thank you for taking the time to visit SmallBizCRM.com and complete our new CRM  Finder Questionnaire.
      Did it help you get closer to selecting a suitable CRM for your business?
    </p>
    <p>
      Any feedback you'd be prepared to share to help us refine our CRM  Finder tool would be much appreciated.
      Based on the answers you provided,<a href="{{ env('FRONTEND_URL').'/#/results?submissionID='.$submission_id }}"> here is the link again to your suggested CRM's: https://finder.smallbizcrm.com/results</a>
    </p>
    <p>
      If you still need more advice or assistance with your CRM Finder quest, please don't hesitate to give me a shout. You can simply reply to this email.
      Thanks again for your time.
    </p>
    <p>
      Best wishes
    </p>

    @include('beautymail::templates.ark.contentEnd')

    @include('beautymail::templates.ark.heading', [
      'heading' => 'Perry Norgarb',
      'level' => 'h2'
    ])

    @include('beautymail::templates.ark.contentStart')``

        <h4 class="secondary"><strong>SmallBizCRM</strong></h4>
        {{-- <p>This is another test</p> --}}
        <p align="left">
          Regards<br />
          Perry Norgarb<a value="+27217830350"></a>
          <br />
          <a href="http://t.sidekickopen14.com/e1t/c/5/f18dQhb0S7lC8dDMPbW2n0x6l2B9nMJW7t5XX48q5y9nW64zw5R3MqcVCW4X9Hq256dM0Wdmg-0W02?t=http%3A%2F%2Fwww.smallbizcrm.com%2F&amp;si=4744451886940160&amp;pi=40933b86-3b8f-420f-86a4-2337f3e7e797" value="+27217830350" target="_blank">
            <img src="https://ci3.googleusercontent.com/proxy/b_CKXY03lpen7nAZ4iGjszaHp_fMakXBrvEVIQ7PQrNJuRUwIcUbE_ioWMea0gOPy6x_AH6Rkw9TwzDW_ZeHPQh-Zvgl4IDCwbFyln6b-ejKmqpDsBRguXFBDsobJQ0rLXkvsW24_Q=s0-d-e1-ft#http://www.smallbizcrm.com/wp-content/uploads/2014/11/SmallBizCRM-Logo-200X44.png" alt="SmallBizCRM.com" height="42" width="200" /></a>
            <br />
          </p>
          <div align="center" style="display: flex; justify-content: center;">
            <a style="margin: 10px;" href="http://t.sidekickopen14.com/e1t/c/5/f18dQhb0S7lC8dDMPbW2n0x6l2B9nMJW7t5XX48q5y9nW64zw5R3MqcVCW4X9Hq256dM0Wdmg-0W02?t=http%3A%2F%2Fwww.facebook.com%2Fpages%2FSmallBizCRMcom%2F204289630712&amp;si=4744451886940160&amp;pi=40933b86-3b8f-420f-86a4-2337f3e7e797" target="_blank">
              <img alt="http://www.smallbizcrm.com/wp-content/uploads/2014/11/facebook-button.png" src="https://ci5.googleusercontent.com/proxy/C1VNIgLyLnIm26Q2urTY1IpvyiXd3PzXH16jv4OrRJC5ocGZzOfZR7C8htUQvL0YbJO37m3CIQCDiku2ZYCjob9OZPY3coBGT-jakwPHagxsC-CrSrKmCag_A7d2h2I=s0-d-e1-ft#http://www.smallbizcrm.com/wp-content/uploads/2014/11/facebook-button.png" /></a>

              <a style="margin: 10px;" href="http://t.sidekickopen14.com/e1t/c/5/f18dQhb0S7lC8dDMPbW2n0x6l2B9nMJW7t5XX48q5y9nW64zw5R3MqcVCW4X9Hq256dM0Wdmg-0W02?t=http%3A%2F%2Ftwitter.com%2FSmallBizCRM&amp;si=4744451886940160&amp;pi=40933b86-3b8f-420f-86a4-2337f3e7e797" target="_blank">
                <img alt="http://www.smallbizcrm.com/images/twitter_button.png" src="https://ci3.googleusercontent.com/proxy/u8lXrm9WR57HyVoFODtCQG1nSf8Z3hyYAKgPitEV6gDrvrQqmYpAmtKwiDK2duJNsifJtDgDm1JJ5HibN6qpre9Gao2U65NFI_3yKAOfY4s965kz6k0dBkdN1HbubQ=s0-d-e1-ft#http://www.smallbizcrm.com/wp-content/uploads/2014/11/twitter_button.png" /></a>

                <a style="margin: 10px;" href="http://t.sidekickopen14.com/e1t/c/5/f18dQhb0S7lC8dDMPbW2n0x6l2B9nMJW7t5XX48q5y9nW64zw5R3MqcVCW4X9Hq256dM0Wdmg-0W02?t=http%3A%2F%2Fza.linkedin.com%2Fin%2Fperrynorgarb&amp;si=4744451886940160&amp;pi=40933b86-3b8f-420f-86a4-2337f3e7e797" target="_blank">
                  <img alt="http://www.smallbizcrm.com/images/LinkedIn-button.png" src="https://ci6.googleusercontent.com/proxy/Gnd97ZkXm9dT1gUfVJ82bVjSSQ1glEUvfblmnUb4_ihfoZL-8UUDE9yrTTC9sy-wZmCfc7Ul3mX9yIu9qRPm2PzCzvtAcbXnuIIVFRMLkDS0Wrac8k9NZeCNor1rvrA=s0-d-e1-ft#http://www.smallbizcrm.com/wp-content/uploads/2014/11/LinkedIn-button.png" /></a>

                  <a style="margin: 10px;" href="http://t.sidekickopen14.com/e1t/c/5/f18dQhb0S7lC8dDMPbW2n0x6l2B9nMJW7t5XX48q5y9nW64zw5R3MqcVCW4X9Hq256dM0Wdmg-0W02?t=https%3A%2F%2Fplus.google.com%2Fu%2F0%2F106977010846902187739&amp;si=4744451886940160&amp;pi=40933b86-3b8f-420f-86a4-2337f3e7e797" target="_blank">
                    <img alt="http://www.smallbizcrm.com/images/google-button.jpg" src="https://ci4.googleusercontent.com/proxy/EkfGkMIv0GPZaKRoLwQVsgaKEDZV587sBnP45B12KIPPZO3HDyV7D6b4gFLWIuRFXXTAvDlO5Y1L8gun-cZnvHDZJT6ZsHUnvSF4JnRZvttKLyV0gqdJrTcjNrti=s0-d-e1-ft#http://www.smallbizcrm.com/wp-content/uploads/2014/11/google-button.jpg" /></a>

                    Chat <img style="margin: 10px;" alt="Skype/" src="https://ci6.googleusercontent.com/proxy/zmB-06p8hXXvVAfUdcPIU7iF5Sy8WvV6BeNmm1Jx7fY9mcwhkpAGKV9sdYUo5YjCqfDmIucbcEebwDk=s0-d-e1-ft#http://images.wisestamp.com/skype.png" border="0" />searchmarketeers
                  </div>
                </div>

    @include('beautymail::templates.ark.contentEnd')

@stop
