<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Thank You {{  $name  }}</title>
  </head>
  <body>
    <style>


body {
    padding: 0;
    margin: 0;
}

html { -webkit-text-size-adjust:none; -ms-text-size-adjust: none;}
@media only screen and (max-device-width: 680px), only screen and (max-width: 680px) {
    *[class="table_width_100"] {
    width: 96% !important;
  }
  *[class="border-right_mob"] {
    border-right: 1px solid #dddddd;
  }
  *[class="mob_100"] {
    width: 100% !important;
  }
  *[class="mob_center"] {
    text-align: center !important;
  }
  *[class="mob_center_bl"] {
    float: none !important;
    display: block !important;
    margin: 0px auto;
  }
  .iage_footer a {
    text-decoration: none;
    color: #929ca8;
  }
  img.mob_display_none {
    width: 0px !important;
    height: 0px !important;
    display: none !important;
  }
  img.mob_width_50 {
    width: 40% !important;
    height: auto !important;
  }
}
.table_width_100 {
  width: 680px;
}
</style>


<div id="mailsub" class="notification" align="center">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;"><tr><td align="center" bgcolor="#eff3f8">


<!--[if gte mso 10]>
<table width="680" border="0" cellspacing="0" cellpadding="0">
<tr><td>
<![endif]-->

<table border="0" cellspacing="0" cellpadding="0" class="table_width_100" width="100%" style="max-width: 680px; min-width: 300px;">
    <tr><td>
  <!-- padding -->
  </td></tr>
  <!--header -->
  <tr><td align="center" bgcolor="#ffffff">
    <!-- padding -->
    <table width="90%" border="0" cellspacing="0" cellpadding="0"><div style="height: 30px; line-height: 30px; font-size: 10px;"></div>
      <tr><td align="center">
              <a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; float:left; width:100%; padding:20px;text-align:center; font-size: 13px;">
                  <font face="Arial, Helvetica, sans-seri; font-size: 13px;" size="3" color="#596167">
                    @if (env('APP_ENV') == 'local')
                      <img src="https://www.smallbizcrm.com/wp-content/uploads/2015/06/SBCRM-Logo-final-blue-green-300X66.png" width="400" height="88" alt="SmallBizCRM" border="0"  /></font></a>
                      @else
                        <img src="https://www.smallbizcrm.com/wp-content/uploads/2015/06/SBCRM-Logo-final-blue-green-300X66.png" width="400" height="88" alt="SmallBizCRM" border="0"  /></font></a>
                        {{-- <img src="{{ url('/clear1.png') }}" width="400" height="88" alt="SmallBizCRM" border="0"  /></font></a> --}}
                    @endif
          </td>
          <td align="right">
        <!--[endif]--><!--

      </td>
      </tr>
    </table>
    <!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div>
  </td></tr>
  <!--header END-->

  <!--content 1 -->
  <tr><td align="center" bgcolor="#fbfcfd">
    <table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr><td align="center">
        <!-- padding --><div style="height: 60px; line-height: 60px; font-size: 10px;"></div>
        <div style="line-height: 44px;">
          <font face="Arial, Helvetica, sans-serif" size="5" color="#57697e" style="font-size: 34px;">
          <span style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">
            @if (isset($name))
              {{  $name  }}, Thank You for using SmallBizCRM.
              @else
                Thank You for using SmallBizCRM.
            @endif          </span></font>
        </div>
        <!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div>
      </td></tr>
      <tr><td align="center">
        <div style="line-height: 24px;">
          <font face="Arial, Helvetica, sans-serif" size="4" color="#57697e" style="font-size: 15px;">
          <span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">
            We have sent your request off to
            <strong>
              {{ $crm }}
            </strong>
             who will be in contact with you shortly to discuss your requirements.
          </span></font>
        </div>
        <!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div>
      </td></tr>
      <tr><td align="center">
        <div style="line-height: 24px; display: none !important;">
          <a href="#" target="_blank" class="btn btn-danger block-center">
              click
          </a>
        </div>
        <!-- padding --><div style="height: 60px; line-height: 60px; font-size: 10px;"></div>
      </td></tr>
    </table>
  </td></tr>
  <!--content 1 END-->


  <!--footer -->
  <tr><td class="iage_footer" align="center" bgcolor="#ffffff">


    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr><td align="center" style="padding:20px;flaot:left;width:100%; text-align:center;">
        <font face="Arial, Helvetica, sans-serif" size="3" color="#96a5b5" style="font-size: 13px;">
        <span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">
          {{date("Y")}} © SmallBizCRM.com. ALL Rights Reserved.
        </span></font>
      </td></tr>
    </table>


  </td></tr>
  <!--footer END-->
  <tr><td>

  </td></tr>
</table>
<!--[if gte mso 10]>
</td></tr>
</table>
<![endif]-->

</td></tr>
</table>

  </body>
</html>
