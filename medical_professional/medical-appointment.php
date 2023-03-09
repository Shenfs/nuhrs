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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $selectAllAppointment = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_firstName, u1.lastName AS med_prof_lastName ,u2.firstName AS stud_firstName, u2.lastName AS stud_lastName, appointment.id AS appointment_id, appointment.status AS appointment_status
                     FROM appointment INNER JOIN medicalprofessional ON medicalprofessional.id = appointment.medprofID INNER JOIN students ON students.id = appointment.student_id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID    INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.appointment_type='Medical' AND appointment.medprofID ='$active_med_prof_id' ORDER BY from_date DESC");
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
                       
                        <td class="d-flex align-items-center justify-content-between gap-5">
                          <div data-toggle="tooltip" data-placement="bottom" title="Approve">
                            <button class="btn btn-sm btn-success mx-1" data-toggle="modal" data-target="#approveAppointmentModal<?php echo $row['appointment_id']; ?>" <?php echo ($row['appointment_status'] == "Approved" || $row['appointment_status'] == "Rescheduled" || $row['appointment_status'] == "Successful" || $row['appointment_status'] == "Unsuccessful" || $row['appointment_status'] == "Cancelled") ? "disabled" : "" ?>><i class="fas fa-calendar-check" ></i></button>
                          </div>
                          <div data-toggle="tooltip" data-placement="bottom" title="Reschedule">
                            <button class="btn btn-sm btn-primary mx-1" data-toggle="modal" data-target="#reschedAppointmentModal<?php echo $row['appointment_id']; ?>" <?php echo ($row['appointment_status'] == "Cancelled" || $row['appointment_status'] == "Pending" || $row['appointment_status'] == "Successful" || $row['appointment_status'] == "Unsuccessful") ? "disabled" : "" ?>><i class="fas fa-calendar-day"></i></button>
                          </div>
                          <div data-toggle="tooltip" data-placement="bottom" title="Cancel">
                            <button class="btn btn-sm btn-danger mx-1" data-toggle="modal" data-target="#cancelAppointmentModal<?php echo $row['appointment_id']; ?>" <?php echo ($row['appointment_status'] == "Cancelled" || $row['appointment_status'] == "Successful" || $row['appointment_status'] == "Unsuccessful") ? "disabled" : "" ?>><i class="fas fa-calendar-times"></i></button>
                          </div>
                          
                          
                        </td>
                    </tr>
                    <!-- -->

                    <!-- Approve Appointment Modal -->
                    <div class="modal fade" id="approveAppointmentModal<?php echo $row['appointment_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-calendar-plus mr-2"></i>Approve Appointment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <form action="../Controller/AppointmentController.php" method="post">
                          <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                          <input type="hidden" name="appointment_type" value="<?php echo $row['appointment_type']; ?>">
                              <div class="row">
                                <div class="col d-flex align-items-center justify-content-center">
                                  <h3 class="text-center">Are you sure you want to approve appointment?</h3>
                                </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="approve_appointment" class="btn btn-primary">Yes</button>
                          </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Approve Appointment Modal -->

                    <!-- Resched Appointment Modal -->
                    <div class="modal fade" id="reschedAppointmentModal<?php echo $row['appointment_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-calendar-day mr-2"></i>Reschedule Appointment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <form action="../Controller/AppointmentController.php" method="post">
                          <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                          <input type="hidden" name="appointment_type" value="<?php echo $row['appointment_type']; ?>">
                              <div class="row">
                                <div class="col">
                                  <label>Date</label>
                                  <?php
                                  date_default_timezone_set('Asia/Manila');
                                  $datenow = date('Y-m-d');
                                  ?>
                                  <input type="date" class="form-control" name="from_date" min=<?php echo $datenow; ?> required>
                                </div>
                                <div class="col">
                                  <label>Time</label>
                                  <select name="from_time" class="form-control">
                                    <option value="8:00:00">8:00 AM - 8:30 AM</option>
                                    <option value="8:30:00">8:30 AM - 9:00 AM</option>
                                    <option value="9:00:00">9:00 AM - 9:30 AM</option>
                                    <option value="9:30:00">9:30 AM - 10:00 AM</option>
                                    <option value="10:00:00">10:00 AM - 10:30 AM</option>
                                    <option value="10:30:00">10:30 AM - 11:00 AM</option>
                                    <option value="11:00:00">11:00 AM - 11:30 AM</option>
                                    <option value="11:30:00">11:30 AM - 12:00 PM</option>
                                    <option value="13:00:00">1:00 PM - 1:30 PM</option>
                                    <option value="13:30:00">1:30 PM - 2:00 PM</option>
                                    <option value="14:00:00">2:00 PM - 2:30 PM</option>
                                    <option value="14:30:00">2:30 PM - 3:00 PM</option>
                                    <option value="15:00:00">3:00 PM - 3:30 PM</option>
                                    <option value="15:30:00">3:30 PM - 4:00 PM</option>
                                    <option value="16:00:00">4:00 PM - 4:30 PM</option>
                                    <option value="16:30:00">4:30 PM - 5:00 PM</option>
                                  </select>
                                </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="resched_appointment" class="btn btn-primary">Yes</button>
                          </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Resched Appointment Modal -->

                    <!-- Cancel Appointment Modal -->
                    <div class="modal fade" id="cancelAppointmentModal<?php echo $row['appointment_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-calendar-times mr-2"></i>Cancel Appointment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <form action="../Controller/AppointmentController.php" method="post">
                          <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                          <input type="hidden" name="appointment_type" value="<?php echo $row['appointment_type']; ?>">
                              <div class="row">
                                <div class="col d-flex align-items-center justify-content-center">
                                  <h3 class="text-center">Are you sure you want to cancel appointment?</h3>
                                </div>
                              </div>
                              <div class="row p-2">
                                <label for="">Reason</label>
                                <textarea name="reason" required cols="10" rows="5" style="resize: none;" class="form-control"></textarea>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="cancel_appointment" class="btn btn-primary">Confirm</button>
                          </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Cancel Appointment Modal -->

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