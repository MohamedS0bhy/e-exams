<?php
/**
 * Created by PhpStorm.
 * User: msobhy
 * Date: 4/6/18
 * Time: 11:11 PM
 */
 JWTAuth::setToken($_COOKIE['token']);
$user = JWTAuth::toUser();
?>
@extends('layouts.master')

@section('title')
	title
@endsection

@section('logo')

	<!-- Logo -->
	<a href="{{url('/')}}" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini">E E</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg">E-exmas</span>
	</a>

@endsection

@section('header-nav')

	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

				<!-- User Account Menu -->
				<li class="dropdown user user-menu">
					<!-- Menu Toggle Button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!-- The user image in the navbar-->
						<img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
						<!-- hidden-xs hides the username on small devices so only the image appears. -->
						<span class="hidden-xs">{{ $user->username }}</span>
					</a>
					<ul class="dropdown-menu">
						<!-- The user image in the menu -->
						<li class="user-header">
							<img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">

							<p>
								{{ $user->username }}
							</p>
						</li>
						<!-- Menu Body -->
						<li class="user-body">
							<div class="row">
								<div class="col-xs-4 text-center">
									{{-- <a href="#">here</a> --}}
								</div>
								<div class="col-xs-4 text-center">
									{{-- <a href="#">here</a> --}}
								</div>
								<div class="col-xs-4 text-center">
									{{-- <a href="#">here</a> --}}
								</div>
							</div>
							<!-- /.row -->
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<a href="{{ url('/profile') }}" class="btn btn-default btn-flat">Profile</a>
							</div>
							<div class="pull-right">
								{{--  {{ route('logout') }}  --}}
								<a class="dropdown-item btn btn-default btn-flat" href="#"
									onclick="event.preventDefault();logout()">
										{{ __('Logout') }}
									</a>

									<form id="logout-form" action="#" method="POST" style="display: none;">
										@csrf
									</form>
							</div>
						</li>
					</ul>
				</li>

			</ul>
		</div>
	</nav>

@endsection

@section('sidebar')
	<aside class="main-sidebar">
	    <!-- sidebar: style can be found in sidebar.less -->
	    <section class="sidebar">

	        <!-- Sidebar user panel (optional) -->
	        <div class="user-panel">
	            <div class="pull-left image">
	                <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
	            </div>
	            <div class="pull-left info">
	                <p>{{ $user->username }}</p>
	                {{-- <!-- Status -->
	                <a href="#"><i class="fa fa-circle text-success"></i> Online</a> --}}
	            </div>
	        </div>

	        {{-- <!-- search form (Optional) -->
	        <form action="#" method="get" class="sidebar-form">
	            <div class="input-group">
	                <input type="text" name="q" class="form-control" placeholder="Search...">
	                <span class="input-group-btn">
	                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
	                </button>
	            </span>
	            </div>
	        </form>
	        <!-- /.search form --> --}}
	       
	        <!-- Sidebar Menu -->
	        <ul class="sidebar-menu" data-widget="tree">

	            <li>
	                <a href="#">
	                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
	                </a>
	            </li>
	            <li>
	                <a href="#">
	                    <i class="ion ion-ios-settings-strong"></i> <span>Settings</span>
	                </a>
	            </li>
	    
	            <li class="treeview">
	                <a href="#"><i class="fa fa-list"></i> <span>Reports</span>
	                    <span class="pull-right-container">
	                    <i class="fa fa-angle-left pull-right"></i>
	                </span>
	                </a>
	                <ul class="treeview-menu">
	                    <li><a href="#">Sales Report</a></li>
	           
	                </ul>
	            </li>
	        </ul>
	        <!-- /.sidebar-menu -->
	    </section>
	</aside>
	<!-- /.sidebar -->
@endsection

@section('content')
	<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    	<!-- Main content -->
    	<!-- Content Header (Page header) -->
		<section class="content-header">
		    <h1>
		        page
		        <small>tag</small>
		    </h1>

		</section>

        <section class="content">
    		Admin 
    	</section>
        <!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
@endsection