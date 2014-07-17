<?php

 $this->layout = 'column1';

 Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/bootstrap-docs.css');

?>

<h1 class="page-header">Self Help and Support</h1>

<div class="row-fluid">

 <div class="span3">

  <ul id="toc" class="nav nav-list bs-docs-sidenav affix-bottom" data-spy="affix" data-offset-top="5">

    <li><a href="#intro">Introduction<i class="icon-chevron-right"></i></a></li>

    <li><a href="#workspace">The Workspace<i class="icon-chevron-right"></i></a></li>

    <li><a href="#enroll">How do I enroll a new employee?<i class="icon-chevron-right"></i></a></li>

    <li><a href="#newnotice">How do I submit a new change notice?<i class="icon-chevron-right"></i></a></li>

    <li><a href="#sign">How do I sign a change notice?<i class="icon-chevron-right"></i></a></li>

    <li><a href="#searchemployee">How do I search and view a particular employee profile?<i class="icon-chevron-right"></i></a></li>

    <li><a href="#searchnotice">How do I search for a particular change notice?<i class="icon-chevron-right"></i></a></li>

    <li><a href="#license">How do I manage employee licenses, certifications and other documents that require expiration date tracking?<i class="icon-chevron-right"></i></a></li>

    <li><a href="#account">How do I request IT for a login account to a certain system?<i class="icon-chevron-right"></i></a></li>        

    <li><a href="#pass">How can I personalize my password?<i class="icon-chevron-right"></i></a></li>

    <li><a href="#support">How can I contact support?<i class="icon-chevron-right"></i></a></li>

  </ul>

 </div>

 <div class="span9" data-spy="scroll" data-target="#toc">

  <section id="intro">

    <h3>Introduction</h3>

    <p>

     The <?php echo Yii::app()->name; ?> is a Human Resource Information System that specifically functions as a workflow application. 

     It aims to:

     <ol>

      <li>To convert the current employee hiring or information change of Eva Care Group facilities from manual to software-assisted process</li>

      <li>To provide a workflow for new hire, change of information and termination notices</li>

      <li>To keep a record of employee profiles for HR's or management's use</li>

      <li>To provide an automated alert and notification feature</li> 

     </ol>

    </p>

  </section>

  <section id="workspace">

    <h3>The Workspace</h3>

    <p>

     The interface is a work-focused and search-driven one. 

    </p>

    <div class="thumbnail">

      <img src="<?php echo Yii::app()->baseUrl; ?>/images/docu/workspace.jpg" rel="tooltip" title="The Workspace">

      <h3>Welcome Page</h3>

      <p>

        <dt>A - Persistent Navigation Bar</dt><dd>Launch a new hire or change notice form here. You can also search for employee profiles or change history here.</dd>

        <dt>B - Folders and Forms</dt><dd>This is the workflow inbox and new forms section. Click a folder to view its contents.</dd>

        <dt>C - Request Forms for Approval</dt><dd>This lists down the requests that you need to work on. Click one request to view its details.</dd>

        <dt>B - Request Details</dt><dd>This part contains the details of the request.</dd>

      </p>

    </div>

  </section>    

  <section id="enroll">

    <h3>How do I enroll a new employee?</h3>

    <p>

     There are two ways:

    </p>

    <ul>

      <li>Kiosk Terminal

        <ol>

          <li>On the homepage at the navigation bar, click <strong>Kiosk</strong>.</li>

          <li>On the Self-Service Kiosk page, click <strong>New Employee Application Form.</strong></li>

          <li>Complete the new hire form and hit the <strong>Submit</strong> button.</li>

        </ol>

      </li>

      <li>New Hire Form

        <ol>

          <li>Login to your account.</li>

          <li>On your workspace at the Folders and Forms section, click <strong>New Hire Form</strong>.</li>

          <li>Complete each section of the form and then hit the <strong>Next</strong> button. You may go back to the previous section by click on the <strong>Back</strong> button.</li>

        </ol>

      </li>

    </ul>

  </section>  

  <section id="newnotice">

    <h3>How do I submit a new change notice?</h3>

    <ol>

      <li>Login to your account.</li>

      <li>On your workspace at the Folders and Forms section, click <strong>New Change Notice Form</strong>.</li>

      <li>Select an employee.</li>

      <li>Complete each section of the form and then hit the <strong>Next</strong> button. You may go back to the previous section by click on the <strong>Back</strong> button.</li>

    </ol>

  </section>  

  <section id="sign">

    <h3>How do I sign a change notice?</h3>

    <p>

     There are two ways:

    </p>

    <ul>

      <li>Workspace

        <ol>

          <li>Login to your account.</li>

          <li>On your workspace at the Request Details section, click the processing group that you belong to.</li>

          <li>On the Workflow Thread section, complete the workflow form and then hit on <strong>Process</strong> / <strong>Approve</strong> / <strong>Deny</strong> button.</li>

        </ol>

      </li>

      <li>Request Details View

        <ol>

          <li>Login to your account.</li>

          <li>On your workspace at the Request Details section, click the <strong>Workflow Actions</strong> button and then select <strong>View Details</strong>.</li>

          <li>On the Workflow section, browse to your workflow group.</li>

          <li>Complete the workflow form and then hit on <strong>Process</strong> / <strong>Approve</strong> / <strong>Deny</strong> button.</li>

        </ol>

      </li>

    </ul>

  </section> 

  <section id="searchemployee">

    <h3>How do I search and view a particular employee profile?</h3>

    <ol>

      <li>Login to your account.</li>

      <li>On the Persistent Navigation Bar, click <strong>Employee</strong> and select <strong>Search</strong>.</li>

      <li>On the employee list grid, enter the keyword or select an option and press the <strong>Enter</strong> key to filter the results.</li>

      <li>To define a more specific search criteria, click the <strong>Advanced Search</strong> button.</li>

      <li>Fill out the filters that you need and then hit <strong>Search</strong>. You can also print out a report instead by clicking the <strong>Print Preview</strong> button.</li>

      <li>When you've found the employee that you're searching for, on the employee row click the <strong>Actions</strong> button and then select <strong>View Details</strong>.</li>

    </ol>

  </section> 

  <section id="searchnotice">

    <h3>How do I search for a particular change notice?</h3>

    <ol>

      <li>Login to your account.</li>

      <li>On the Persistent Navigation Bar, click <strong>Change Notice Requests</strong> and select <strong>Search</strong>.</li>

      <li>On the notice list grid, enter the keyword or select an option and press the <strong>Enter</strong> key to filter the results.</li>

      <li>To define a more specific search criteria, click the <strong>Advanced Search</strong> button.</li>

      <li>Fill out the filters that you need and then hit <strong>Search</strong>. You can also print out a report instead by clicking the <strong>Print Preview</strong> button.</li>

      <li>When you've found the notice that you're searching for, on the notice row click the <strong>Actions</strong> button and then select <strong>View Details</strong>.</li>

    </ol>  </section> 

  <section id="pass">

    <h3>How can I personalize my password?</h3>

    <ol>

      <li>Login to your account.</li>

      <li>On the Persistent Navigation Bar, click your Username and select <strong>Reset Password</strong>.</li>

      <li>Complete the Password Reset Form and hit <strong>Save</strong>.</li>

    </ol>

  </section>

  <section id="license">

    <h3>How do I manage employee licenses, certifications and other documents that require expiration date tracking?</h3>

    <p>

     There are two ways:

    </p>

    <ul>

      <li>Employee Profile - Licenses Tab

        <ol>

          <li>Login to your account.</li>

          <li><a href="#searchemployee"><strong>View</strong></a> the Employee's profile.</li>

          <li>On the License tab, click the <strong>New</strong> button.</li>

          <li>Complete the New License Form and then hit the <strong>Submit</strong> button.</li>

        </ol>

      </li>

      <li>Workspace

        <ol>

          <li>Login to your account.</li>

          <li>On the Workspace at the Folders and Forms section, click the <strong>New License Form</strong> link.</li>

          <li>Complete the New License Form and then hit the <strong>Submit</strong> button.</li>

        </ol>

      </li>

    </ul>

    <p>

     The system automatically sends out an email alert to the Business Office Manager if a license or certification has expired.

    </p>

  </section> 

  <section id="account">

    <h3>How do I request IT for a login account to a certain system?</h3>

    <p>

     There are two ways:

    </p>

    <ul>

      <li>Employee Profile - IT Accounts Tab

        <ol>

          <li>Login to your account.</li>

          <li><a href="#searchemployee"><strong>View</strong></a> the Employee's profile.</li>

          <li>On the IT Accounts tab, click the <strong>New</strong> button.</li>

          <li>Complete the New Systems Account Request Form and then hit the <strong>Submit</strong> button.</li>

        </ol>

      </li>

      <li>Workspace

        <ol>

          <li>Login to your account.</li>

          <li>On the Workspace at the Folders and Forms section, click the <strong>Request New / Modify Account Form</strong> link.</li>

          <li>Complete the New Systems Account Request Form and then hit the <strong>Submit</strong> button.</li>

        </ol>

      </li>

    </ul>

    <p>

     The system automatically sends out an email alert to IT.

    </p>

  </section>

  <section id="support">

    <h3>How can I contact support?</h3>

    <p>

     Feel free to contact:

    </p>

    <ul>

      <li>HR Workflow Support:

        <address>

          <br>

          <strong>Julian Sylve</strong><br/>

          HR Assistant, Eva Care Group<br/>

          <abbr>Phone:</abbrv> (310) 889-9929<br>

          <abbr>Email:</abbr> <a href="mailto:hr@evacare.com">hr@evacare.com</a>

        </address>

      </li>

      <li>IT Support:

        <address>

          <br>

          <strong>Steven Ly</strong><br/>

          Junior Programmer, Eva Care Group<br/>

          <abbr>Phone:</abbrv> (310) 882-5122 ext. 108 (Mon-Fri, 7:00 AM - 3:00 PM) | <?php echo Yii::app()->params['adminPhone']; ?> (Sat-Sun)<br>

          <abbr>Email:</abbr> <a href="mailto:<?php echo Yii::app()->params['adminEmail']; ?>"><?php echo Yii::app()->params['adminEmail']; ?></a>

        </address>

      </li>

    </ul>

  </section> 

 </div>

</div>

<br/><br/><br/>