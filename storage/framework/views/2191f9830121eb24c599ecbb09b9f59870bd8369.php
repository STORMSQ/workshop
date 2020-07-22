<!DOCTYPE html>
<html class="no-js">
    
    <head>
        <title>Admin Home Page</title>
        <!-- Bootstrap -->
        <?php echo $__env->make('ui.tops', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </head>
    
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Admin Panel</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> Vincent Gabriel <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Profile</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="login.html">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        

                         <li class="<?php echo e((strstr(Request::path(),'project'))?'active':''); ?>">
                            <a href="<?php echo e(route('project_home')); ?>"><i class="icon-chevron-right"></i> 報名管理</a>
                        </li>
                        <li class="<?php echo e((strstr(Request::path(),'users'))?'active':''); ?>">
                            <a href="calendar.html"><i class="icon-chevron-right"></i> 管理員帳號管理</a>
                        </li>

                    </ul>
                </div>
                
                <!--/span-->
                <div class="span9" id="content">
                    <div class="row-fluid">
                        <!--<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Success</h4>
                        	The operation completed successfully
                        </div>-->
                        	<div class="navbar">
                            	<div class="navbar-inner">
	                                <ul class="breadcrumb">
	                                    <i class="icon-chevron-left hide-sidebar"><a href='#' title="Hide Sidebar" rel='tooltip'>&nbsp;</a></i>
	                                    <i class="icon-chevron-right show-sidebar" style="display:none;"><a href='#' title="Show Sidebar" rel='tooltip'>&nbsp;</a></i>
	                                    <?php $__env->startSection('navi'); ?>
	                                    <li class="active">首頁</li>
                                        <?php echo $__env->yieldSection(); ?>
	                                </ul>
                            	</div>
                        	</div>
                    	</div>
                    <div class="row-fluid">

                        <!-- /block -->
                    </div>
                    <div class="row-fluid">
                        <?php $__env->startSection('content'); ?>

                        <?php echo $__env->yieldSection(); ?>
                    </div>
 

                </div>
            </div>
            <hr>
            <footer>
                <p>&copy; Vincent Gabriel 2013</p>
            </footer>
        </div>
        <!--/.fluid-container-->
        <?php echo $__env->make('ui.bottoms', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php $__env->startSection('jquery'); ?>

        <?php echo $__env->yieldSection(); ?>
    </body>

</html>