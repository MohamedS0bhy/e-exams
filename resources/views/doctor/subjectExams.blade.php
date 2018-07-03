@extends('doctor.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"  style="background:white;">

    <!-- Main content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            exams
            {{-- <small>st</small> --}}
        </h1>

       
    </section>

    <section class="content">
        <script>function dcSubExams(){}</script>
        <img src="{{ asset('img/loading-3.gif') }}" alt="Loading" onload="setTimeout(dcSubExams({{ $id }}) , 0)" class="loadingGif">
  
      </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

@endsection