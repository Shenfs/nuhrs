<?php 
$page_title = "MANAGE NOTIFICATION";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2 border border-rounded ">
    <div class="row mt-2 mb-2">
        
        <div class="col d-flex align-item-center justify-content-end ">
            <form action="../Controller/SMSController.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $active_id ?>">
                <button type="submit" class="btn btn-success btn-sm mr-3" name="send_all_sms">Send All SMS</button>
            </form>
            <form action="../Controller/EmailController.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $active_id ?>">
                <button type="submit" class="btn btn-primary btn-sm mr-3" name="send_all_notif">Send All Emails</button>
            </form>
        </div>
    </div>
    <div class="row  px-3">
        
        <div class="col">
            <h3 class="font-weight-bold text-dark" style="width: 90%;">Notification</h3>
            <table id="send_notif" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <!-- <th class="d-flex align-items-center justify-content-center p-4">
                            <input type="checkbox" name="" id="selectAll" class="form-check-input text-center">
                        </th> -->
                        <th>Appointment ID</th>
                        <th>Patient</th>
                        <th>Appointment Date and Time</th>
                        <th>Medical Professional</th>
                        <th>Appointment Type</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                 
                <?php 
                
                $selectApproachedAppointment = mysqli_query($conn,"SELECT *, appointment.id AS appointment_id, ut2.firstName AS stud_first_name, ut2.lastName AS stud_last_name, ut1.firstName AS med_first_name, ut1.lastName AS med_last_name,  students.contact_number AS stud_contact_number, ut2.email_address AS stud_email, ut2.id AS ut2_id FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON students.id = appointment.student_id INNER JOIN users AS ut1 ON ut1.id = medicalprofessional.userID INNER JOIN users AS ut2 ON ut2.id = students.userID WHERE YEAR(from_date) = YEAR(NOW()) AND MONTH(from_date) = MONTH(NOW()) AND DAY(from_date) >= DAY(NOW()) AND appointment.status IN ('Approved','Rescheduled')  ORDER BY from_date ASC");

                while($row = $selectApproachedAppointment->fetch_assoc()):?>
                <tr>
                    <td><?php echo $row['appointment_id'] ?></td>
                    <td><?php echo $row['stud_first_name']." ".$row['stud_last_name'] ?></td>
                    <td><?php echo date("M-d-Y",strtotime($row['from_date']))." ".date("h:i",strtotime($row['from_time']))."-".date("h:i A",strtotime($row['to_time'])) ?></td>
                    <td><?php echo "Dr. ".$row['med_first_name']." ".$row['med_last_name'] ?></td>
                    <td><?php echo $row['appointment_type'] ?></td>
                    <td>
                    <div class="d-flex align-items-center justify-content-around">
                        <div data-toggle="tooltip"  data-placement="bottom" title="Send SMS">
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#sendSMSModal<?php echo $row['appointment_id'];?>"><i class="fas fa-sms"></i></button>
                        </div>
                        <div data-toggle="tooltip"  data-placement="bottom" title="Send Email">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sendEmailModal<?php echo $row['appointment_id'];?>"><i class="fas fa-envelope"></i></button> 
                        </div>
                    </div>
                    </td>
                </tr>

                <!-- Send Email Modal -->
                <div class="modal fade" id="sendEmailModal<?php echo $row['appointment_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Send Notification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form action="../Controller/EmailController.php" method="POST">
                    <div class="row">
                        <div class="col">
                            <input type="hidden" name="user_id" value="<?php echo $row['ut2_id'] ?>">
                            <label>Student</label>
                            <input type="text" name="student_name" class="form-control" value="<?php  echo $row['stud_first_name']." ".$row['stud_last_name']?>" readonly>
                        </div>
                        <div class="col">
                            <label>Program/Year/Section</label>
                            <input type="text" name="" class="form-control" value="<?php 
                            switch($row['courseID']){
                                case "1" : echo "BS Accountacy"; break; 
                                case "2" : echo "BS Architecture"; break; 
                                case "3" : echo "BSBA Major in Financial Management"; break; 
                                case "4" : echo "BSBA Major in Marketing Management"; break; 
                                case "5" : echo "BS Civil Engineering"; break; 
                                case "6" : echo "BS Computer Engineering"; break; 
                                case "7" : echo "BS Hospitality Management"; break; 
                                case "8" : echo "BS Psychology"; break; 
                                case "9" : echo "BS Tourism Management"; break; 
                                case "10" : echo "BS Information Technology"; break; 
                                case "11" : echo "Master in Management with Specialization in Bussiness Analytics"; break; 
                                case "12" : echo "ABM"; break; 
                                case "13" : echo "HUMSS"; break; 
                                case "14" : echo "STEM"; break; 
                                default : echo "Something went wrong";
                            }
                            echo " ".$row['year']."-".$row['section'];
                            ?>
                            " readonly>
                            
                        </div>
                        
                        
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Email</label>
                            <input type="email" name="receiver" class="form-control" value="<?php echo $row['stud_email'] ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        
                        <div class="col">
                        <label for="">Message</label>
                            <textarea name="message" class="form-control" cols="10" rows="5">Hi <?php echo $row['stud_first_name']." ".$row['stud_last_name']?>, your schedule of appointment is on <?php echo date("M-d-Y",strtotime($row['from_date']))." ".date("h:i",strtotime($row['from_time']))."-".date("h:i A",strtotime($row['to_time'])) ?> at the NU Fairview Clinic, Thankyou</textarea>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="send_email" class="btn btn-primary">Send</button>
                    </form>
                    </div>
                    </div>
                </div>
                </div>
                <!-- Send Email Modal -->


                <!-- Send SMS Modal -->
                <div class="modal fade" id="sendSMSModal<?php echo $row['appointment_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Send Notification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form action="../Controller/SMSController.php" method="POST">
                    <div class="row">
                        <div class="col">
                            <input type="hidden" name="user_id" value="<?php echo $row['ut2_id'] ?>">
                            <label>Student</label>
                            <input type="text" name="student_name" class="form-control" value="<?php  echo $row['stud_first_name']." ".$row['stud_last_name']?>" readonly>
                        </div>
                        <div class="col">
                            <label>Program/Year/Section</label>
                            <input type="text" name="" class="form-control" value="<?php 
                            switch($row['courseID']){
                                case "1" : echo "BS Accountacy"; break; 
                                case "2" : echo "BS Architecture"; break; 
                                case "3" : echo "BSBA Major in Financial Management"; break; 
                                case "4" : echo "BSBA Major in Marketing Management"; break; 
                                case "5" : echo "BS Civil Engineering"; break; 
                                case "6" : echo "BS Computer Engineering"; break; 
                                case "7" : echo "BS Hospitality Management"; break; 
                                case "8" : echo "BS Psychology"; break; 
                                case "9" : echo "BS Tourism Management"; break; 
                                case "10" : echo "BS Information Technology"; break; 
                                case "11" : echo "Master in Management with Specialization in Bussiness Analytics"; break; 
                                case "12" : echo "ABM"; break; 
                                case "13" : echo "HUMSS"; break; 
                                case "14" : echo "STEM"; break; 
                                default : echo "Something went wrong";
                            }
                            echo " ".$row['year']."-".$row['section'];
                            ?>
                            " readonly>
                            
                        </div>
                        
                        
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Contact Number</label>
                            <input type="text" name="receiver" class="form-control" value="<?php echo $row['stud_contact_number'] ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        
                        <div class="col">
                        <label for="">Message</label>
                            <textarea name="message" class="form-control" cols="10" rows="5">Hi <?php echo $row['stud_first_name']." ".$row['stud_last_name']?>, your schedule of appointment is on <?php echo date("M-d-Y",strtotime($row['from_date']))." ".date("h:i",strtotime($row['from_time']))."-".date("h:i A",strtotime($row['to_time'])) ?> at the NU Fairview Clinic, Thankyou</textarea>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="send_sms" class="btn btn-primary">Send</button>
                    </form>
                    </div>
                    </div>
                </div>
                </div>
                <!-- Send SMS Modal -->

                <?php endwhile;?>
                    
                </tbody>
                
            </table>
        </div>
    </div>



    <div class="row px-3 mt-2">
        
        <div class="col">
            <h3 class="font-weight-bold text-dark" style="width: 90%;">Notification Logs</h3>
            <table id="notif_logs" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <!-- <th class="d-flex align-items-center justify-content-center p-4">
                            <input type="checkbox" name="" id="selectAll" class="form-check-input text-center">
                        </th> -->
                        <th>Stduent Name</th>
                       
                        <th>Course</th>
                        <th>Year</th>
                        <th>Section</th>
                        <th>Channel</th>
                        <th>Date and Time</th>
                        <th>Status</th> 
                    </tr>
                </thead>
                <tbody>
                <?php 
                $selectNotificationLogs = mysqli_query($conn,"SELECT *,notification_logs.status AS notif_status  FROM notification_logs INNER JOIN students ON students.userID = notification_logs.user_id INNER JOIN users ON students.userID = users.id");
                while($row = $selectNotificationLogs->fetch_assoc()){
                ?>
                    <tr>
                        <td><?php echo $row['firstName']."".$row['middleName']." ".$row['lastName']; ?></td>
                        <td>
                            <?php 
                            switch($row['courseID']){
                              case "1" : echo "BS Accountacy"; break; 
                              case "2" : echo "BS Architecture"; break; 
                              case "3" : echo "BSBA Major in Financial Management"; break; 
                              case "4" : echo "BSBA Major in Marketing Management"; break; 
                              case "5" : echo "BS Civil Engineering"; break; 
                              case "6" : echo "BS Computer Engineering"; break; 
                              case "7" : echo "BS Hospitality Management"; break; 
                              case "8" : echo "BS Psychology"; break; 
                              case "9" : echo "BS Tourism Management"; break; 
                              case "10" : echo "BS Information Technology"; break; 
                              case "11" : echo "Master in Management with Specialization in Bussiness Analytics"; break; 
                              case "12" : echo "ABM"; break; 
                              case "13" : echo "HUMSS"; break; 
                              case "14" : echo "STEM"; break; 
                              default : echo "Something went wrong";
                          }?>
                        </td>
                        <td><?php echo $row['year']; ?></td>
                        <td><?php echo $row['section']; ?></td>
                        <td><?php echo $row['channel']; ?></td>
                        <td><?php echo date('M-d-Y h:i A',strtotime($row['date_time']));?></td>
                        <td><?php echo $row['notif_status'];?></td>
                    </tr>
                <?php } ?>
                    
                </tbody>
                
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
    $('#notif_logs').DataTable();
});
</script>






<?php include_once("layouts/footer.php") ?>