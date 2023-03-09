<?php 
$page_title = "APPOINTMENT";


include_once("layouts/header-sidebar.php") ?>
<style type="text/css">
td.day{
  position:relative;  
}

td.day.disabled:hover:before {
    content: 'This date is not available';
    color: red;
    background-color: white;
    top: -22px;
    position: absolute;
    width: 136px;
    left: -34px;
    z-index: 1000;
    text-align: center;
    padding: 2px;
    font-family: 'Tahoma';
    font-weight: bold;
}
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <button class="btn btn-primary" data-toggle="modal" data-target="#setDentalAppointmentModal">Set Dental Appointment</button>
        </div>
    </div>
    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
        <h3 class="font-weight-bold text-dark">Dental Appointment History</h3>
            <table id="dental_appointment_history" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
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
                    $selectAllAppointment = mysqli_query($conn,"SELECT *, appointment.status AS appointment_status  FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN users ON medicalprofessional.userID = users.id WHERE appointment.student_id='$active_student_id' AND appointment_type='Dental'");
                    while($row = $selectAllAppointment->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo date("M-d-Y",strtotime($row['from_date']))." ".date("g:i A",strtotime($row['from_time'])) ?></td>
                        <td><?php echo date("M-d-Y",strtotime($row['to_date']))." ".date("g:i A",strtotime($row['to_time'])) ?></td>
                        
                        <td><?php echo "Dr. ".$row['firstName']." ".$row['lastName'] ?></td>
                        <td>
                        <?php
                            switch($row['appointment_status']){
                                case "Approved" : echo "<p class='text-light border bg-success rounded text-center  font-weight-bold p-1'>Approved</p>";break;
                                case "Successful" : echo "<p class='text-light border bg-success rounded text-center  font-weight-bold p-1'>Finished</p>";break;
                                case "Pending" : echo "<p class='text-light border bg-info rounded text-center  font-weight-bold p-1'>Pending</p>";break;
                                case "Rescheduled" : echo "<p class='text-light border bg-primary rounded text-center  font-weight-bold p-1'>Rescheduled</p>";break;
                                case "Cancelled" : echo "<p class='text-light border bg-danger rounded text-center  font-weight-bold p-1'>Cancelled</p>";break;
                                case "Unsuccessful" : echo "<p class='text-light border bg-danger rounded text-center  font-weight-bold p-1'>Unsuccessful</p>";break;
                                default: echo "";
                            } 
                        ?>
                        </td>
                        <td><?php echo ($row['appointment_status'] == "Cancelled") ? $row['reason_for_cancellation'] : 'Not Applicable'; ?></td>
                        <td><?php echo (empty($row['timefinished'])) ? 'Not Applicable' : $row['timefinished']; ?></td>
                        <td><?php echo date("M-d-Y g:i A",strtotime($row['datecreated'])) ?></td>
                    </tr>
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
        <input type="hidden" name="user_id" value="<?php echo $active_id; ?>">
        <input type="hidden" name="student_id" value="<?php echo $active_student_id; ?>">
        <input type="hidden" name="createdby" value="<?php echo $active_firstname." ".$active_lastname; ?>">
        <div class="row">
          
          <div class="col">
            <label>Dentist</label>
            <select name="med_prof_id" id="med_prof_id"  class="form-control" required>
            <option disabled selected>--Select Medical Professional--</option>
            <?php 
              date_default_timezone_set('Asia/Manila');
              $datenow = date('Y-m-d');
              $selectAllDentist = mysqli_query($conn,"SELECT *, medicalprofessional.id as med_prof_id  FROM users INNER JOIN medicalprofessional ON users.id = medicalprofessional.userID WHERE medicalprofessional.specialization='Dentist'");
              while($row = $selectAllDentist->fetch_assoc()){?>
                <option value="<?php echo $row['med_prof_id'] ?>"><?php echo "Dr. ".$row['firstName']." ".$row['lastName']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <script>
        $("#med_prof_id").change(function () {
            $("#from_date").datepicker("destroy");
            var med_prof_id = $(this).val();
            
            if(med_prof_id) {
                console.log(med_prof_id);

                $.ajax({
                    url: "check-sched-dentist.php",
                    type: "POST",
                    data: { med_id: med_prof_id },
                    success: function(data) {
                      console.log(data);
                      var obj = JSON.parse(data);
                      var res = [];
                      
                      for(var i in obj)
                          res.push(obj[i]);
                     
                          var nowDate = new Date();
                          var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
                        $('#from_date').datepicker({
                            format: 'yyyy-mm-dd',
                            autoclose: true,
                            todayHighlight: false,
                            datesDisabled: res,
                            daysOfWeekDisabled: [0],
                            startDate: today

                        });

                       
                    }
                });



            }else{
                console.log("Failed");
                // $('#student_ajax').empty();
            }
        });
        </script>

        <div class="row">
          <div class="col">
            <label>Date</label>
            <input type="text" class="form-control datepicker"  name="from_date" id="from_date" autocomplete="off" onkeydown="return false" required>
          </div>

         
         
          
          <script>
          $("#from_date").change(function () {
              var from_date = $(this).val();
              console.log(from_date);
              


              if(from_date) {
                  console.log(from_date);

                  $.ajax({
                      url: "check-appointment-if-taken.php",
                      type: "POST",
                      data: { date: from_date, appointment_type: "Dental"},
                      success: function(data) {
                          
                          console.log(data);
                          $('#from_time').empty();
                         
                          $.each(JSON.parse(data), function(key, value) {
                              $('#from_time').append('<option value="'+ key +'">'+ value +'</option>');
                          });
                      }
                  });


              }else{
                  console.log("Failed");
                  $('#from_time').empty();
              }
          });
          </script>
          
          <div class="col">
            <label>Time</label>
            <select name="from_time" class="form-control" id="from_time" required>
              <!-- <option value="8:00:00">8:00 AM - 8:30 AM</option>
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
              <option value="16:30:00">4:30 PM - 5:00 PM</option> -->
            </select>
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
    $(function() {
        $("#dental_appointment_history").DataTable();
    });
</script>



<?php include_once("layouts/footer.php") ?>