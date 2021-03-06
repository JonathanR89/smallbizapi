<div class="container" >
  <div class="row">
    <div class="col-md-6">
  <div align="left">
    <img src="http://www.smallbizcrm.com/wp-content/uploads/2015/06/SBCRM-Logo-final-blue-green-300X66.png" alt="SmallBizCRM.com" width="300" height="66" />
  </div>
  <p >Thank you for using our SmallBizCRM Finder to help you short-list CRM's for your business.</p>
  <p >Below are the CRM's that score highest based on the answers you have provided and our assessment of the CRM's.</p>
  <p >Scores are there to indicate relative strength between CRM's on the short-list. Conduct your own evaluation to verify the extent to which your specific requirements are met by each CRM you evaluate.</p>
  <p >If you'd like to give us feedback or would like further assistance feel free to <a href="http://www.smallbizcrm.com/contact-details/" target="_blank">contact us.</a></p>
  <p ><strong>Please Note: If any suggestions below register 0% or a &#10003;, this is because while the CRM might not match all your answers provided, it is designed specifically for your industry and might also be worth your consideration! Also please note that the top Nearest Match will always show as 100%.</strong></p>


  <table class="table" >
    <thead>
      <tr>
        <th></th>
        <th><h3 >Package</h3></th>
        <th><h3 >Description</h3></th>
        <th><h3 >Score</h3></th>
        <th><h3 >Link</h3></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($results as $row)
        <tr>
        @php
        $entry = null;
        foreach ($vendors as $record) {
          if ($record->name == $row['name']) {
            $entry = $record;
            // $
            break;
          }
        }
        @endphp

          <td >
            @if ($entry)
              @if (isset($entry->image_id))
                @php
                $image = \App\ImageUpload::find($entry->image_id);
                $imagePath = $image->original_filedir;
                @endphp
                <img src="{{ asset($imagePath) }}"  width="64" />
              @endif
            @endif
          </td>
          <td  ><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'utf-8') ?></td>
          <td  >
            @if ($entry)

              {!! $entry->description !!}

            @endif
          </td>
          <td  >
            @php

            $score = \App\UserResult::where([
              "submission_id" => $submission_id,
              "user_id" => $user_id,
              "package_id" => $entry->id,
              ])->get();
              @endphp
              @if (isset( $score[0]))
                @if ($score[0]->score <= 0)
                  &#10003;
                @else
                  {{ round($score[0]->score / $max * 100) }} %
                @endif
              @endif
            </td>
            <td >
              @if ($entry)
                @if (isset($entry->visit_website_url))

                  <a href="{{ $entry->visit_website_url }}"
                    style="margin: 5px;"
                    class="btn btn-primary"
                    >Visit website</a>
                @endif
              @endif

                @if ($entry)
                  @if (env('APP_ENV') == 'local')
                    @php
                      $remote_address = "http://10.0.0.17:8000";
                    @endphp
                  @else
                    @php
                      $remote_address = "https://api.smallbizcrm.com"
                    @endphp
                  @endif
                  @if ($row['interested'] == 1)

                    <a href="{{$remote_address.'/api/vendor?submissionID='.$submission_id.'&user_id='.$user_id.'&packageID='.$entry->id }}"
                      class="btn btn-warning"
                        style="color:#222222; margin: 5px; background-color:#FF0;" type="submit" name="button"> I'm Interested</a>
                  @endif
                @endif

                @if ($entry)
                  @if (env('APP_ENV') == 'local')
                    @php
                      $remote_address = "http://10.0.0.17:8000";
                    @endphp
                  @else
                    @php
                      $remote_address = "https://api.smallbizcrm.com"
                    @endphp
                  @endif
                  @if ($row['toggle_review_button'] == 1)
                    <a href="{{$remote_address.'/api/readreview?submissionID='.$submission_id.'&user_id='.$user_id.'&packageID='.$entry->id }}" class="btn btn-default"
                      style="margin: 5px; border-color:#2e6da4" type="submit" name="button"> Read Review</a>
                  @endif
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>





    <table class="table">
      <tr>
        <th scope="col">&nbsp;</th>
      </tr>
    </table>


