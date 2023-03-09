<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | NUHRS</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" href="images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style.css"> -->

</head>
<style>
    body{
        font-family: 'Montserrat';
    }
</style>

<body>
    <div class="container-fluid h-20 w-100 bg-dark py-1">
        <div class="row my-1">
            <div class="col ml-5 d-flex align-items-center">
                <img src="images/nulogo.png" alt="" height="50" width="50" class="border rounded-circle">
                <h4 class="ml-2 text-white">NUHRS</h4>
            </div>

            <!-- <div class="col d-flex align-items-center justify-content-end pr-5">
                <h4 class="text-white"></h4>
            </div> -->

        </div>
    </div>

    <div class="main-container">
        <div class="container">

            <section class="h-90 gradient-form" style="background-color:white;" >
                <div class="container py-5 h-90">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-xl">
                            <div class="card rounded-3 text-black">
                                <div class="row g-0 ">

                                    <div class="col-lg-6 d-flex align-items-center justify-content-center" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('images/nu-background.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;"> <!--  gradient-custom-2"> -->
                                        <!-- <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                              <h4 class="mb-4">We are more than just a company</h4>
                              <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div> -->

                                        <div class="col-lg-6   align-items-center justify-content-center d-flex flex-wrap" id="square-left" style="color: white;">
                                            <div class="row  align-items-center justify-content-center">

                                                <h1>Welcome!</h1>
                                                <br>
                                                <p>Please Sign in to Access</p>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6  bg-light  border-dark">
                                        <div class="card-body p-md-5 mx-md-4">

                                            <div class="text-center">
                                                <img src="images/nulogo.png" style="width: 100px;" alt="Logo" class="border rounded-circle">
                                                <p class="mt-1 mb-5 pb-1 text-muted">NUHRS</p>
                                            </div>

                                            <form action="Controller/LoginController.php" method="POST">
                                                <center>
                                                    <p class="text-muted">Login to your account</p>
                                                </center>

                                                <div class="form-outline mb-2">
                                                    <label class="form-label" for="form2Example11">Email Address</label>
                                                    <input type="email" id="form2Example11" class="form-control" placeholder="Email Address" name="email_address" required />
                                                </div>

                                                <div class="form-outline mb-4">
                                                    <label class="form-label" for="form2Example11">Password</label>
                                                    <input type="password" id="form2Example22" class="form-control" placeholder="Password" name="password" required />
                                                </div>

                                                <div class="text-center pt-1 mb-5 pb-1">
                                                    <button class="btn btn-primary btn-block fa-lg mb-3" name="login" type="submit" style="background-color:#1034a6;">Log
                                                        in</button>
                                                    <!-- <a class="text-muted text-decoration-underline" data-toggle="modal" data-target="#forgotPassword" href="#">Forgot Password?</a>  -->
                                                </div>


                                            </form>

                                        </div>
                                    </div>

                                </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    <!-- Footer -->
    <footer class="text-center text-lg-start text-muted bg-dark">
        <!-- Section: Social media -->
        <section class="d-flex justify-content-center justify-content-lg-between p-2 ">

            <!-- Right -->
        </section>

        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start mt-5 ">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-4  mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i>NATIONAL UNIVERSITY FAIRVIEW
                        </h6>
                        <p>
                            HEALTH RECORD SYSTEM
                        </p>
                    </div>
                    <!-- Grid column -->

                    

                    <!-- Grid column -->
                    <div class="col-md-5  mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Learn More
                        </h6>
                        <p>
                            <a href="nuhrs_privacy_policy.php" >NUHRS Privacy Policy</a>
                        </p>
                        <p>
                            <a href="nu_privacy_policy.php" >NU Privacy Policy</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-3  mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Contact
                        </h6>
                        <p><i class="fas fa-home me-3"></i> </p>
                        <p>
                            <i class="fas fa-envelope me-3"></i>

                        </p>
                        <p><i class="fas fa-phone me-3"></i>Mobile: 09399173214</p>
                        <p><i class="fas fa-print me-3"></i>Email Address: <br> nuhrs@nu-fairview.edu.ph</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        NATIONAL UNIVERSITY FAIRVIEW
            <!-- <a class="text-reset fw-bold" href="https://mdbootstrap.com/">MDBootstrap.com</a> -->
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
    </div>
    </nav>
    </div>

    <!--Forgot Password Modal -->
    <div class="modal fade" id="forgotPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Find Email</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <label>Email Address</label>
                    <input type="email" name="email_address" class="form-control">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Find</button>
        </div>
        </div>
    </div>
    </div>
    <!--Forgot Password Modal -->


    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>