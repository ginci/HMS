<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>
        <link href="../../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../../plugins/responsive-table/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">
        <!-- Multi Item Selection examples -->
        <link href="../../plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<?php require 'includes/leftbar.php'; ?>
<?php require 'includes/topbar.php'; ?>

                        <ul class="list-inline menu-left mb-0">
                            <li class="float-left">
                                <button class="button-menu-mobile open-leffedt disable-btn">
                                    <i class="dripicons-menu"></i>
                                </button>
                            </li>
                            <li>
                                <div class="page-title-box">
                                    <h4 class="page-title">Medical Profile </h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">Patient</a></li>
                                        <li class="breadcrumb-item active">Profile</li>
                                    </ol>
                                </div>
                            </li>
                        </ul>
                </nav>
                <?php
                    $result = get_all_appointment($card_id);
                    if ($result !== false) {
                        $appointment = $result;
                    }else {
                        $errors = $result;
                    }

                
                ?>
            </div>
            <!-- Top Bar End -->



            <!-- Start Page content -->
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-sm-12">
                            <!-- meta -->
                            <div class="profile-user-box card-box bg-custom">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span class="float-left mr-3"><img src="../<?php echo $patient_image; ?>" alt="" class="thumb-lg rounded-circle"></span>
                                        <div class="media-body text-white">
                                            <h4 class="mt-1 mb-1 font-18"><?php echo $patient_fullname; ?></h4>
                                            <p class="font-13 text-light"> <?php echo $patient_address; ?></p>
                                            <p class="text-light mb-0"><?php echo $patient_phone; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-right">
                                            <button type="button" class="btn btn-danger">
                                            <strong>Status </strong><?php echo $status; ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ meta -->
                        </div>
                    </div>
                    <!-- end row -->


                    <div class="row">
                        <div class="col-xl-3">
                            <!-- Personal-Information -->
                            <div class="card-box">
                                <h4 class="header-title mt-0 m-b-20">Personal Information</h4>
                                <div class="panel-body">
                                    <p class="text-muted font-13">
                                        Hello <?php echo $patient_fullname; ?>, welcome to UNTH Ituku-Ozalla
                                    </p>

                                    <hr/>

                                    <div class="text-left">
                                        <p class="text-muted font-13"><strong>Full Name :</strong> <span class="m-l-15"><?php echo $patient_fullname; ?></span></p>

                                        <p class="text-muted font-13"><strong>Mobile :</strong><span class="m-l-15"><?php echo $patient_phone; ?></span></p>

                                        <p class="text-muted font-13"><strong>Address    :</strong> <span class="m-l-15"><?php echo $patient_address; ?></span></p>

                                        <p class="text-muted font-13"><strong>Patient Age :</strong> <span class="m-l-15"><?php echo $patient_age; ?></span></p>

                                        <p class="text-muted font-13"><strong>Marital Status:</strong> <span class="m-l-15"><?php echo $marital_stat; ?></span></p>

                                        <p class="text-muted font-13"><strong>Next of Kin's Name :</strong> <span class="m-l-15"><?php echo $patient_nok_fullname; ?></span></p>

                                        <p class="text-muted font-13"><strong>Next of Kin's Phone :</strong> <span class="m-l-15"><?php echo $patient_nok_number; ?></span></p>

                                        <p class="text-muted font-13"><strong>Languages :</strong>
                                            <span class="m-l-5">
                                                <span class="flag-icon flag-icon-us m-r-5 m-t-0" title="us"></span>
                                                <span>English</span>
                                            </span>
                                            <span class="m-l-5">
                                                <span class="flag-icon flag-icon-de m-r-5" title="de"></span>
                                                <span>German</span>
                                            </span>
                                            <span class="m-l-5">
                                                <span class="flag-icon flag-icon-es m-r-5" title="es"></span>
                                                <span>Spanish</span>
                                            </span>
                                            <span class="m-l-5">
                                                <span class="flag-icon flag-icon-fr m-r-5" title="fr"></span>
                                                <span>French</span>
                                            </span>
                                        </p>

                                    </div>

                                    <ul class="social-links list-inline m-t-20 m-b-0">
                                        <li class="list-inline-item">
                                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fa fa-skype"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Personal-Information -->

                            <

                        </div>


                        <div class="col-xl-9">

                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="card-box tilebox-one">
                                        <i class="icon-layers float-right text-muted"></i>
                                        <h6 class="text-muted text-uppercase mt-0">Blood Group</h6>
                                        <h2 class="m-b-20" data-plugin="counterup">1,587</h2>
                                       
                                    </div>
                                </div><!-- end col -->

                                <div class="col-sm-4">
                                    <div class="card-box tilebox-one">
                                        <i class="icon-paypal float-right text-muted"></i>
                                        <h6 class="text-muted text-uppercase mt-0">Hepatitis B</h6>
                                        <h2 class="m-b-20">$<span data-plugin="counterup">46,782</span></h2>
                                        
                                    </div>
                                </div><!-- end col -->

                                <div class="col-sm-4">
                                    <div class="card-box tilebox-one">
                                        <i class="icon-rocket float-right text-muted"></i>
                                        <h6 class="text-muted text-uppercase mt-0">Hepatitis C</h6>
                                        <h2 class="m-b-20" data-plugin="counterup">1,890</h2>
                                        
                                    </div>
                                </div><!-- end col -->

                            </div>
                            <!-- end row -->


                            
                            <div class="card-box">
                                <h4 class="header-title mb-3">Follow Up Visits</h4>

                                <div class="table-rep-plugin">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="tech-companies-1" class="table table-bordered  table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Doctor</th>
                                                    <th>BP</th>
                                                    <th>weight</th>
                                                    <th>Pulse Rate</th>
                                                    <th>Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- display patients -->
                                            <?php if (isset($appointment)) {
                                                foreach ($appointment as $appointment) {
                                                    $patient_fullname = ucfirst($appointment["patient_name"]);
                                                    $appointment_date = $appointment['visit_date'];
                                                    $patient_pulse = $appointment['pulse_rate'];
                                                    $patient_weight = $appointment['weight'];
                                                    $patient_report = $appointment['report'];
                                                    $patient_bp = $appointment['bldpressure'];
                                                    $doc_id = $appointment['doc_id'];
                                                    $doctor = get_doctor_name($doc_id);
                                                    $doctor = explode(" ", $doctor);
                                                    $docfname = $doctor[0];

                                            ?>
                                            <tr>
                                                <td><?php echo $appointment_date; ?></td>
                                                <td>Dr. <?php echo $docfname; ?></td>
                                                <td><?php echo $patient_bp; ?></td>
                                                <td><?php echo $patient_weight; ?></td>
                                                <td><?php echo $patient_pulse; ?></td>
                                                <td><?php echo $patient_report; ?></td>
                                            </tr>
                                                <?php } }?>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end col -->
                        

                    </div>
                    <!-- end row -->

        <?php require 'includes/footer_start.php' ?>
        
        <!-- Counter Up  -->
        <script src="../plugins/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="../plugins/counterup/jquery.counterup.min.js"></script>

        <?php require 'includes/footer_end.php' ?>