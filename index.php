<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>

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
                                    <h4 class="page-title">Dashboard </h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item active">Welcome to AntenantalCare Parklane admin panel !</li>
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
                            <div class="card-box">
                                <h4 class="header-title mb-4">UNTH Ituku-Ozalla Overview</h4>

                                <div class="row">
                                    <div class="col-sm-6 col-lg-6 col-xl-3">
                                        <div class="card-box mb-0 widget-chart-two">
                                            <div class="float-right">
                                                <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round
                                                        data-fgColor="#0acf97" value="60" data-skin="tron" data-angleOffset="180"
                                                        data-readOnly=true data-thickness=".1"/>
                                            </div>
                                            <div class="widget-chart-two-content">
                                                <p class="text-muted mb-0 mt-2">Total Patients</p>
                                                <h3 class="">60</h3>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6 col-xl-3">
                                        <div class="card-box mb-0 widget-chart-two">
                                            <div class="float-right">
                                                <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round
                                                        data-fgColor="#f9bc0b" value="20" data-skin="tron" data-angleOffset="180"
                                                        data-readOnly=true data-thickness=".1"/>
                                            </div>
                                            <div class="widget-chart-two-content">
                                                <p class="text-muted mb-0 mt-2">Current Patients</p>
                                                <h3 class="">20</h3>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6 col-xl-3">
                                        <div class="card-box mb-0 widget-chart-two">
                                            <div class="float-right">
                                                <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round
                                                        data-fgColor="#f1556c" value="14" data-skin="tron" data-angleOffset="180"
                                                        data-readOnly=true data-thickness=".1"/>
                                            </div>
                                            <div class="widget-chart-two-content">
                                                <p class="text-muted mb-0 mt-2">Due Patients</p>
                                                <h3 class="">14</h3>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6 col-xl-3">
                                        <div class="card-box mb-0 widget-chart-two">
                                            <div class="float-right">
                                                <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round
                                                        data-fgColor="#2d7bf4" value="3" data-skin="tron" data-angleOffset="180"
                                                        data-readOnly=true data-thickness=".1"/>
                                            </div>
                                            <div class="widget-chart-two-content">
                                                <p class="text-muted mb-0 mt-2">Numbers of Doctors</p>
                                                <h3 class=""><?php echo $_SESSION['count'] ; ?></h3>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


<?php $result= get_doc_appoint();
        $doctors = $result;
 ?>
                    <div class="col-lg-12" style="padding-bottom: ">
                <div class="card product_item_list">
                    <div class="body table-responsive">
                        <h3>Doctors On Duty</h3>
                        <table class="table table-hover m-b-0">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th data-breakpoints="sm xs">Specilization</th>
                                    <th data-breakpoints="sm xs">Qualification</th>
                                    <th data-breakpoints="sm xs">Day/Time</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                                 <?php if (isset($doctors)) {
                                    $count = 0;
                                    $_SESSION['count'] =  $count;
                                    foreach ($doctors as $doctor) {
                                    $doc_name = ucfirst($doctor['doc_fullname']);
                                    $doc_image = $doctor['image'];
                                    $spec = $doctor['specialization'];
                                    $qual = strtoupper($doctor['qualification']); 
                                    $days = strtoupper($doctor['day_1'].' &'.$doctor['day_2']);
                                    $shift = strtoupper($doctor['shift']);
                                    $doc_id = $doctor['doc_id'];
                                    $count++;
                                    $_SESSION['count'] =  $count;
                                    ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><img src="<?php echo $doc_image ?>" width="48" alt="Product img"></td>
                                    <td><h5><?php echo  $doc_name; ?></h5></td>
                                    <td><span class="text-muted"><?php echo $spec;?></span></td>
                                    <td><?php echo $qual; ?></td>
                                    <td><span  class="text-muted"> <?php echo $days. " / " .$shift; ?></span></td>
                                    <td>
                                                                           
                                    </td>
                                </tr>
                               <?php }} ?>
                            </tbody>
                        </table>
                    </div>        
                </div>
            </div>
                    <!-- end row -->


                    
        <?php require 'includes/footer_start.php' ?>
        <!-- Flot chart -->
        <script src="../plugins/flot-chart/jquery.flot.min.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.time.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.tooltip.min.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.resize.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.pie.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.crosshair.js"></script>
        <script src="../plugins/flot-chart/curvedLines.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.axislabels.js"></script>

        <!-- KNOB JS -->
        <!--[if IE]>
        <script type="text/javascript" src="assets/plugins/jquery-knob/excanvas.js"></script>
        <![endif]-->
        <script src="../plugins/jquery-knob/jquery.knob.js"></script>

        <!-- Dashboard Init -->
        <script src="assets/pages/jquery.dashboard.init.js"></script>

        <?php require 'includes/footer_end.php' ?>