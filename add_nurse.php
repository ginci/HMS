<?php require 'includes/header_start.php'; ?>
<?php require 'includes/header_end.php'; ?>
<?php
if (isset($_POST['submit'])) {
$response = add_nurses($_POST, $_FILES['doc_image']);
if ($response === true) {
$success = "Staff added Sucessfully!";
}else{
$errors = $response;
var_dump($errors);
}
}
// getting all nurse
$response1 = get_all_nurses();
if ($response1 !== false) {
    $nurses = $response1;
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
            <h4 class="page-title">Add nurses </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Nurses</a></li>
                <li class="breadcrumb-item active">Add nurses</li>
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
    <div class="col-sm-4" style="padding-bottom: 20px;">
         <button type="button" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg" ><i class="mdi mdi-plus"></i> Add Nurse</button>
    </div><!-- end col -->
</div>
    <!-- end row -->
    <div class="row">
        <!-- display nurses -->
       
        <div class="col-lg-12" style="padding-bottom: ">
                <div class="card product_item_list">
                    <div class="body table-responsive">
                        <table class="table table-hover m-b-0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th data-breakpoints="sm xs">Qualification</th>
                                    <th data-breakpoints="sm xs">Shift</th>
                                    <th data-breakpoints="sm xs">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php if (isset($nurses)) {
                                    foreach ($nurses as $nurse) {
                                    $nur_name = ucfirst($nurse['name']);
                                    $nur_image = $nurse['image'];
                                    $qual = strtoupper($nurse['qualification']); 
                                    $nur_id = $nurse['nurse_id'];
                                    $shift = strtoupper($nurse['shift']);
                                    ?>
                                <tr>
                                    <td><img src="<?php echo $nur_image ?>" width="48" alt="Product img"></td>
                                    <td><h5><?php echo  $nur_name; ?></h5></td>
                                    <td><?php echo $qual; ?></td>
                                    <td><span  class=""> <?php echo $shift; ?></span></td>
                                    <td>
                                        <a href="options.php?delete_nur=<?php echo $nur_id; ?>" class="btn btn-default waves-effect waves-float waves-red"><i class="dripicons-trash"></i></a>
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
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myLargeModalLabel">Add nurse</h4>
                    </div>
                    <div class="modal-body">
                     <div class="custom-modal-text text-left">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label for="name">First name</label>
                            <input type="text" name="fname" required class="form-control" id="name" placeholder="Enter First name">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label for="name">Last name</label>
                            <input type="text" name="lname" required class="form-control" id="mobile" placeholder="Enter last name">
                        </div>
                         <div class="col-sm-4 form-group">
                            <label for="name">Phone Number</label>
                            <input type="text" name="phone" required class="form-control" id="mobile" placeholder="Enter Phone Mobile">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label for="name">Address</label>
                            <input type="text" name="address" required class="form-control" id="Address" placeholder="Enter Home Address">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label for="name">Age</label>
                            <input type="number" name="age" required class="form-control" id="age " placeholder="Enter Age">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label for="name">Email</label>
                            <input type="email" name="email" required class="form-control" id="email" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label for="position">State</label>
                            <select class="form-control" name="state" id="ostate">
                                <option selected>Select state of Origin</option>
                                <option value="Abuja FCT">Abuja FCT</option>
                                <option value="Abia">Abia</option>
                                <option value="Adamawa">Adamawa</option>
                                <option value="Akwa Ibom">Akwa Ibom</option>
                                <option value="Anambra">Anambra</option>
                                <option value="Bauchi">Bauchi</option>
                                <option value="Bayelsa">Bayelsa</option>
                                <option value="Benue">Benue</option>
                                <option value="Borno">Borno</option>
                                <option value="Cross River">Cross River</option>
                                <option value="Delta">Delta</option>
                                <option value="Ebonyi">Ebonyi</option>
                                <option value="Edo">Edo</option>
                                <option value="Ekiti">Ekiti</option>
                                <option value="Enugu">Enugu</option>
                                <option value="Gombe">Gombe</option>
                                <option value="Imo">Imo</option>
                                <option value="Jigawa">Jigawa</option>
                                <option value="Kaduna">Kaduna</option>
                                <option value="Kano">Kano</option>
                                <option value="Katsina">Katsina</option>
                                <option value="Kebbi">Kebbi</option>
                                <option value="Kogi">Kogi</option>
                                <option value="Kwara">Kwara</option>
                                <option value="Lagos">Lagos</option>
                                <option value="Nassarawa">Nassarawa</option>
                                <option value="Niger">Niger</option>
                                <option value="Ogun">Ogun</option>
                                <option value="Ondo">Ondo</option>
                                <option value="Osun">Osun</option>
                                <option value="Oyo">Oyo</option>
                                <option value="Plateau">Plateau</option>
                                <option value="Rivers">Rivers</option>
                                <option value="Sokoto">Sokoto</option>
                                <option value="Taraba">Taraba</option>
                                <option value="Yobe">Yobe</option>
                                <option value="Zamfara">Zamfara</option>
                                <option value="Outside Nigeria">Outside Nigeria</option>
                            </select>
                        </div>
                       <div class="col-sm-4 form-group">
                            <label for="position">LGA</label>
                            <select class="form-control" name="lga" id="ostate">
                                <option selected>Choose LGA </option>
                                <option value="Nkanu-East">Nkanu-East</option>
                                <option value="Nkanu-west">Nkanu-west</option>
                            </select>
                        </div>
                        <div class="col-sm-4 form-group">
                            <label for="position">Gender</label>
                            <select class="form-control" name="gender" id="ostate">
                                <option selected>Choose Gender </option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label for="name">Qualification</label>
                            <input type="text" name="qualification" required class="form-control" id="Qualification" placeholder="Enter Qualification">
                        </div> 
                        <div class="col-sm-4 form-group">
                            <label for="name">University</label>
                            <input type="text" name="university" required class="form-control" id="University" placeholder="Enter University">
                        </div> 
                        <div class="col-sm-4 form-group">
                            <label for="position">shift</label>
                            <select class="form-control" name="shift" >
                                <option selected>Select working shift</option>
                                <option value="morning">MORNING</option>
                                <option value="afternoon">AFTERNOON</option>
                                <option value="night">NIGHT</option>
                            </select>
                        </div>
                    </div>
                        <div class="col-sm form-group">
                        <label for="position">Image</label>
                        <input type="file" name="doc_image" required class="form-control" id="position" placeholder="Choose Image(not greater than 512kb)">
                    </div>
                    </div>
                    
                    <div class="text-right">
                        <button type="submit" name="submit" class="btn btn-success waves-effect waves-light">Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.close();">Cancel</button>
                    </div>
                </form>
             </div>
             </div>
            </div>
            <!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
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