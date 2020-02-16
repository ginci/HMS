<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>
    <!-- DataTables -->
    <link href="../../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Multi Item Selection examples -->
        <link href="../../plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />


<?php
    $results = get_pat_appointment();
    if ($results !== false) {
        $appointment = $results;
    }else {
        $errors = $results;
    }
if (isset($_POST['card_id'])) {
    $card_id = $_POST['card_id'];
   
    $result = get_patient('patients', 'card_id', $card_id);
   if ($result) {
       $patient = $result;
       $patient_fullname = ucfirst($patient['fullname']);
       $patient_image = $patient['image'];
       $patient_phone = $patient['phone'];
       $patient_hus_number = $patient['hus_phone'];
       $patient_ant_number = $patient['ant_number'];
       $patient_address = $patient['address'];
       $patient_age = $patient['age'];
       $patient_hus_fullname = $patient['hus_fullname'];
       $patient_date_enroll = $patient['date_enroll'];
       $patient_edd_date = $patient['edd_date'];
       $patient_lmp_date = $patient['lmp_date'];
       $patient_lmp_date = format_date2($patient_lmp_date);
       $patient_edd_date = format_date2($patient_edd_date);
       $patient_id = $patient['pat_id'];
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
                    <div class="col-12">
                            <div class="card-box table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Pat. Name</th>
                                        <th>Folder Number</th>
                                        <th>Doctor</th>
                                        <th>BP</th>
                                        <th>Phone</th>
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
                                            $patient_bp = $appointment['bldpressure'];
                                            $card_id = $appointment['card_id'];
                                            $patient_phone = $appointment['phone'];
                                            $pulse_rate = $appointment['pulse_rate'];
                                            $patient_report = $appointment['report'];
                                            $doc_id = $appointment['doc_id'];
                                            $doctor = get_doctor_name($doc_id);
                                            $doctor = explode(" ", $doctor);
                                            $docfname = $doctor[0];

                                    ?>
                                    <tr>
                                        <td><?php echo $appointment_date; ?></td>
                                        <td><?php echo $patient_fullname; ?></td>
                                        <td><?php echo $card_id; ?></td>
                                        <td>Dr. <?php echo $docfname; ?></td>
                                        <td><?php echo $patient_bp; ?></td>
                                        <td><?php echo $patient_phone; ?></td>
                                        <td><?php echo $pulse_rate; ?></td>
                                        
                                        <td><?php echo $patient_report; ?></td>
                                    </tr>
                                        <?php } } ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <!-- Modal -->
                    <div id="custom-modal" class="modal-demo">
                            <button type="button" class="close" onclick="Custombox.close();">
                                <span>&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h4 class="custom-modal-title">Add Report</h4>
                            <div class="custom-modal-text text-left">
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
                                    <div class="form-group">
                                        <label for="name">Heoght of Fundus</label>
                                        <input type="text" name="height_fundus" required class="form-control" id="name" placeholder="Enter Heoght of Fundus">
                                    </div>
                                    <div class="form-group">
                                        <label for="position">Report</label>
                                        <textarea placeholder="Enter Report" name="report" class="form-control" rows="2"></textarea>
                                    </div>
                                    <input type="hidden" name="ant_number" value="<?php echo $ant_number; ?>">
                                    <input type="hidden" name="doc_id" value="<?php echo $doc_id; ?>">
                                    
                                    <div class="text-right">
                                        <button type="submit" name="doc_report" class="btn btn-success waves-effect waves-light">Save</button>
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