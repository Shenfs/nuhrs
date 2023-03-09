<?php 
$page_title = "LAB RESULT";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2 border border-rounded ">
    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="font-weight-bold text-dark" style="width: 90%;">Lab Result</h3>
            </div>
        
            <table id="lab_result" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Medical Professional</th>
                        <th>Findings Description</th>
                        <th>Diagnosis</th>
                        <th>Date of Lab Testing</th>
                        <th>Date Approved</th>
                        <th>Date Uploaded</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 
                <?php 
                $selectLabRecords = mysqli_query($conn,"SELECT *,laboratoryresult.id AS lab_record_id, u1.firstName AS med_first_name, u1.lastName AS med_last_name, u2.firstName as stud_first_name, u2.lastName as stud_last_name, laboratoryresult.status AS lab_status FROM laboratoryresult INNER JOIN medicalhealthrecord ON laboratoryresult.mhrIDnum = medicalhealthrecord.id INNER JOIN medicalprofessional ON medicalhealthrecord.med_prof_id = medicalprofessional.id INNER JOIN students ON students.id = medicalhealthrecord.student_id INNER JOIN users AS u1 ON medicalprofessional.userID = u1.id INNER JOIN users AS u2 ON students.userID = u2.id WHERE laboratoryresult.status IN ('Pending','Approved','Not Set','Rejected') ");

                while($row = $selectLabRecords->fetch_assoc()):?>
                <tr>
                    <td><?php echo $row['stud_first_name']." ".$row['stud_last_name']; ?></td>
                    <td><?php echo $row['med_first_name']." ".$row['med_last_name']; ?></td>
                    <td><?php echo $row['findingsdescription']?></td>
                    <td><?php echo $row['diagnosis']?></td>
                    <td><?php echo $row['date_of_lab_testing']?></td>
                    <td><?php 
                        if(in_array($row['lab_status'],['Approved'])){
                            echo $row['date_approved'];
                        }
                        else{
                            echo "Not Applicable";
                        }
                    ?></td>
                    <td><?php echo $row['date_created'] ?></td>
                    <td><?php echo $row['lab_status'] ?></td>
                    <td>
                        <div class="d-flex align-items-center justify-content-around">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewFile<?php echo $row['lab_record_id']?>"  <?php echo (in_array($row['lab_status'],['Not Set'])) ? 'disabled' : '' ?>><i class="fas fa-eye"></i></button>
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveFile<?php echo $row['lab_record_id']?>" <?php echo (in_array($row['lab_status'],['Approved','Rejected','Not Set'])) ? 'disabled' : '' ?>><i class="fas fa-check"></i></button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectFile<?php echo $row['lab_record_id']?>" <?php echo (in_array($row['lab_status'],['Not Set','Approved','Rejected'])) ? 'disabled' : '' ?>><i class="fa fa-times-circle"></i></button>
                        </div>
                    </td>
                </tr>
                

                <!--View Modal -->
                <div class="modal fade" id="viewFile<?php echo $row['lab_record_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['uploadfile']); ?>" height="500" width="600">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>

                <!--Approved Modal -->
                <div class="modal fade" id="approveFile<?php echo $row['lab_record_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approved Lab Result</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controller/LabResultController.php" method="POST">
                            <input type="hidden" name="lab_record_id" value="<?php echo $row['lab_record_id'] ?>" required>
                        <div class="d-flex align-items-center justify-content-center">
                           <h3>Are you sure you want to approve?</h3>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="approved_lab_result">Yes</button>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                    </div>
                </div>
                </div>

                <!--Reject Modal -->
                <div class="modal fade" id="rejectFile<?php echo $row['lab_record_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reject Lab Result</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controller/LabResultController.php" method="POST">
                            <input type="hidden" name="lab_record_id" value="<?php echo $row['lab_record_id'] ?>" required>
                        <div class="d-flex align-items-center justify-content-center">
                           <h3>Are you sure you want to reject?</h3>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="reject_lab_result">Yes</button>
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
    $('#lab_result').DataTable();
});
</script>






<?php include_once("layouts/footer.php") ?>