<?php 
$page_title = "DASHBOARD";
include_once("layouts/header-sidebar.php"); 
$selectAllMyAppointments = mysqli_query($conn,"SELECT * FROM appointment WHERE student_id='$active_student_id'");
$selectAllMyAppointments = $selectAllMyAppointments->num_rows;

$selectMyPendingAppointments = mysqli_query($conn,"SELECT * FROM appointment WHERE student_id='$active_student_id' AND status='Pending'");
$selectMyPendingAppointments = $selectMyPendingAppointments->num_rows;

$selectMyApprovedAppointments = mysqli_query($conn,"SELECT * FROM appointment WHERE student_id='$active_student_id' AND status='Approved'");
$selectMyApprovedAppointments = $selectMyApprovedAppointments->num_rows;
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        
    </div>

    <div class="row  d-flex-align-items-center justify-content-start pl-2 mb-4">
        
        <div class="col-md-3 bg bg-primary  border rounded py-3 mr-2 shadow shadow-lg">
           <div class="row p-1 d-flex align-items-center justify-content-between">
            <div class="col-md-9">
                <h6 class="font-weight-bold text-light">ALL APPOINTMENTS</h6>
                <p class="text-light font-weight-bold h4"><?php echo $selectAllMyAppointments; ?></p>
            </div>
            <div class="col d-flex align-items-center justify-content-end pr-3">
                <i class="fas fa-users fa-3x text-gray-300"></i>
            </div>
           </div>
        </div>

        <div class="col-md-3 bg bg-success  border rounded py-3 mr-2 shadow shadow-lg">
           <div class="row p-1 d-flex align-items-center justify-content-between">
            <div class="col-md-9">
                <h6 class="font-weight-bold text-light">APPROVED APPOINTMENTS</h6>
                <p class="text-light font-weight-bold h4"><?php echo $selectMyApprovedAppointments; ?></p>
            </div>
            <div class="col d-flex align-items-center justify-content-end pr-3">
                <i class="fas fa-user-tie fa-3x text-gray-300"></i>
            </div>
           </div>
        </div>

        <div class="col-md-3 bg bg-success  border rounded py-3 mr-2 shadow shadow-lg">
           <div class="row p-1 d-flex align-items-center justify-content-between">
            <div class="col-md-9">
                <h6 class="font-weight-bold text-light">PENDING APPOINTMENTS</h6>
                <p class="text-light font-weight-bold h4"><?php echo $selectMyPendingAppointments; ?></p>
            </div>
            <div class="col d-flex align-items-center justify-content-end pr-3">
                <i class="fas fa-user-tie fa-3x text-gray-300"></i>
            </div>
           </div>
        </div>

        
    </div>



    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-dark font-weight-bold">Welcome, <?php echo $active_firstname." ".$active_lastname ?><sup> [<?php echo $active_student_id_number ?>]</sup></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h4>Upcoming Appointments</h4>
                            <ul>

                                <?php
                                $datenow = date('Y-m-d'); 
                                $selectAllApprovedAppointments = mysqli_query($conn,"SELECT * FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN users ON medicalprofessional.userID = users.id WHERE from_date >= '$datenow'  AND student_id='$active_student_id' AND status='Approved'");
                                while($row = $selectAllApprovedAppointments->fetch_assoc()){?>
                                    <li class="text-justify">Your schedule of <?php echo $row['appointment_type'] ?> Appointment with Dr. <?php echo $row['firstName']." ".$row['lastName']?> will be held on <?php echo date('M-d-Y',strtotime($row['from_date'])) ?> <?php echo date('h:i ',strtotime($row['from_time'])) ?> - <?php echo date('h:i A',strtotime($row['to_time'])) ?> at NU Fairview Clinic</li>
                                <?php } ?>
                               
                            </ul>
                        </div>

                        <div class="col">
                        <h4>Rescheduled Appointments</h4>
                            <ul>
                                <?php
                                $datenow = date('Y-m-d'); 
                                $selectAllApprovedAppointments = mysqli_query($conn,"SELECT * FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN users ON medicalprofessional.userID = users.id WHERE from_date >= '$datenow'  AND student_id='$active_student_id' AND status='Rescheduled'");
                                while($row = $selectAllApprovedAppointments->fetch_assoc()){?>
                                    <li class="text-justify">Your <?php echo $row['appointment_type'] ?> Appointment with Dr. <?php echo $row['firstName']." ".$row['lastName']?> is Reschedulled on <?php echo date('M-d-Y',strtotime($row['from_date'])) ?> <?php echo date('h:i ',strtotime($row['from_time'])) ?> - <?php echo date('h:i A',strtotime($row['to_time'])) ?></li>
                                <?php } ?>
                               
                            </ul>
                        </div>

                        <div class="col">
                            <h4>Cancelled Appointments</h4>
                            <ul>
                                <?php
                                $datenow = date('Y-m-d'); 
                                $selectAllApprovedAppointments = mysqli_query($conn,"SELECT * FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN users ON medicalprofessional.userID = users.id WHERE MONTH(from_date) = MONTH(NOW())  AND student_id='$active_student_id' AND status='Cancelled'");
                                while($row = $selectAllApprovedAppointments->fetch_assoc()){?>
                                    <li>Your <?php echo $row['appointment_type'] ?> Appointment with Dr. <?php echo $row['firstName']." ".$row['lastName']?> dated <?php echo date('M-d-Y',strtotime($row['from_date'])) ?> <?php echo date('h:i ',strtotime($row['from_time'])) ?> - <?php echo date('h:i A',strtotime($row['to_time'])) ?> was canclled due to <?php echo $row['reason_for_cancellation'] ?></li>
                                <?php } ?>
                               
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Area Chart -->
        <!-- <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4"> -->
        <!-- Card Header - Dropdown -->
        <!-- <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div> -->
        <!-- Card Body -->
        <!-- <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div> -->

        <!-- Pie Chart -->
        <!-- <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4"> -->
        <!-- Card Header - Dropdown -->
        <!-- <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div> -->
        <!-- Card Body -->
        <!-- <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div>
                                </div> -->
        <!-- </div>
                        </div> -->
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <!-- <div class="col-lg-6 mb-4"> -->

        <!-- Project Card Example -->
        <!-- <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">Server Migration <span
                                            class="float-right">20%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Sales Tracking <span
                                            class="float-right">40%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Customer Database <span
                                            class="float-right">60%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar" role="progressbar" style="width: 60%"
                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Payout Details <span
                                            class="float-right">80%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Account Setup <span
                                            class="float-right">Complete!</span></h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div> -->

        <!-- Color System -->
        <!-- <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-primary text-white shadow">
                                        <div class="card-body">
                                            Primary
                                            <div class="text-white-50 small">#4e73df</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-success text-white shadow">
                                        <div class="card-body">
                                            Success
                                            <div class="text-white-50 small">#1cc88a</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-info text-white shadow">
                                        <div class="card-body">
                                            Info
                                            <div class="text-white-50 small">#36b9cc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-warning text-white shadow">
                                        <div class="card-body">
                                            Warning
                                            <div class="text-white-50 small">#f6c23e</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-danger text-white shadow">
                                        <div class="card-body">
                                            Danger
                                            <div class="text-white-50 small">#e74a3b</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-secondary text-white shadow">
                                        <div class="card-body">
                                            Secondary
                                            <div class="text-white-50 small">#858796</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-light text-black shadow">
                                        <div class="card-body">
                                            Light
                                            <div class="text-black-50 small">#f8f9fc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-dark text-white shadow">
                                        <div class="card-body">
                                            Dark
                                            <div class="text-white-50 small">#5a5c69</div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

    </div>

    <div class="col-lg-6 mb-4">

        <!-- Illustrations -->
        <!-- <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                            src="img/undraw_posting_photo.svg" alt="...">
                                    </div>
                                    <p>Add some quality, svg illustrations to your project courtesy of <a
                                            target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                                        constantly updated collection of beautiful svg images that you can use
                                        completely free and without attribution!</p>
                                    <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                                        unDraw &rarr;</a>
                                </div>
                            </div> -->

        <!-- Approach -->
        <!-- <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                                </div>
                                <div class="card-body">
                                    <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                                        CSS bloat and poor page performance. Custom CSS classes are used to create
                                        custom components and custom utility classes.</p>
                                    <p class="mb-0">Before working with this theme, you should become familiar with the
                                        Bootstrap framework, especially the utility classes.</p>
                                </div>
                            </div> -->

        <!-- </div> -->
    </div>

</div>
<!-- /.container-fluid -->

<?php include_once("layouts/footer.php") ?>