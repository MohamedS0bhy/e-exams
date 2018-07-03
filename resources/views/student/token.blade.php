<head>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    
        <style>
            .examToken
            {
                font-weight:bold;
                font-size:20px !important;
                margin-top:20px !important;
                padding:20px;
            }



            .container
            {
                margin-top:40px !important;
                
            }
            </style>
</head>

<div class="col-xs-12 text-center container"><h1 class="label label-primary examToken"> Exam token is {{ $token }}</h1></div>