<p align="left">
  Regards<br />
  Perry Norgarb<a value="+27217830350"></a>
  <br />
  <a href="http://t.sidekickopen14.com/e1t/c/5/f18dQhb0S7lC8dDMPbW2n0x6l2B9nMJW7t5XX48q5y9nW64zw5R3MqcVCW4X9Hq256dM0Wdmg-0W02?t=http%3A%2F%2Fwww.smallbizcrm.com%2F&amp;si=4744451886940160&amp;pi=40933b86-3b8f-420f-86a4-2337f3e7e797" value="+27217830350" target="_blank"><img src="https://ci3.googleusercontent.com/proxy/b_CKXY03lpen7nAZ4iGjszaHp_fMakXBrvEVIQ7PQrNJuRUwIcUbE_ioWMea0gOPy6x_AH6Rkw9TwzDW_ZeHPQh-Zvgl4IDCwbFyln6b-ejKmqpDsBRguXFBDsobJQ0rLXkvsW24_Q=s0-d-e1-ft#http://www.smallbizcrm.com/wp-content/uploads/2014/11/SmallBizCRM-Logo-200X44.png" alt="SmallBizCRM.com" height="42" width="200" /></a>
  <br />
  <a href="http://t.sidekickopen14.com/e1t/c/5/f18dQhb0S7lC8dDMPbW2n0x6l2B9nMJW7t5XX48q5y9nW64zw5R3MqcVCW4X9Hq256dM0Wdmg-0W02?t=http%3A%2F%2Fwww.facebook.com%2Fpages%2FSmallBizCRMcom%2F204289630712&amp;si=4744451886940160&amp;pi=40933b86-3b8f-420f-86a4-2337f3e7e797" target="_blank"><img alt="http://www.smallbizcrm.com/wp-content/uploads/2014/11/facebook-button.png" src="https://ci5.googleusercontent.com/proxy/C1VNIgLyLnIm26Q2urTY1IpvyiXd3PzXH16jv4OrRJC5ocGZzOfZR7C8htUQvL0YbJO37m3CIQCDiku2ZYCjob9OZPY3coBGT-jakwPHagxsC-CrSrKmCag_A7d2h2I=s0-d-e1-ft#http://www.smallbizcrm.com/wp-content/uploads/2014/11/facebook-button.png" /></a> <a href="http://t.sidekickopen14.com/e1t/c/5/f18dQhb0S7lC8dDMPbW2n0x6l2B9nMJW7t5XX48q5y9nW64zw5R3MqcVCW4X9Hq256dM0Wdmg-0W02?t=http%3A%2F%2Ftwitter.com%2FSmallBizCRM&amp;si=4744451886940160&amp;pi=40933b86-3b8f-420f-86a4-2337f3e7e797" target="_blank"><img alt="http://www.smallbizcrm.com/images/twitter_button.png" src="https://ci3.googleusercontent.com/proxy/u8lXrm9WR57HyVoFODtCQG1nSf8Z3hyYAKgPitEV6gDrvrQqmYpAmtKwiDK2duJNsifJtDgDm1JJ5HibN6qpre9Gao2U65NFI_3yKAOfY4s965kz6k0dBkdN1HbubQ=s0-d-e1-ft#http://www.smallbizcrm.com/wp-content/uploads/2014/11/twitter_button.png" /></a> <a href="http://t.sidekickopen14.com/e1t/c/5/f18dQhb0S7lC8dDMPbW2n0x6l2B9nMJW7t5XX48q5y9nW64zw5R3MqcVCW4X9Hq256dM0Wdmg-0W02?t=http%3A%2F%2Fza.linkedin.com%2Fin%2Fperrynorgarb&amp;si=4744451886940160&amp;pi=40933b86-3b8f-420f-86a4-2337f3e7e797" target="_blank"><img alt="http://www.smallbizcrm.com/images/LinkedIn-button.png" src="https://ci6.googleusercontent.com/proxy/Gnd97ZkXm9dT1gUfVJ82bVjSSQ1glEUvfblmnUb4_ihfoZL-8UUDE9yrTTC9sy-wZmCfc7Ul3mX9yIu9qRPm2PzCzvtAcbXnuIIVFRMLkDS0Wrac8k9NZeCNor1rvrA=s0-d-e1-ft#http://www.smallbizcrm.com/wp-content/uploads/2014/11/LinkedIn-button.png" /></a> <a href="http://t.sidekickopen14.com/e1t/c/5/f18dQhb0S7lC8dDMPbW2n0x6l2B9nMJW7t5XX48q5y9nW64zw5R3MqcVCW4X9Hq256dM0Wdmg-0W02?t=https%3A%2F%2Fplus.google.com%2Fu%2F0%2F106977010846902187739&amp;si=4744451886940160&amp;pi=40933b86-3b8f-420f-86a4-2337f3e7e797" target="_blank"><img alt="http://www.smallbizcrm.com/images/google-button.jpg" src="https://ci4.googleusercontent.com/proxy/EkfGkMIv0GPZaKRoLwQVsgaKEDZV587sBnP45B12KIPPZO3HDyV7D6b4gFLWIuRFXXTAvDlO5Y1L8gun-cZnvHDZJT6ZsHUnvSF4JnRZvttKLyV0gqdJrTcjNrti=s0-d-e1-ft#http://www.smallbizcrm.com/wp-content/uploads/2014/11/google-button.jpg" /></a>
  <br />
  Chat <img alt="Skype/" src="https://ci6.googleusercontent.com/proxy/zmB-06p8hXXvVAfUdcPIU7iF5Sy8WvV6BeNmm1Jx7fY9mcwhkpAGKV9sdYUo5YjCqfDmIucbcEebwDk=s0-d-e1-ft#http://images.wisestamp.com/skype.png" border="0" />searchmarketeers
</p>
</div>
</div>
</div>
