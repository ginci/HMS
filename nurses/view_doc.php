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
            <h4 class="page-title">View Doctors </h4>
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

    <!-- end row -->
    <div class="row">
        <!-- display Doctors -->
       
        <div class="col-lg-12" style="padding-bottom: ">
                <div class="card product_item_list">
                    <div class="body table-responsive">
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
                                    foreach ($doctors as $doctor) {
                                    $doc_name = ucfirst($doctor['doc_fullname']);
                                    $doc_image = $doctor['image'];
                                    $spec = $doctor['specialization'];
                                    $qual = strtoupper($doctor['qualification']); 
                                    $days = strtoupper($doctor['day_1'].' &'.$doctor['day_2']);
                                    $shift = strtoupper($doctor['shift']);
                                    $doc_id = $doctor['doc_id'];
                                    $count++;
                                    ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><img src="../<?php echo $doc_image ?>" width="48" alt="Product img"></td>
                                    <td><h5><?php echo  $doc_name; ?></h5></td>
                                    <td><span class="text-muted"><?php echo $spec;?></span></td>
                                    <td><?php echo $qual; ?></td>
                                    <td><span  class="text-muted"> <?php echo $days. " / " .$shift; ?></span></td>
                                    <td>
                                      <!--   <a href="options.php?doc_id=<?php echo $doc_id; ?>" class="btn btn-default waves-effect waves-float waves-green"><i class="dripicons-pencil"></i></a>
                                        <a href="options.php?doc_id=<?php echo $doc_id; ?>" class="btn btn-default waves-effect waves-float waves-red"><i class="dripicons-preview"></i></a> -->
                                    </td>
                                </tr>
                               <?php }} ?>
                            </tbody>
                        </table>
                    </div>        
                </div>
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
       <!-- /.modal -->
       
        <!-- Modal -->

        
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