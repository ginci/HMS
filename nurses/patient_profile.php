<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>
    <link href="../../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/responsive-table/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">
    <!-- Multi Item Selection examples -->
    <link href="../../plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />


<?php

if (isset($_POST['card_id'])) {
    $card_id = $_POST['card_id'];
    $vitals = get_vitals($card_id);
    $results = get_all_appointment($card_id);
    if ($results !== false) {
        $appointment = $results;
    }else {
        $errors = $results;
    }
    if ($vitals !== false) {
             $pat_vitals = $vitals;
         }else{
             $errors = $pat_vitals;
         }
}
    $result = get_patient('patients', 'card_id', $card_id);
   if ($result) {
       $patient = $result;
       $patient_fullname = ucfirst($patient['fullname']);
       $patient_image = $patient['image'];
       $patient_phone = $patient['phone'];
       $patient_nok_number = $patient['nok_phone'];
       $patient_card_id = $patient['card_id'];
       $patient_address = $patient['address'];
       $patient_age = $patient['age'];
       $patient_nok_fullname = $patient['nok_name'];
       $patient_date_enroll = $patient['date_enroll'];
       $marital_status = $patient['marital_status'];
       $patient_status = $patient['status'];
   }

   if (isset($_POST['doc_report'])) {
    $response = doc_report($_POST);
    if ($response === true) {
        $success = "Sucessfully!";
    }else{
        $errors = $response;
        var_dump($errors);
    }
}

if (isset($_POST['submit_vitals'])) {
$response = add_vitals($_POST);
if ($response === true) {
$success = "Vitals added Sucessfully!";
}else{
$errors = $response;
var_dump($errors);
}
} 

?>
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
                                        <a href="#custom-modal" class="btn btn-danger waves-effect waves-light mb-4" data-animation="fadein" data-plugin="custommodal"
                                   data-overlaySpeed="200" data-overlayColor="#36404a"><i class="mdi mdi-plus"></i>Take Vitals</a>
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
                                        <p class="text-muted font-13"><strong>Folder ID:</strong> <span class="m-l-15"><?php echo $patient_card_id; ?></span></p>

                                        <p class="text-muted font-13"><strong>Full Name :</strong> <span class="m-l-15"><?php echo $patient_fullname; ?></span></p>

                                        <p class="text-muted font-13"><strong>Mobile :</strong><span class="m-l-15"><?php echo $patient_phone; ?></span></p>

                                        <p class="text-muted font-13"><strong>Address    :</strong> <span class="m-l-15"><?php echo $patient_address; ?></span></p>

                                        <p class="text-muted font-13"><strong>Patient Age :</strong> <span class="m-l-15"><?php echo $patient_age; ?></span></p>

                                        <p class="text-muted font-13"><strong>Maritals Status :</strong> <span class="m-l-15"><?php echo $marital_status; ?></span></p>

                                        <p class="text-muted font-13"><strong>Next of Kin Name :</strong> <span class="m-l-15"><?php echo $patient_nok_fullname; ?></span></p>

                                        <p class="text-muted font-13"><strong>Next of Kin Phone :</strong> <span class="m-l-15"><?php echo $patient_nok_number; ?></span></p>

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


                                <!-- Vitals -->
                                <div class="card-box">
                                    <h4 class="header-title mb-3">Vitals</h4>

                                    <div class="table-rep-plugin">
                                        <div class="table-responsive" data-pattern="priority-columns">
                                            <table id="tech-companies-1" class="table table-bordered  table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Blood Pressure</th>
                                                        <th>Pulse rate</th>
                                                        <th>Weight</th>
                                                        <th>Height</th>
                                                        <th>Temperature</th>
                                                        <th>Day/Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (isset($vitals)) {
                                                    foreach($vitals as $vital) {
                                                       $bloodpressure = $vital['bldpressure'];
                                                       $weight = $vital['weight'];
                                                       $height = $vital['height'];
                                                       $temp = $vital['temperature'];
                                                       $pulserate = $vital['pulse_rate'];
                                                       $date = $vital['time'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $bloodpressure; ?></td>
                                                    <td><?php echo $pulserate; ?></td>
                                                    <td><?php echo $weight; ?></td>
                                                    <td><?php echo $height; ?></td>
                                                    <td><?php echo $temp; ?></td>
                                                    <td><?php echo $date; ?></td>
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
                    <!-- Modal -->
                     <div id="custom-modal" class="modal-demo text-left">
            <button type="button" class="close" onclick="Custombox.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="custom-modal-title">Patient's Vitals</h4>
            <div class="custom-modal-text">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label for="name">Blood Pressure</label>
                            <input type="text" name="bldpressure" required class="form-control" id="bloodpressure" placeholder="Enter Blood Pressure">
                        </div>
                         <div class="col-sm-4 form-group">
                            <label for="name">Pulse Rate</label>
                            <input type="text" name="pulse_rate" required class="form-control"  placeholder="Enter Pulse Rate">
                        </div>
                         <div class="col-sm-4 form-group">
                            <label for="name">Temperature</label>
                            <input type="text" name="temperature" required class="form-control" id="Temperature" placeholder="Enter Temperature">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="name">Weight</label>
                            <input type="number" name="weight" required class="form-control" id="weight " placeholder="Enter Weight">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="name">Height</label>
                            <input type="text" name="height" required class="form-control" id="height" placeholder="Enter Height">
                            <input type="hidden" name="card_id" value="<?php echo $card_id; ?>" required class="form-control" id=" card_id" placeholder="Enter Card ID">
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" name="submit_vitals" class="btn btn-success waves-effect waves-light">Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.close();">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
                        <?php
                            if (isset($success)) {
                                echo '<script type="text/javascript">';
                                echo 'setTimeout(function () { swal("Cool!","Report Successfully","success");';
                                echo '}, 100);</script>';
                            }
                        ?>
                        <!-- <?php
                            if (isset($errors)) {
                                echo '<script type="text/javascript">';
                                echo 'setTimeout(function () { swal ( "Oops" ,  "Something went wrong!" ,  "error" )';
                                echo '}, 100);</script>';
                            }
                        ?> -->


        <?php require 'includes/footer_start.php' ?>
        
        <!-- Counter Up  -->
        <script src="../plugins/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="../plugins/counterup/jquery.counterup.min.js"></script>

        <?php require 'includes/footer_end.php' ?>