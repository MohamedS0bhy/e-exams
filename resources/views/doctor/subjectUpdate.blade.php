@extends('doctor.index')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >
        <!-- Main content -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            

        </section>

        <section class="content">
                <script>function dcSubContent(){}</script>
            <img src="{{ asset('img/loading-3.gif') }}" alt="Loading" onload="setTimeout(dcSubContent({{ $id }}) , 0)" class="loadingGif">
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection