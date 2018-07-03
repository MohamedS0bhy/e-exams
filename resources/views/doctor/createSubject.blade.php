@extends('doctor.index')

@section('title')
    create subject
@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Subject
                    <small>new</small>
                </h1>

            </section>

            <section class="content">
                
                <form class="form-horizontal" method="POST" onsubmit="return false">
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="subjectName">Subject Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="subjectName" placeholder="Subject Name" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="desc">Description:</label>
                      <div class="col-sm-10">          
                        <input type="text" class="form-control" id="desc" placeholder="description" required>
                      </div>
                    </div>
                    
                    <div class="form-group">        
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" onclick="createSubject()" class="btn btn-default">Create</button>
                      </div>
                    </div>
                  </form>

                
            </section>
            <!-- /.content -->
        </div>
    <!-- /.content-wrapper -->

@endsection