<?php 
$page_title = "APPOINTMENT";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
        <h3 class="font-weight-bold text-dark">Dental Appointment</h3>
        <table id="dental_appointment" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>From Date and Time</th>
                        <th>To Date and Time</th>
                        <th>Medical Professional</th>
                        <th>Status</th>
                        <th>Reason for Cancellation</th>
                        <th>Time Finished</th>
                        <th>Date Created</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $selectAllAppointment = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_firstName, u1.lastName AS med_prof_lastName ,u2.firstName AS stud_firstName, u2.lastName AS stud_lastName, appointment.id AS appointment_id , appointment.status AS appointment_status
                     FROM appointment INNER JOIN medicalprofessional ON medicalprofessional.id = appointment.medprofID INNER JOIN students ON students.id = appointment.student_id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID    INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.appointment_type='Dental' ORDER BY from_date DESC");
                    while($row = $selectAllAppointment->fetch_assoc()):
                    ?>
                    <tr>
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
                        <td><?php echo date("M-d-Y",strtotime($row['datecreated']))?></td>
                        
                    </tr>
                    <!-- -->

                    
                    <!-- -->
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<!-- Set Dental Appointment Modal -->
<!-- Modal -->
<div class="modal fade" id="setDentalAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-calendar-plus mr-2"></i>Set Dental Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../Controller/AppointmentController.php" method="POST">
        <input type="hidden" name="appointment_type" value="Dental">
        <input type="hidden" name="student_id" value="<?php echo $active_student_id; ?>">
        <input type="hidden" name="createdby" value="<?php echo $active_firstname." ".$active_lastname; ?>">
        <div class="row">
          
          <div class="col">
            <label>Dentist</label>
            <select name="med_prof_id"  class="form-control" required>
              
            <?php 
              date_default_timezone_set('Asia/Manila');
              $datenow = date('Y-m-d');
              $selectAllDentist = mysqli_query($conn,"SELECT *, medicalprofessional.id as med_prof_id  FROM users INNER JOIN medicalprofessional ON users.id = medicalprofessional.userID WHERE medicalprofessional.specialization='Dentist'");
              while($row = $selectAllDentist->fetch_assoc()){?>
                <option value="<?php echo $row['med_prof_id'] ?>"><?php echo $row['firstName']." ".$row['lastName']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label>From Date</label>
            <input type="date" class="form-control" name="from_date" min=<?php echo $datenow; ?> required>
          </div>
          <div class="col">
            <label>From Time</label>
            <input type="time" name="from_time" class="form-control" required>
          </div>
        </div>

          <div class="row">
          <div class="col">
            <label>To Date</label>
            <input type="date" class="form-control" name="to_date" min=<?php echo $datenow; ?> required>
          </div>
          <div class="col">
            <label>To Time</label>
            <input type="time" name="to_time" class="form-control" required>
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button"   class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="set_appointment" class="btn btn-primary">Set</button>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- Set Dental Appointment Modal -->
<script>
    $(document).ready(function () {
    $('#dental_appointment').DataTable({
        order: [[2, 'desc']],
    });
});
</script>



<?php include_once("layouts/footer.php") ?>