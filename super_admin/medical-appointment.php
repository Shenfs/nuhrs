<?php 
$page_title = "APPOINTMENT";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2">
    
    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
        <h3 class="font-weight-bold text-dark">Medical Appointment</h3>
            <table id="medical_appointment" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Date Created</th>
                        <th>Patient</th>
                        <th>From Date and Time</th>
                        <th>To Date and Time</th>
                        <th>Medical Professional</th>
                        <th>Status</th>
                        <th>Reason for Cancellation</th>
                        <th>Time Finished</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $selectAllAppointment = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_firstName, u1.lastName AS med_prof_lastName ,u2.firstName AS stud_firstName, u2.lastName AS stud_lastName, appointment.id AS appointment_id, appointment.status AS appointment_status
                     FROM appointment INNER JOIN medicalprofessional ON medicalprofessional.id = appointment.medprofID INNER JOIN students ON students.id = appointment.student_id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID    INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.appointment_type='Medical' ORDER BY from_date DESC");
                    while($row = $selectAllAppointment->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo date("M-d-Y",strtotime($row['datecreated']))?></td>
                        <td><?php echo $row['stud_firstName']." ".$row['stud_lastName'] ?></td>
                        <td><?php echo date("M-d-Y",strtotime($row['from_date']))." ".date("g:i A",strtotime($row['from_time'])) ?></td>
                        <td><?php echo date("M-d-Y",strtotime($row['to_date']))." ".date("g:i A",strtotime($row['to_time'])) ?></td>
                        <td><?php echo "Dr. ".$row['med_prof_firstName']." ".$row['med_prof_lastName'] ?></td>
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
                        <td><?php echo ($row['appointment_status'] == "Cancelled") ? $row['reason_for_cancellation'] : 'Not Applicable'; ?></td>
                        <td><?php echo ($row['appointment_status'] == "Successful") ? date("M-d-Y h:i A",strtotime($row['timefinished'])) : 'Not Applicable' ?></td>
                       
                        
                    </tr>
                    <!-- -->

                   
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->



<script>
    $(document).ready(function () {
    $('#medical_appointment').DataTable({
        order: [[2, 'desc']],
    });
});
</script>



<?php include_once("layouts/footer.php") ?>