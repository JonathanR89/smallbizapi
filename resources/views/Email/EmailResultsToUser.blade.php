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
        <th  align="center" ><h3 >Package</h3></th>
        <th  align="center" ><h3 >Description</h3></th>
        <th  align="center" ><h3 >Score</h3></th>
        <th  align="center" ><h3 >Link</h3></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 0;
      foreach ($results as $row) {
          ?>
        <tr>
          <?php
          $entry = null;
          foreach ($airtable->records as $record) {
              if ($record->fields->CRM == $row['name']) {
                  $entry = $record->fields;
                  break;
              }
          } ?>

          <td >
            <?php if (isset($entry->LOGO[0]->thumbnails->large->url)) {
              ?>
              <img src="<?php echo $entry->LOGO[0]->thumbnails->large->url ?>" width="64" />
              <?php

          } ?>
          </td>
          <td ><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'utf-8') ?></td>
          <td >
            <?php if (isset($entry->Description)) {
              ?>
              <?php echo $entry->Description ?>
              <?php

          } ?>
          </td>
          <td >
            <?php if ($row['score'] == -1) {
              ?>
              &#10003;
              <?php

          } elseif ($max) {
              ?>
              <?php echo sprintf('%d%%', $row['score'] / $max * 100) ?>
              <?php

          } else {
              ?>
              <?php echo sprintf('%d%%', $row['score']) ?>
              <?php

          } ?>
          </td>
          <td >
            <?php if (isset($entry->{'Visit Website Button'})) {
              ?>
              <a style="color:#fff;
              background-color:#337ab7;border-color:#2e6da4;display:inline-block;padding:6px 12px;
              margin-bottom:0;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;white-space:nowrap;
              vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;
              cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;
              user-select:none;background-image:none;
              border:1px solid transparent;border-radius:4px;
               text-decoration:none;" href="<?php echo $entry->{'Visit Website Button'} ?>">Visit website</a>
              <?php

          } ?>

            <div>
              <?php if ($entry) {
              if (env('APP_ENV') == 'local') {
                  $remote_address = "http://10.0.0.17:8080";
              } else {
                  $remote_address = "https://smallbizcrm.com/packagemanager/public";
              }
              if ($row['interested'] == 1) {
                  ?>

                  <form action=" {{$remote_address . "/vendor"}}" method="post">
                    <input type="hidden" name="vendor" value="{!! $entry->{'CRM'} !!}">
                    <input type="hidden" name="email" value="{{$data['email']}}">
                    <input type="hidden" name="results_key" value="{{$results_key}}">
                    <input type="hidden" value="{{ $submission['id'] }}" name="sub_id">
                    <input type="hidden" name="total_users" value="{{ $data['total_users'] }}">
                    <input type="hidden" value="<?php echo htmlspecialchars(json_encode($data)) ?>" name="data">
                    <button style="color:#000;background-color:#FF0;border-color:#2e6da4;display:inline-block;padding:6px 12px;margin-bottom:0;margin-top:15px;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;cursor:pointer !important;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-image:none;border:1px solid transparent;border-radius:4px; text-decoration:none;" type="submit" name="button">I'm Interested</button>
                  </form>

                  <?php

              }
          } ?>
            </div>
          </td>
        </tr>

        <?php

      } ?>
    </tbody>
  </table>




    <table bgcolor="#666666" height="24px" width="100%" style="border-bottom-left-radius:4px; border-bottom-right-radius:4px;">
      <tr>
        <th scope="col">&nbsp;</th>
      </tr>
    </table>
  </td>
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
