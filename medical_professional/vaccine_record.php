<?php 
$page_title = "VACCINE RECORDS";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2 border border-rounded ">
    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="font-weight-bold text-dark" style="width: 90%;">Vaccine Records</h3>
            </div>
        
            <table id="vaccine_record" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Medical Professional</th>
                        <th>Disease</th>
                        <th>Description</th>
                        <th>First Dose</th>
                        <th>Second Dose</th>
                        <th>Booster</th>
                        <th>Date Approved</th>
                        <th>Date Uploaded</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 
                <?php 
                $selectLabRecords = mysqli_query($conn,"SELECT *,vaccinationrecord.id AS vaccination_record_id, u1.firstName AS med_first_name, u1.lastName AS med_last_name, u2.firstName as stud_first_name, u2.lastName as stud_last_name, vaccinationrecord.status AS vacc_status FROM vaccinationrecord INNER JOIN medicalhealthrecord ON vaccinationrecord.mhrIDnum = medicalhealthrecord.id INNER JOIN medicalprofessional ON medicalhealthrecord.med_prof_id = medicalprofessional.id INNER JOIN students ON students.id = medicalhealthrecord.student_id INNER JOIN users AS u1 ON medicalprofessional.userID = u1.id INNER JOIN users AS u2 ON students.userID = u2.id WHERE vaccinationrecord.status IN ('Pending','Approved','Not Set','Rejected') ");

                while($row = $selectLabRecords->fetch_assoc()):?>
                <tr>
                    <td><?php echo $row['stud_first_name']." ".$row['stud_last_name']; ?></td>
                    <td><?php echo $row['med_first_name']." ".$row['med_last_name']; ?></td>
                    <td><?php echo empty($row['disease']) ? "Not Set" : $row['disease']?></td>
                    <td><?php echo empty($row['description']) ? "Not Set" : $row['description']?></td>
                    <td><?php echo empty($row['firstdose']) ? "Not Set" : $row['firstdose']?></td>
                    <td><?php echo empty($row['seconddose']) ? "Not Set" : $row['seconddose']?></td>
                    <td><?php echo empty($row['boosterdate']) ? "Not Set" : $row['boosterdate']?></td>
                    <td><?php 
                        if(in_array($row['vacc_status'],['Approved'])){
                            echo $row['date_approved'];
                        }
                        else{
                            echo "Not Applicable";
                        }
                    ?></td>
                    <td><?php echo $row['date_created'] ?></td>
                    <td><?php echo $row['vacc_status'] ?></td>
                    <td>
                        <div class="d-flex align-items-center justify-content-around">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewFile<?php echo $row['vaccination_record_id']?>"  <?php echo (in_array($row['vacc_status'],['Not Set'])) ? 'disabled' : '' ?>><i class="fas fa-eye"></i></button>
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveFile<?php echo $row['vaccination_record_id']?>" <?php echo (in_array($row['vacc_status'],['Approved','Rejected','Not Set'])) ? 'disabled' : '' ?>><i class="fas fa-check"></i></button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectFile<?php echo $row['vaccination_record_id']?>" <?php echo (in_array($row['vacc_status'],['Not Set','Approved','Rejected'])) ? 'disabled' : '' ?>><i class="fa fa-times-circle"></i></button>
                        </div>
                    </td>
                </tr>
                

                <!--View Modal -->
                <div class="modal fade" id="viewFile<?php echo $row['vaccination_record_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Uploaded Lab Result</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['uploadFile']); ?>" height="500" width="600">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>

                <!--Approved Modal -->
                <div class="modal fade" id="approveFile<?php echo $row['vaccination_record_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approved Vaccine Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controller/VaccRecordController.php" method="POST">
                            <input type="hidden" name="vaccination_record_id" value="<?php echo $row['vaccination_record_id'] ?>" required>
                        <div class="d-flex align-items-center justify-content-center">
                           <h3>Are you sure you want to approve?</h3>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="approved_vacc_record">Yes</button>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                    </div>
                </div>
                </div>

                <!--Reject Modal -->
                <div class="modal fade" id="rejectFile<?php echo $row['vaccination_record_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reject Vaccine Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controller/VaccRecordController.php" method="POST">
                            <input type="hidden" name="vaccination_record_id" value="<?php echo $row['vaccination_record_id'] ?>" required>
                        <div class="d-flex align-items-center justify-content-center">
                           <h3>Are you sure you want to reject?</h3>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="reject_vacc_record">Yes</button>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                    </div>
                </div>
                </div>
                

                <?php endwhile;?>
                    
                </tbody>
                
            </table>
        </div>

        </div>
        

</div>
<!-- /.container-fluid -->





<script>
$(document).ready(function () {
    $('#vaccine_record').DataTable();
});
</script>






<?php include_once("layouts/footer.php") ?>