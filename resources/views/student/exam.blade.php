<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>exam</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        
        <link rel="ref="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
        <link rel="stylesheet" href="{{asset('dist/css/skins/skin-blue.min.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- custom styles mine -->
        <link rel="stylesheet" href="{{asset('css/mycss.css')}}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="hold-transition skin-blue sidebar-mini" >

        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a  href='https://examsvc.herokuapp.com' class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">E E</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">E-exmas</span>
                </a>
                
            </header>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper"  style="background:white;">
        
                <!-- Main content -->
                <!-- Content Header (Page header) -->
                <section class="content-header">
        
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <input type='text' placeholder="enter exam name" class='form-control text-center' id="exam-name"/>
                        </div>
                        
                        
                        <div class="col-sm-12 text-center">
                        <input type='text' placeholder="enter exam description" class='form-control text-center' id="exam-desc"/>
        </div>
        <div class="col-sm-12 text-center">
        <select id='subjCmb' class='form-control buildButton'></select>
        </div>
                        <div class="col-sm-12 text-right">
                            <input type='text' placeholder="enter time in minutes" id="duration"/> 
    
                        </div>
                    </div>
                    <hr>
                </section>


                <div class='col-xs-12 text-center examToken' id="tokenSection">
                    <input placeholder="Insert Exam token" class='form-control' id='examTokenTxt'></input>
                    <button onclick="CheckExamToken()" class="btn btn-primary">Enter Exam</button>
        </div>
        <div id="examSection">
                <section class="content" id="examView">
                              <div id="examQuestions"></div>
<div class='row text-center'>


<div id="examToken"></div>
<div id="result"></div>
                              <button id='addQuestionBtn' onclick="AddQuestion()" class="btn btn-success buildButton">Add New Question</button>
        
                              <button id='generateToken' onclick="generateToken()" class="btn btn-success buildButton">Get token</button>
        
<button id='backBtn' class="btn btn-primary back" onclick="switchToBuildMode()">Back</button>
<button id='viewBtn' class="btn btn-primary buildButton" onclick="switchToViewMode()">View</button>
<button class="btn btn-success buildButton" onclick="SaveExam()" id="saveBtn" >Save</button>
                                    <button class="btn btn-success" onclick="CorrectExam(true)" id="submitBtn" >Submit</button>

        </div>
        </div>
                </section>
                <!-- /.content -->
               
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="pull-right hidden-xs">
                <strong>FCIH GP</strong> 
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy;
                    <script>document.write(new Date().getFullYear())</script>
                    All rights reserved.
            </footer>

        


        </div>
        <!-- ./wrapper -->

        <!-- jQuery 3 -->
        <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{asset('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- Slimscroll -->
        <script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
        <!-- FastClick -->
        <script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
        <script src="{{asset('js/jquery.cookie.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/myjs.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/examControl.js')}}" type="text/javascript"></script>
    </body>
</html>
