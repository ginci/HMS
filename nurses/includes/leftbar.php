    <?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end_dark.php'; ?>  
    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">

                <div class="slimscroll-menu" id="remove-scroll">
                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="index.php" class="logo">
                            <span>
                                  <img src="../assets/images/logo.jpg" alt="" width="190" height="70">
                            </span>
                            <i>
                                <img src="../assets/images/logo_sm.png" alt="" height="28">
                            </i>
                        </a>
                    </div>
                    <!-- User box -->
                    <div class="user-box">
                        <div class="user-img">
                            <img src="../<?php echo $nurse_image; ?>" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                        </div>
                        <h5><a href="#"><?php echo $nurse_fullname; ?></a> </h5>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <!--<li class="menu-title">Navigation</li>-->

                            <li>
                                <a href="index.php">
                                    <i class="fi-air-play"></i><span class="badge badge-danger badge-pill pull-right">7</span> <span> Dashboard </span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);"><i class="fi-paper-stack"></i><span> Doctors </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="view_doc.php">View Doctors</a></li>
                                    <li><a href="view_appoint.php">View Appointments</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);"><i class="fi-paper-stack"></i><span> Patients</span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="pat_register.php">View Patients Register</a></li>
                                </ul>
                            </li>
                            
                        </ul>

                    </div>
                    <!-- Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                <!-- Top Bar Start -->
                <div class="topbar">

                    <nav class="navbar-custom">