
<div align="center">
  <div style="width:700px;" align="center">
    <div align="left" style="padding-left:50px;">
    <img src="https://www.smallbizcrm.com/wp-content/uploads/2015/06/SBCRM-Logo-final-blue-green-300X66.png" width="400" height="88" alt="SmallBizCRM" border="0"  />
      <h2>CRM Inquiry</h2>
      <h4>
        This person has visited SmallBizCRM.com and filled out our CRM Needs Analysis Questionnaire. They have expressed interest in your product, as it came up as a match to their requirements (see below). Please follow up with them soonest. Thank you!
      </h4>

    </div>
    <div>
      <table style="margin-top:20px; width:600px; border-radius:4px;">
        <tr>
          <th width="50%" style="background-color:#CCC; border-top-left-radius:4px;">Price per user</th>
          <td style="padding-left:15px;border-bottom:thin solid #d6d6d6; border-top:solid thin #d6d6d6;">{{ $data['price'] ? $data['price'] : "Nothing Selected By User" }}</td>
        </tr>
        <tr>
          <th style="background-color:#CCC;">Industry</th>
          <td style="padding-left:15px;border-bottom:thin solid #d6d6d6;"> {{ $data['industry'] ? $data['industry'] : "Nothing Selected By User"  }}</td>
        </tr>
        <tr>
          <th style="background-color:#CCC; border-bottom-left-radius:4px;">Total Anticipated Users</th>
          <td style="padding-left:15px; border-bottom:solid thin #d6d6d6;">{{ $data['total_users'] ? $data['total_users'] : "Nothing Selected By User" }}</td>
        </tr>
        <tr>
          <th style="background-color:#CCC;">Additional comments / requirements</th>
          <td style="padding-left:15px;border-bottom:thin solid #d6d6d6;">{{ $data['comments']  ? $data['comments']  : "Nothing Selected By User"}}</td>
        </tr>
        <tr>
          <th style="background-color:#CCC;">Name</th>
          <td style="padding-left:15px;border-bottom:thin solid #d6d6d6;">{{ $data['fname'] ? $data['fname'] : "Nothing Selected By User" }}</td>
        </tr>
        <tr>
          <th style="background-color:#CCC; border-bottom-left-radius:4px;">Email</th>
          <td style="padding-left:15px; border-bottom:solid thin #d6d6d6;">{{ $data['email'] ? $data['email'] : "Nothing Selected By User" }}</td>
        </tr>
      </table>
    </div>

    <div align="left" style="padding-left:50px;">
      <h2>Answers</h2>
    </div>

    <div>
      <table width="600px" style="border-radius:4px; margin-top:20px;">
        <tr>
          <th width="67%" style="background-color:#CCC; border-top-left-radius:4px;">Metric</th>
          <th style="background-color:#CCC; border-top-right-radius:4px;">Score</th>
        </tr>
        <?php foreach ($scores as $row) {
    ?>
          <tr>
            <td style="padding-left:15px;border-bottom:thin solid #d6d6d6;"><?php echo htmlspecialchars($row->name, ENT_QUOTES, 'utf-8') ?></td>
            <td style="border-bottom:thin solid #d6d6d6;" align="center"><?php echo intval($row->score) ?></td>
          </tr>
          <?php

} ?>
      </table>
    </div>

  </div>
  <div>
    <h2>Metric Legend</h2>
    <div align="left">
      <ol>
        <li>This covers the level of definition you need to record for people and organisations and relationships between them. Complex might include people / clients who have a portfolio of positions or responsibilities, client organisations with multi-level and multi-location structures, multiple decision-makers and influencers per deal and similar.</li>
        <li>This covers the level of definition you need to record for the products and services you sell. Complex might mean multiple pricing structures, discount tarrifs, pre and co-requisites and more, and also product related analysis and forecasting, especially when this informs distribution or manufacturing decisions.
        </li>
        <li>This covers the level of definition you need to record for people who use the CRM sytem, including what records they can create, view, update and delete, sales team structures with multiple sales manager groupings, what devices they can access the system from, eg. PC (Windows/MAC, Mobile Phone (Apple/IOS, Android) tablets and other devices.
        </li>
        <li>This covers the level of data flow into and out of the CRM system, going beyond the initial data load and as part of the ongoing process of contact, communications and business management. Complex goes beyond batch import/export and into real-time integration with ad-hoc email systems such as Outlook/Exchange and Gmail/Google Apps and Social Media (Twitter, Facebook, LinkedIn, Google+) and Calendar systems and may include real-time integration with telephony/call-centre apps, email marketing apps, campaign management and lead scoring, and distribution, manufacturing and accounting apps.
        </li>
        <li>This covers the level of document and file integration you need. Complex might include correspondence, quotes, proposals etc. submitted to one or multiple people and visible at multiple levels such as by person, by bid, by organisation etc. </li>
        <li>This covers the level of definition you need to record for sales territories, quotas, performance tracking, commission payments etc. Complex might include split or overlay territories, quotas for multiple product/service lines per sales person, performance reports by different product lines, and commissions paid at different percentages for different lines within the CRM.</li>
        <li>This covers the level of sophistication you require to support analysis and decision-making within the CRM system. Complex might include forecasting for multiple product/service lines for multiple sales people with graphical displays and exception alerts, a business/sales dashboard highlighting key measurements, with alerts highlighting those outside of tolerance levels, overlays of performance between different aspects such as between different time periods or different product lines. </li>
        <li>Adding new contacts and leads to the CRM system is a regular activity that could be a one-by-one task (eg. data entry or web lead capture form) or a bulk task (eg .csv file upload). Adding records per se is rarely complex, but the level of data cleaning and de-duplication, data enrichment, triggering of follow-up activity and similar can add considerable complexity.</li>
        <li>Sending email broadcasts in batches, either from the CRM system or from a dedicated email marketing system is fairly straight forward. However, conditional email messages, multi-step sequences based on behaviour and/or profile roles, and conditional content in emails adds considerable complexity. </li>
        <li>Sending letters, postcards and other direct mail from the CRM system is relatively straight forward, if the CRM has data selection capabilities and mail-merge functionality. Complexity arises when the direct mail is conditional on profile factors (such as changing company or job title)  or behaviour (such as placing an order). </li>
        <li>Recording that outbound or inbound calls have taken place, and diarising future calls is relatively straight forward when done manually. Automation of outbound calling list creation, CTI (Computer Telephony Integration) to automatically dial and allocate outbound calls to an agent, or to identify incoming calls based on CLI (Caller Line Identification) and allocate to agent and pre-populate the screen from the CRM records is relatively complex.</li>
        <li>Recording social media profiles for contacts is relatively straight forward. Listening for activity for existing contacts is increasingly attractive, but depends on integration. Complex areas are, for example, listening out for opportunities on Twitter, Facebook and other social media, then responding automatically.</li>
        <li>Creating, scheduling and managing one-off and ad-hoc activities and events with contacts (eg. phone calls, meetings etc.) are relatively standard with CRM systems. Complex requirements include being able to organise multi-attendee event (such as webinars and exhibitions), create and execute multi-step promotion campaigns, and manage multiple levels of follow-up (to attendees, to no-shows, to interested but didn't book etc.) </li>
        <li>Going beyond one-off, batch campaigns, the ability to create and execute multi-step, multi-channel campaigns are essentially complex. Multi-step follow-up to an initial trigger such as website registration is intermediate level. Multi-step, multi-channel, conditional follow-up to a variety of initial triggers, combined with lead scoring based on rules gets into the realm of very complex.</li>
        <li>Analysis of a single area (eg. a Website Landing Page Conversion, an email broadcast response, phone calls made and outcomes achieved) is relatively straight forward. Complex requirements are when analysis is required across the extended customer journey, across multiple stages and multiple channels, to provide comparisons between customer segments, campaigns, channels etc. plus measures of expenditure and time taken, and inform decisions about future focus and resource allocation. </li>
        <li>The ability to store email correspondence history against a contact record and to create ad-hoc emails to a contact is relatively straight forward, subject to which email sytem is being used eg. Outlook/Exchange, Gmail etc. Complexity levels increase in areas such as assisted email creation using pre-formated responses, email open and click tracking with associated alerts and history logging.</li>
        <li>Manual scheduling of telephone calls, and recording notes of the phone call and follow-up actions is relatively straight forward. Sales campaign progression to the next step can also be recorded manually, along with follow-up activity. Complexity increases as the desire to have phone calls prompted by various triggers set either internally from campaigns or externally from recipient behaviour. Call recording and/or speech to text transcription and similar steps adds complexity. </li>
        <li>Scheduling and recording that ad-hoc meetings are due to take place and have taken place is relatively straight forward for most CRMs. Complexity increases as the desire to be more structured about meeting objectives, agendas, information imparted and gathered, influence applied, purchase intentions gathered etc. are captured, and when there are multiple people in the meeting, on the buyer and vendor sides. </li>
        <li>Simple purchases of single items at a single price are relatively straight forward. Complex requirement, for example, are when a shopping cart is needed for multiple item purchases, when multiple extra costs and discounts may be needed, when potential purchases can be saved and revisited in future, and when purchases can be made on account rather than by credit card or other immediate payment method. </li>
        <li>Creating quotations manually and storing them against a contact or account record is relatively straight forward, if the system can store documents or structured quotation data. Complexity increases as the desire to generate quotations online and automatically, based on options for products and services, including descriptions, prices, discounts, and contractual details that are applicable if the customer then goes ahead and decides to purchase, together with automated follow-up to increase the likelihood of conversion to an order. </li>
        <li>Management of activity, information and intentions around bids and complex sales becomes complex when it involves more than recording and managing discrete activities already covered. Complexity increases as multiple decision-makers and stakeholders are involved, as multiple strands of communication take place and need to be recorded, as documentation becomes more complex across text, presentations etc. and version control is required, and where forecasting of financial value, probability and timescale are less clear-cut. </li>
        <li>Although this is listed towards the end of the CRM requirements list there is a case to make this the first entry, because, depending on the decisions that will be taken based on this information so it determines the value and cost that it is worth assigning to collection and management of the data. Complexity increases as the time horizon moves to a 'just-in-time', 'real-time' view where multiple people from the CEO down desire to look at the CRM to gain an instant and up-to-date view of any and all activity. </li>
        <li>Control and tracking of the dispatch of physical goods may be desired as a part of the CRM suite, either directly or as a summary transaction. Complexity increases as more of this activity is required to be managed and recorded within the CRM, rather than in a dedicated distribution system and/or accounting sytem. </li>
        <li>Control and tracking of the delivery of service based and project based orders may be desired as part of the CRM suite, either directly or as a summary transaction. Complexity increases as more of this activity is required to be managed and recorded within the CRM, rather than in a dedicated project management and resource allocation system.</li>
        <li>Recording, handling and tracking of customer queries, whether they are initiated online, over the phone or via another means, may be required as part of the CRM suite. Complexity increases as these move from being a 'one-and-done' query that is closed immediately, into a multi-step activity involving multiple people and multiple contact activities.</li>
        <li>Creating, accessing and maintaining a database or knowledge centre of information about products, services,  queries, questions etc. may be desired as an extension of the CRM suite.  Complexity increases as this moves from a single level system where authorised users can access all information, to levels where access and permissions become governed by increasingly complex rules. </li>
        <li>This line highlights that some businesses have a more complex value delivery model than supply of products or services. For example there might be Service Level Agreements that need to be managed (eg. IT Operations Services business), or campaign outcomes that need to be achieved in order to be paid (eg. marketing agency), or time and materials contracts to be managed (eg. security guard business) . If this is the case, applications that manage those may have a significant bearing over what CRM system is most applicable to assist with managing the marketing and selling activity.</li>
        <li>This line highlights that some businesses have a very structured set of activities where marketing and sales rules can be defined and applied, for example, regulated industries such as financial services, construction related business such as architects or recruitment based businesses. </li>
        <li>This line highlights that for some businesses the direct sell model is supplemented or replaced by a 3rd party or partner sales channel, such as motor trade and other dealership outlets, support of a retail network, a franchise network, an affiliate network etc.</li>
        <li>This line highlights that for some businesses there is a powerful need or benefit to create and manage a customer community, especially where referrals and advocates provide a significant boost to marketing and sales efforts and they need to be recognised and rewarded.</li>
        <li>This line highlights that for some businesses there is a powerful need and benefit to create and manage a staff and employee community, epecially for knowledge based organisations and where staff collaboration is desireable to solve customer issues, create staff loyalty and encourage innovation.<br />
        </li>
      </ol>
    </div></div>
  </div>
