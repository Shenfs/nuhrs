<?php 
$page_title = "REPORTS";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2 border border-rounded py-3">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-weight-bold text-dark">Generate Report</h3>
                </div>
                <div class="card-body">
                    <form action="../Controller/ExportController.php" method="POST" id="exportForm">
                        <input type="hidden" name="user_id" value="<?php echo $active_id ?>">
                    <div class="row">
                        <div class="col">
                            <label>Type of Record</label>
                            <select name="record_type" id="" class="form-control" required>
                               <?php  echo in_array($active_specialization,['Doctor','Nurse']) ? "<option value='Medical'>Medical</option>" : "<option value='Dental'>Dental</option>";?>
                            </select>
                        </div>
                        <div class="col">
                            <label>Year Level</label>
                            <select name="year_type" id="" class="form-control" required>
                                <option value="Senior High School">Senior High School</option>
                                <option value="College">College</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Start Date</label>
                            <input type="date" name="start_date" id="StartDate" class="form-control" max="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col">
                            <label>End Date</label>
                            <input type="date" name="end_date" id="EndDate" class="form-control" max="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="row mt-2 d-flex align-items-center justify-content-end">
                        <div class="col-md-2 ">
                            <button type="submit" class="form-control btn btn-primary">Export</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>


    <script>
    $("#EndDate").change(function() {
        var startDate = document.getElementById("StartDate").value;
        var endDate = document.getElementById("EndDate").value;

        if ((Date.parse(endDate) <= Date.parse(startDate))) {
        alert("End date should be greater than Start date");
        document.getElementById("EndDate").value = "";
        }
    });
    </script>


    <?php 
    if(in_array($active_specialization,['Nurse'])){ ?>
    <div class="row mt-4 px-3">
        <h3 class="font-weight-bold text-dark" style="width: 90%;">Database Backup</h3>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-1 d-flex align-items-center justify-content-center">
                    <label class="font-weight-bold text-dark h5">Password</label>
                </div>
                <div class="col-md-5">
                    <form action="../Controller/ReportController.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $active_id ?>">
                    <input type="hidden" name="user_type_id" value="<?php echo $active_user_type_id ?>">
                    <input type="password" name="inputted_password" class="form-control">
                    <input type="hidden" name="correct_password" value="<?php echo $active_password ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" name="export_database" class="btn btn-primary w-50">Export</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   <?php } ?>
    
    <div class="row mt-4 px-3">
        <h3 class="font-weight-bold text-dark" style="width: 90%;">Appointment Today</h3>
        <div class="col-md-12">
            <table id="appointment_today" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Appointment Date and Time</th>
                        <th>Medical Professional</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $datenow = date('Y-m-d');
                    $selectTodayAppointment = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_firstName, u1.lastName AS med_prof_lastName ,u2.firstName AS stud_firstName, u2.lastName AS stud_lastName, appointment.id AS appointment_id, appointment.status AS appointment_status
                     FROM appointment INNER JOIN medicalprofessional ON medicalprofessional.id = appointment.medprofID INNER JOIN students ON students.id = appointment.student_id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID    INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.status IN ('Approved','Rescheduled','Successful','Unsuccessful') AND from_date = '$datenow' ORDER BY from_date DESC");
                    while($row = $selectTodayAppointment->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['stud_firstName']." ".$row['stud_lastName'] ?></td>
                        <td><?php echo date("M-d-Y",strtotime($row['from_date']))." ".date("h:i",strtotime($row['from_time']))."-".date("h:i A",strtotime($row['to_time'])) ?></td>
                        <td><?php echo $row['med_prof_firstName']." ".$row['med_prof_lastName'] ?></td>
                        <td>
                        <?php
                            switch($row['appointment_status']){
                                case "Approved" : echo "<p class='text-light font-weight-light border bg-success rounded text-center  font-weight-bold py-1'>Approved</p>";break;
                                case "Finished" : echo "<p class='text-light font-weight-light border bg-success rounded text-center  font-weight-bold py-1'>Finished</p>";break;
                                case "Pending" : echo "<p class='text-light font-weight-light border bg-info rounded text-center  font-weight-bold py-1'>Pending</p>";break;
                                case "Rescheduled" : echo "<p class='text-light font-weight-light border bg-primary rounded text-center  font-weight-bold py-1 px-1'>Rescheduled</p>";break;
                                case "Cancelled" : echo "<p class='text-light font-weight-light border bg-danger rounded text-center  font-weight-bold py-1'>Cancelled</p>";break;
                                case "Successful" : echo "<p class='text-light font-weight-light border bg-success rounded text-center  font-weight-bold py-1 px-1'>Successful</p>";break;
                                case "Unsuccessful" : echo "<p class='text-light font-weight-light border bg-danger rounded text-center  font-weight-bold py-1 px-1'>Unsuccessful</p>";break;
                                default: echo "";
                            } 
                        ?>
                        </td>
                        <td><?php echo date("M-d-Y",strtotime($row['datecreated']))?></td>
                        <td class="d-flex align-items-center justify-content-center">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editAppointmentStatus<?php echo $row['appointment_id'];?>" <?php echo (in_array($row['appointment_status'],['Successful','Unsuccessful'])) ? 'disabled' : '' ?>><i class="fas fa-edit"></i></button>
                        </td>
                    
                    </tr>
                   
                    <!-- Edit Appointment Status Modal -->
                    <div class="modal fade" id="editAppointmentStatus<?php echo $row['appointment_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Appointment Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="../Controller/ReportController.php" method="POST">
                            <div class="row">
                                <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                <div class="col">
                                <label>Status</label>
                                <select name="status"  class="form-control">
                                    <option value="Successful">Successful</option>
                                    <option value="Unsuccessful">Unsuccessful</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="edit_status" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>
                    <!-- Edit Appointment Status Modal -->
                    <?php endwhile; ?>
            </table>
        </div>
    </div>
        

</div>
<!-- /.container-fluid -->



<script>
$(document).ready(function () {
    $('#send_notif').DataTable();
});
</script>

<script>
$(document).ready(function () {
    $('#appointment_today').DataTable();
});
</script>





<?php include_once("layouts/footer.php") ?>