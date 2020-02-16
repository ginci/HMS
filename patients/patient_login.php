
<?php require 'includes/header_account.php'; ?>
<?php 
  if (isset($_POST['submit'])) {

    $result = login_patient($_POST);
    if ($result === true) {
        header("Location: ../patients/");
        exit();
    }else{
        $errors1 = $result;
    }
}
?>

    <body class="account-pages">

        <!-- Begin page -->
        <div class="accountbg" style="background: url('../assets/images/bg1.jpg');background-size: cover;background-position: center;"></div>

        <div class="wrapper-page account-page-full">

            <div class="card">
                <div class="card-block">

                    <div class="account-box">

                        <div class="card-box p-5">
                            <h2 class="text-uppercase text-center pb-4">
                                <a href="index.php" class="text-success">
                                    <span><img src="../assets/images/logo.jpg" alt="" height="55"></span>
                                </a>
                            </h2>

                            <form class="form-horizontal form-material" id="recoverform" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                                <div class="form-group m-b-20 row">
                                    <div class="col-12">
                                        <label for="emailaddress"><b>Card Number</b></label>
                                        <input class="form-control" type="text" name="card_id" id="emailaddress" required="" placeholder="Enter your Card Number">
                                    </div>
                                </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">
                                        <a href="page-recoverpw.php" class="text-muted float-right"><small>Forgot your password?</small></a>
                                        <label for="password"><b>Password</b></label>
                                        <input class="form-control" type="password" name="password" required="" id="password" placeholder="Enter your password">
                                    </div>
                                    
                        
                                </div>
                                <?php 
                                        if (isset($errors1)) {
                                    ?>
                                        <div class="form-group">
                                            <div class="col-12 btn btn-danger">
                                                <?php echo $errors1['pass_ver']; ?>
                                            </div>
                                        </div>
                                    <?php }?>
                                    <div class="col">
                                        <div class="btn"></div>
                                    </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">

                                        <div class="checkbox checkbox-custom">
                                            <input id="remember" type="checkbox" checked="">
                                            <label for="remember">
                                                Remember me
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row text-center m-t-10">
                                    <div class="col-12">
                                        <button class="btn btn-block btn-custom waves-effect waves-light" type="submit" name="submit">Sign In</button>
                                    </div>
                                </div>

                            </form>

                            <div class="row m-t-50">
                                <div class="col-sm-12 text-center">
                                    <p class="text-muted">Go Back <a href="../" class="text-dark m-l-5"><b>Home</b></a></p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                <p class="account-copyright">2018 © UNTH Ituku-Ozalla</p>
            </div>

        </div>




        <?php require 'includes/footer_account.php' ?>