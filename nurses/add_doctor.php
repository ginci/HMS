
<?php require 'includes/header_start.php'; ?>

      
<?php require 'includes/header_end.php'; ?>
<?php
    if (isset($_POST['submit'])) {
        $response = add_doctor($_POST, $_FILES['doc_image']);
        if ($response === true) {
            $success = "Staff added Sucessfully!";
        }else{
            $errors = $response;
            var_dump($errors);
        }
    }

    // getting all doctors
    $response1 = get_all_doctors();
    if ($response1 !== false) {
        $doctors = $response1;
    }

?>

<?php require 'includes/leftbar.php'; ?>
<?php require 'includes/topbar.php'; ?>

                        <ul class="list-inline menu-left mb-0">
                            <li class="float-left">
                                <button class="button-menu-mobile open-left disable-btn">
                                    <i class="dripicons-menu"></i>
                                </button>
                            </li>
                            <li>
                                <div class="page-title-box">
                                    <h4 class="page-title">Doctors </h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#">Doctors</a></li>
                                        <li class="breadcrumb-item active">View Doctors</li>
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
                            
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->


                        <div class="row">
                            <!-- display Doctors -->
                            <?php if (isset($doctors)) {
                                foreach ($doctors as $doctor) {
                                    $doctor_fullname = ucfirst($doctor['doc_fullname']);
                                    $doctor_image = $doctor['image'];
                                    $doctor_phone = $doctor['phone'];
                                    $doctor_id = $doctor['doc_id'];
                                    $day1 = $doctor['day1'];
                                    $day1_session = $doctor['day1_session'];
                                    $day2 = $doctor['day2'];
                                    $day2_session = $doctor['day2_session'];
                                    
                                ?>

                            <div class="col-lg-4">
                                <div class="text-center card-box">

                                    <div class="member-card pt-2 pb-2">
                                        <div class="thumb-lg member-thumb m-b-10 mx-auto">
                                            <img src="../<?Php echo $doctor_image; ?>" class="rounded-circle img-thumbnail" alt="profile-image">
                                        </div>

                                        <div class="">
                                            <h4 class="m-b-5">Dr. <?Php echo $doctor_fullname; ?></h4>
                                            <p class="text-muted">Phone <span> | </span> <span> <a href="#" class="text-pink"><?Php echo $doctor_phone; ?></a> </span></p>
                                        </div>

                                        <ul class="social-links list-inline m-t-20">
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

                                        <button type="button" class="btn btn-primary m-t-20 btn-rounded btn-bordered waves-effect w-md waves-light">Working Days</button>

                                        <div class="mt-4">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mt-3">
                                                        <h4 class="m-b-5"><?Php echo $day1; ?></h4>
                                                        <p class="mb-0 text-muted"><?Php echo $day1_session; ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                <div class="mt-3">
                                                        <h4 class="m-b-5"><?Php echo $day2; ?></h4>
                                                        <p class="mb-0 text-muted"><?Php echo $day2_session; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div> <!-- end col -->

                                <?php } } ?>

                            
                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    <ul class="pagination pagination-split mt-0 float-right">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">«</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span aria-hidden="true">»</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                       
                <!-- sweet alert -->
                <?php
                    if (isset($success)) {
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () { swal("Cool!","Successfull","success");';
                        echo '}, 100);</script>';
                    }
                ?>
                <?php
                    if (isset($errors)) {
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () { swal ( "Oops" ,  "Something went wrong!" ,  "error" )';
                        echo '}, 100);</script>';
                    }
                ?>

                    

        <?php require 'includes/footer_start.php' ?>

        
        
        <?php require 'includes/footer_end.php' ?>