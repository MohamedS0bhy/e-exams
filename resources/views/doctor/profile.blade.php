<?php
JWTAuth::setToken($_COOKIE['token']);  
$usr = JWTAuth::toUser();

?>
@extends('doctor.index')

@section('title')
    Profile
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"  style="background:white;">

        <!-- Main content -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Profile
                <small>dc</small>
            </h1>
    
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Profile</li>
            </ol>
        </section>
    
        <section class="content">
    
            <div class="row">
              
              <!-- /.col -->
              <div class="col-md-9" style="width:60%">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">              
                    <li class="active"><a href="#basicInfo" data-toggle="tab">Your Data</a></li>
                    <li ><a href="#updateInfo" data-toggle="tab">Update Your Data</a></li>
                    <li><a href="#chPass" data-toggle="tab">Change Pass</a></li>
                  </ul>
                  <div class="tab-content">
                    <!-- /.tab-pane -->
      
                    <div class="active tab-pane" id="basicInfo">
                      <form class="form-horizontal">
                        <div class="form-group">
                          <label for="userName" class="col-sm-2 control-label">Username</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" id="userName" placeholder="Username" disabled="" value="{{ $usr->username }}">
                          </div>
                        </div>
                          
                        <div class="form-group">
                          <label for="email" class="col-sm-2 control-label">Email</label>
      
                          <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" placeholder="Email" disabled="" value="{{ $usr->email }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="phone" class="col-sm-2 control-label">Phone</label>
      
                          <div class="col-sm-10">
                            <input type="tel" class="form-control" id="phone" placeholder="phone" disabled="" value="{{ $usr->phone_number }}">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="birthdate" class="col-sm-2 control-label">Phone</label>
      
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="birthdate" placeholder="Birth Day" disabled="" value="{{ $usr->date_of_birth }}">
                          </div>
                        </div>
              
                      </form>
                    </div>

                    <div id="updateInfo" class="tab-pane">
                      
                      <form id="updData" class="form-horizontal" onsubmit="return false;">
                        @csrf
                        <div class="form-group">
                          <label for="userName" class="col-sm-2 control-label">Username</label>
                          <div class="col-sm-10">
                              <input type="text" name="username" class="form-control" id="userName" placeholder="Username"  value="{{ $usr->username }}">
                          </div>
                        </div>
                          
                        <div class="form-group">
                          <label for="email" class="col-sm-2 control-label">Email</label>
      
                          <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email" disabled="" value="{{ $usr->email }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="phone" class="col-sm-2 control-label">Phone</label>
      
                          <div class="col-sm-10">
                            <input type="tel" name="phone_number" class="form-control" id="phone" placeholder="phone" value="{{ $usr->phone_number }}">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="birthdate" class="col-sm-2 control-label">Phone</label>
      
                          <div class="col-sm-10">
                            <input type="date" name="date_of_birth" class="form-control" id="birthdate" placeholder="Birth Day" value="{{ $usr->date_of_birth }}">
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger" onclick="updData()">Update</button>
                          </div>
                        </div>
                      </form>

                    </div>


                    <div id="chPass" class="tab-pane">
                     
                      <form id="updPass" class="form-horizontal" onsubmit="return false;">
                        @csrf
                        
                        <div class="form-group">
                          <label for="currentPass" class="col-sm-4 control-label">Current Password</label>
                          <div class="col-sm-8">
                              <input type="password" name="currentPass" class="form-control" id="currentPass" placeholder="Current Password"  value="" autocomplete="off" required>
                              
                            </div>
                        </div>
                          
                        <div class="form-group">
                          <label for="newPass" class="col-sm-4 control-label">new Password</label>
      
                          <div class="col-sm-8">
                            <input type="password" name="newPass" class="form-control" id="newPass" placeholder="new Password"  value="" autocomplete="off" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="confirmPass" class="col-sm-4 control-label">Confirm Password</label>
      
                          <div class="col-sm-8">
                            <input type="password" name="confirmPass" class="form-control" id="confirmPass" placeholder="Confirm Password" value="" autocomplete="off" required>
                            <small id="passwordHelpInline" class="text-muted" style="display:none">
                              Password not match
                            </small>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <button id="updButton" type="submit" class="btn btn-danger" onclick="updPass()">Update</button>
                            <small id="response" class="text-muted" style="display:none">
                                
                            </small>
                          </div>
                          
                        </div>
                      </form>

                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
      
          </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection