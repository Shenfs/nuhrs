<?php 

$page_title = "DASHBOARD";
include_once("layouts/header-sidebar.php");

$selectAllUsers = mysqli_query($conn, "SELECT id from users");
$userRows = $selectAllUsers->num_rows;

$selectAllStudents = mysqli_query($conn, "SELECT id FROM students");
$studentRows = $selectAllStudents->num_rows;

$selectAllAppointments = mysqli_query($conn, "SELECT * FROM appointment");
$appointmentRows = $selectAllAppointments->num_rows;

$sql = "select diagnosis, count(*) AS duplicates from medicaltreatmentrecord group by diagnosis order by duplicates desc";
$result = $conn->query($sql);
$dataPoints = array();
// output data of each row
while($row = $result->fetch_assoc()) {
    array_push($dataPoints,array("label"=>$row['diagnosis'], "y"=>$row['duplicates']));
}


$sql2 = "select diagnosis, count(*) AS duplicates from dentaltreatmentrecord group by diagnosis order by duplicates desc";
$result2 = $conn->query($sql2);
$dataPoints2 = array();
// output data of each row
while($row2 = $result2->fetch_assoc()) {
    array_push($dataPoints2,array("label"=>$row2['diagnosis'], "y"=>$row2['duplicates']));
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div> -->




    <div class="row  d-flex-align-items-center justify-content-start pl-2 mb-4">
        
        <div class="col-md-3 bg bg-primary  border rounded py-2 mr-2 shadow shadow-lg">
           <div class="row p-1 d-flex align-items-center justify-content-between">
            <div class="col">
                <h5 class="font-weight-bold text-light">USERS</h5>
                <p class="text-light font-weight-bold h4"><?php echo $userRows; ?></p>
            </div>
            <div class="col d-flex align-items-center justify-content-end pr-3">
                <i class="fas fa-users fa-3x text-gray-300"></i>
            </div>
           </div>
        </div>

        <div class="col-md-3 bg bg-success  border rounded py-2 mr-2 shadow shadow-lg">
           <div class="row p-1 d-flex align-items-center justify-content-between">
            <div class="col">
                <h5 class="font-weight-bold text-light">STUDENTS</h5>
                <p class="text-light font-weight-bold h4"><?php echo $studentRows; ?></p>
            </div>
            <div class="col d-flex align-items-center justify-content-end pr-3">
                <i class="fas fa-user-tie fa-3x text-gray-300"></i>
            </div>
           </div>
        </div>

        <div class="col-md-3 bg bg-info  border rounded py-2 mr-2 shadow shadow-lg">
           <div class="row p-1 d-flex align-items-center justify-content-between">
            <div class="col">
                <h5 class="font-weight-bold text-light">APPOINTMENTS</h5>
                <p class="text-light font-weight-bold h4">25</p>
            </div>
            <div class="col d-flex align-items-center justify-content-end pr-3">
                <i class="fas fa-calendar-check fa-3x text-gray-300"></i>
            </div>
           </div>
        </div>

        
    </div>

    <!-- Content Row -->

    <div class="row">

    <div class="col">
            <div class="card">
                <div class="card-header">
                    <h6 class="text-dark font-weight-bold d-flex justify-content-center">
                        
                        Analytics (as of 
                        <?php echo date("M-d-Y"); ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row d-flex align-items-center justify-content-arround rounded ">
                       
                            <?php
                            $yearNow = date('Y');
                            $selectMedJanRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (1)");
                            $selectMedFebRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (2)");
                            $selectMedMarRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (3)");
                            $selectMedAprRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (4)");
                            $selectMedMayRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (5)");
                            $selectMedJunRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (6)");
                            $selectMedJulRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (7)");
                            $selectMedAugRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (8)");
                            $selectMedSepRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (9)");
                            $selectMedOctRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (10)");
                            $selectMedNovRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (11)");
                            $selectMedDecRows = mysqli_query($conn,"SELECT date_created
                            FROM medicalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (12)");
                            ?>

                                <canvas id="monthlyMedicalHealthRecords" style="width:50%;max-width:600px"></canvas>

                            

                            <script>
                            var xValues = ["Jan", "Feb", "Mar", "Apr", "May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                            var yValues = 
                            [<?php echo $selectMedJanRows->num_rows; ?>,
                            <?php echo $selectMedFebRows->num_rows; ?>,
                            <?php echo $selectMedMarRows->num_rows; ?>,
                            <?php echo $selectMedAprRows->num_rows; ?>,
                            <?php echo $selectMedMayRows->num_rows; ?>,
                            <?php echo $selectMedJunRows->num_rows; ?>,
                            <?php echo $selectMedJulRows->num_rows; ?>,
                            <?php echo $selectMedAugRows->num_rows; ?>,
                            <?php echo $selectMedSepRows->num_rows; ?>,
                            <?php echo $selectMedOctRows->num_rows; ?>,
                            <?php echo $selectMedNovRows->num_rows; ?>,
                            <?php echo $selectMedDecRows->num_rows; ?>];
                            var barColors = ["#3057C9", "#3057C9","#3057C9","#3057C9","#3057C9","#3057C9", "#3057C9","#3057C9","#3057C9","#3057C9","#3057C9","#3057C9"];

                            new Chart("monthlyMedicalHealthRecords", {
                            type: "bar",
                            data: {
                                labels: xValues,
                                datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                                }]
                            },
                            options: {scales: {
                                
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        userCallback: function(label, index, labels) {
                                            // when the floored value is the same as the value we have a whole number
                                            if (Math.floor(label) === label) {
                                                return label;
                                            }

                                        },
                                    }
                                }],
                            },

                            legend: {display: false},
                            title: {
                            display: true,
                            text: "Monthly Medical Health Records",
                            }
                        }
                        });
                        </script>
                        
                        
                            <?php
                            $yearNow = date('Y');
                            $selectJanRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (1)");
                            $selectFebRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (2)");
                            $selectMarRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (3)");
                            $selectAprRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (4)");
                            $selectMayRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (5)");
                            $selectJunRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (6)");
                            $selectJulRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (7)");
                            $selectAugRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (8)");
                            $selectSepRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (9)");
                            $selectOctRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (10)");
                            $selectNovRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (11)");
                            $selectDecRows = mysqli_query($conn,"SELECT date_created
                            FROM dentalhealthrecord WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) IN (12)");
                            ?>
                            
                                 <canvas id="monthlyDentalHealthRecords" style="width:50%;max-width:600px"></canvas>

                           
                            <script>
                            var xValues = ["Jan", "Feb", "Mar", "Apr", "May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                            var yValues = 
                            [<?php echo $selectJanRows->num_rows; ?>,
                            <?php echo $selectFebRows->num_rows; ?>,
                            <?php echo $selectMarRows->num_rows; ?>,
                            <?php echo $selectAprRows->num_rows; ?>,
                            <?php echo $selectMayRows->num_rows; ?>,
                            <?php echo $selectJunRows->num_rows; ?>,
                            <?php echo $selectJulRows->num_rows; ?>,
                            <?php echo $selectAugRows->num_rows; ?>,
                            <?php echo $selectSepRows->num_rows; ?>,
                            <?php echo $selectOctRows->num_rows; ?>,
                            <?php echo $selectNovRows->num_rows; ?>,
                            <?php echo $selectDecRows->num_rows; ?>];
                            var barColors = ["#3057C9", "#3057C9","#3057C9","#3057C9","#3057C9","#3057C9", "#3057C9","#3057C9","#3057C9","#3057C9","#3057C9","#3057C9"];

                            new Chart("monthlyDentalHealthRecords", {
                            type: "bar",
                            data: {
                                labels: xValues,
                                datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                                }]
                            },
                            options: {scales: {
                                
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true,
                                            userCallback: function(label, index, labels) {
                                                // when the floored value is the same as the value we have a whole number
                                                if (Math.floor(label) === label) {
                                                    return label;
                                                }

                                            },
                                        }
                                    }],
                                },

                                legend: {display: false},
                                title: {
                                display: true,
                                text: "Monthly Dental Health Records",
                                }
                            }
                            });
                            </script>
                            <!-- -->
                            <script>
                            window.onload = function() {
                            var chart = new CanvasJS.Chart("chartContainer", {
                                animationEnabled: true,
                                title: {
                                    text: ""
                                },
                                subtitles: [{
                                    text: "Diagnosis Category"//new Date().getFullYear()
                                }],
                                data: [{
                                    type: "pie",
                                    yValueFormatString: "#,##0.00\"%\"",
                                    indexLabel: "{label} ({y})",
                                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                                }]
                            });
                            chart.render();
                            
                            }
                            </script>
                             <div id="chartContainer" style="height: 370px; width: 50%;"></div>
                            <script>
                            window.onload = function() {
                            let chart2 = new CanvasJS.Chart("chartContainer2", {
                                animationEnabled: true,
                                title: {
                                    text: ""
                                },
                                subtitles: [{
                                    text: "Diagnosis Category"//new Date().getFullYear()
                                }],
                                data: [{
                                    type: "pie",
                                    yValueFormatString: "#,##0.00\"%\"",
                                    indexLabel: "{label} ({y})",
                                    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                                }]
                            });
                            chart2.render();
                            
                            }
                            </script>
                                <div id="chartContainer2" style="height: 370px; width: 50%;"></div>
                        </div>
                        
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col mt-4">
                            
                        <div class="col">

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
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<?php include_once("layouts/footer.php") ?>