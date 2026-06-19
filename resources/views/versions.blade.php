@extends('layouts.app')

@section('content')
<div class="container-fluid p-5 bg-primary text-white text-center">
  <h1>CAU Imphal Quiz Application</h1>
  <p>Version 
  @if($id == '1.1')
  1.1 Alpha
  @elseif($id == '1.2')
  1.2 Alpha
  @elseif($id == '2.0.1')
  2.0.1 First Beta Release
  @elseif($id == '2.0.2')
  2.0.2 Second Beta Release
  @elseif($id == '2.1')
  2.1 Stable Release
  @elseif($id == '2.1.2')
  2.1.2 Under Development
  @endif
  </p> 
</div>
  
<div class="container mt-5">
  <div class="card">
    <div class="card-header">
        <div class="card-title">
            @if($id == '1.1')
              1.1 Alpha
              @elseif($id == '1.2')
              1.2 Alpha
              @elseif($id == '2.0.1')
              2.0.1 First Beta Release
              @elseif($id == '2.0.2')
              2.0.2 Second Beta Release
              @elseif($id == '2.1')
              2.1 Stable Release
              @elseif($id == '2.1.2')
              2.1.2 Under Development
              @endif
        </div>
    </div>
    <div class="card-body">
            @if($id == '1.1')
              This is an first alpha release of the software.<br>
              User Roles:
              <ul>
                  <li>User roles added where users newly added must be provided with a role type - Local Admin, Local Admin 2 or Student</li>
                  <li>Users are segregated as per college/location and seperate administrators can be allocated</li>
                  <li>Local Admin 2 have the role to add new quiz and new questions</li>
                  <li>Local Admin on top of above can create new users, map users to respective locations, create database table, map database table for their respective location</li>
                  <li>Students can select suitable quiz and take exam as per convenience</li>
              </ul>
              Module:
              <ul>
                  <li>Quizzes can be created multiple times as per requirement</li>
                  <li>Each quiz must have multiple questions having 4 multiple choice type questions</li>
                  <li>All the questions as well as the answers are to be fitted in the system by respective administrators of concerned locations</li>
                  <li>As long as the quiz is not published, it will not be visible to students and no students can take the exam</li>
                  <li>Quiz can be published and Un-Publish at any point of time.</li>
                  <li>Before publishing a quiz, it has to be mapped with a database table so that answers marked by students can be saved</li>
                  <li>Once database table is mapped, it cannot be un-mapped as it may create data mismatch</li>
                  <li>Every quiz, while creating must be provided with a time(in minutes) so that when students start the quiz, a timer will automatically start according to it</li>
                  <li>For every students, the questions are randomly selected from database and jumbled so as to avoid cheating</li>
              </ul>
              User Manuals:
              <ul>
                  <li>User Manuals for students are provided on front panel and is made available for all users</li>
                  <li>User Manuals for Admins are provided in the dashboard.</li>
              </ul>
              @elseif($id == '1.2')
              User Roles:
              <ul>
                  <li>Local Admin can allocated newly joined members as Local Admin 2</li>
                  <li>Local Admin has been provided with same role as Super Admin only location specific</li>
                  <li></li>
              </ul>
              Module:
              <ul>
                  <li>Database table can be created by Local Admin now</li>
              </ul>
              Student Page:
              <ul>
                  <li>Beautifully designed dynamic quiz portal where all the questions are displayed in order</li>
                  <li>Students can jump from one question to another easily by clicking on the question numbers provided</li>
                  <li>Distinctive color codes are provided to distinguish Attempted, Skipped and Current Questions on the Portal</li>
              </ul>
              @elseif($id == '2.0.1')
              This is our first Beta Version Release:<br>
              Over the last few days we've addressed several enduser issues:
              <ul>
                  <li>Fixed the question adding issue. Questions can be added as much as the Admin wants</li>
                  <li>Result Viewing has been added as new module. All the admins have the privilege to vew results and it is location specific</li>
                  <li>Result can be viewed Quiz wise as well as student wise</li>
                  <li>Fixed the show quiz and show question issue where it has been made location specific</li>
                  <li>Similarly fixed the edit quiz and edit question issue where it has been made location specific</li>
              </ul>
              @elseif($id == '2.0.2')
                This is our second Beta Version Release:<br>
                Over the last few days we've addressed several enduser issues:
              <ul>
                  <li>Added one very important module in Question creation where if there is formulae or diagram or graph, admins can upload a snippet of the question as image file</li>
                  <li>A remove button is added in the students "My Selection" TAB where if the student has selected the quiz by mistake, it can be removed as long as it is not opened</li>
                  <li>A popup alert has been added on student quiz portal where as soon as the quiz countdown timer reaches 0, it will automatically popup and force the user to click on a button which will allow the user to redirect to dashboard</li>
              </ul>              
              @elseif($id == '2.1')
              2.1 Stable Release
              <br>
              The Stable version of Quiz Application is now released.
              Following are the newly added features:
              <ul>
                  <li>Local Admins can now share quiz created to other locations</li>
                  <li>However the shared locations has to map the quiz on their own</li>
                  <li>All the questions are automatically fetched from the base Location</li>
                  <li>Deleting a shared quiz is, however, not allowed to any admin level. It has to be done at backend</li>
              </ul>
            @elseif($id == '2.1.2')
              2.1.2 Under Development
              <br>
              This is a very exciting new release of the Application
              Following are the newly added features:
              <ul>
                  <li>Local Admins can now generate reports like Users Registered, Faculties Registered</li>
                  <li>Reports generated can be exported as Excel File</li>
                  <li>Questions added can now be printed. A print option is provided</li>
                  <li>Added a new module "Exam Student Selector" where respective faculties can select students who will be appearing for the examination</li>
                  <li>Another new Module where students can also upload questions is under development</li>
              </ul>
            @endif
    </div>
  </div>
</div>
@endsection
