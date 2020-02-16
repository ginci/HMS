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
    if (isset($_POST['submit'])) {
        $response = book_appointment($_POST);
        if ($response === true) {
            $success = "Appointment Sucessfully!";
        }else{
            $errors = $response;
            var_dump($errors);
        }
    }

    // getting all doctors
    $response1 = get_all_patients();
    if ($response1 !== false) {
        $patients = $response1;
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
                                    <h4 class="page-title">Appointment </h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#">Patients</a></li>
                                        <li class="breadcrumb-item active">Book Appointment</li>
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
                        <div class="col-sm-4">
                            <a href="#custom-modal" class="btn btn-custom waves-effect waves-light mb-4" data-animation="fadein" data-plugin="custommodal"
                                data-overlaySpeed="200" data-overlayColor="#36404a"><i class="mdi mdi-plus"></i> Book Appointment</a>
                        </div><!-- end col -->
                        <div class="col-12">
                            <div class="card-box table-responsive">
                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Doctor's Name</th>
                                        <th>Day & Time of Appointment</th>
                                        <th>Doctor's Shift</th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                        <!-- display patients -->
                                        <?php
                                            $response = get_pat_appointments($card_id); 
                                                if ($response !== false) {
                                                    $pat_appts = $response;
                                                }
                                        ?>
                                        <?php if (isset($pat_appts)) {
                                            foreach ($pat_appts as $pat_appt) {
                                                $doctor_id = $pat_appt['doc_id'];
                                                $doctor_fullname= ucfirst($pat_appt['doc_fullname']);
                                                $pat_appts_day = format_db_date($pat_appt['appt_date'])." ".$pat_appt['appt_time'];
                                               
                                                $doctor_shift= ucfirst($pat_appt['shift']);
                                                $doc_spec = $pat_appt['specialization'];
                                        
                                            ?>
                                        <tr>
                                            <td>DR. <?php echo $doctor_fullname; ?></td>
                                            <td><?php echo $pat_appts_day; ?></td>
                                            <td><?php echo $doctor_shift; ?></td>
                                            
                                            
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
                        <h4 class="custom-modal-title">Book Appointment</h4>
                        <div class="custom-modal-text text-left">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
                                <div class="form-group">
                                <?php
                                    $response = get_doc_appoint(); 
                                    if ($response !== false) {
                                        $doctors = $response;
                                    }
                                        ?> 
                                    <label for="position" >Select Doctor</label>
                                    <select class="form-control" required name="doc_id">
                                        <option>Select Doctor</option>
                                        <?php if (isset($doctors)) {
                                            foreach ($doctors as $doctor) {
                                                $doctor_id = $doctor['doc_id'];
                                                $doctor_fullname= ucfirst($doctor['doc_fullname']);
                                                $doc_spec = $doctor['specialization'];
                                               
                                            ?>
                                        <option value="<?php echo $doctor_id; ?>">Dr. <?php echo $doctor_fullname; ?> / <?php echo $doc_spec; ?> </option>
                                        <?php }}?>
                                    </select>
                                </div>

                                <input type="hidden" name="card_id" value="<?php echo $card_id; ?>">

                                <div class="text-right">
                                    <button type="submit" name="submit" class="btn btn-success waves-effect waves-light">Book</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.close();">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                <?php
                    if (isset($success)) {
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () { swal("Cool!","Appointment booked Successfully","success");';
                        echo '}, 100);</script>';
                    }
                ?>
                <?php
                    if (isset($errors)) {
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () { swal ( "Oops" ,  "Appointment Alreday Booked!" ,  "error" )';
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