<?php require 'includes/header_start.php'; ?>

        <!-- DataTables -->
        <link href="../../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Multi Item Selection examples -->
        <link href="../../plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<?php require 'includes/header_end.php'; ?>
<?php
    
    // getting all doctors
    $response1 = get_doctor_appointment($doc_id);
    if ($response1 !== false) {
        $appoints = $response1;
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
                                    <h4 class="page-title">Appointments </h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#">Patients</a></li>
                                        <li class="breadcrumb-item active">View Appointments</li>
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
                        
                        <div class="col-12">
                            <div class="card-box table-responsive">
                                <div class="card-title">
                                    <h1>Today's Appointments</h1>
                                </div>
                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Ant Number</th>
                                        <th>Patient Name</th>
                                        <th>Phone</th>
                                        <th>Doctor</th>
                                        <th>Action</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                        <!-- display patients -->
                                        <?php if (isset($appoints)) {
                                            $count = 0;
                                            foreach ($appoints as $appoint) {
                                                $patient_fullname = ucfirst($appoint['fullname']);
                                                $doctor_fullname = ucfirst($appoint['doc_fullname']);
                                                $appoint_phone = $appoint['phone'];
                                                $card_id = $appoint['card_id'];
                                                $appoint_id = $appoint['appoint_id'];
                                                $appoint_status = $appoint['status'];
                                                $count = $count+1;
                                                
                                
                                            ?>
                                        <tr>
    
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $card_id; ?></td>
                                            <td><?php echo $patient_fullname; ?></td>
                                            <td><?php echo $appoint_phone; ?></td>
                                            <td><?php echo $doctor_fullname; ?></td>
                                            <td>

                                                <form method="POST" action="patient_profile.php">
                                                    <input type="hidden" value="<?php echo "$patient_fullname"; ?>" name="patient_name">
                                                    <input type="hidden" value="<?php echo "$nurse_fullname"; ?>" name="nurse_name">
                                                    <input type="hidden" value="<?php echo "$card_id"; ?>" name="card_id">
                                                   
                                                    <button type="submit" class="btn btn-danger" name="submit">Profile</button>
                                                </form>
                                            </td>
                                            <td>
                                                <?php if ($appoint_status == 1) { ?>
                                                <div class="btn btn-success">Seen</div>
                                                <?php }?>
                                                <?php if ($appoint_status == 0) { ?>
                                                    <div class="btn btn-danger">Not Seen</div>
                                                <?php }?>
                                                
                                            </td>
                                        </tr>
                                        <?php } } ?>
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <!-- Modal -->
                    

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

        <!-- Required datatable js -->
        <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../../plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="../../plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="../../plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="../../plugins/datatables/jszip.min.js"></script>
        <script src="../../plugins/datatables/pdfmake.min.js"></script>
        <script src="../../plugins/datatables/vfs_fonts.js"></script>
        <script src="../../plugins/datatables/buttons.html5.min.js"></script>
        <script src="../../plugins/datatables/buttons.print.min.js"></script>

        <!-- Key Tables -->
        <script src="../../plugins/datatables/dataTables.keyTable.min.js"></script>

        <!-- Responsive examples -->
        <script src="../../plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="../../plugins/datatables/responsive.bootstrap4.min.js"></script>

        <!-- Selection table -->
        <script src="../../plugins/datatables/dataTables.select.min.js"></script>

        <script>
            $(document).ready(function() {

                // Default Datatable
                $('#datatable').DataTable();

                //Buttons examples
                var table = $('#datatable-buttons').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf']
                });

                // Key Tables

                $('#key-table').DataTable({
                    keys: true
                });

                // Responsive Datatable
                $('#responsive-datatable').DataTable();

                // Multi Selection Datatable
                $('#selection-datatable').DataTable({
                    select: {
                        style: 'multi'
                    }
                });

                table.buttons().container()
                        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            } );

        </script>


        <?php require 'includes/footer_end.php' ?>