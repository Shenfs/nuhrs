<?php 
$page_title = "SCHEDULE";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2 border border-rounded ">
<div class="row">
        <div class="col">
            <button class="btn btn-primary" data-toggle="modal" data-target="#schedModal">Add</button>
        </div>
    </div>
    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="font-weight-bold text-dark" style="width: 90%;">Off Duty</h3>
            </div>
        
            <table id="schedule" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Medical Professional</th>
                        <th>Specialization</th>
                        <th>Dates Not Available</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                 
                <?php 
                $selectMedSched = mysqli_query($conn,"SELECT *, schedule.id AS sched_id FROM schedule INNER JOIN medicalprofessional ON schedule.medprofID = medicalprofessional.id INNER JOIN users ON users.id = medicalprofessional.userID");

                while($row = $selectMedSched->fetch_assoc()):?>
                <tr>
                    <?php if(in_array($row['specialization'],['Nurse'])){ ?>
                      <td><?php echo $row['firstName']." ".$row['lastName']; ?></td>
                    <?php }
                    else{ ?>
                      <td><?php echo "Dr. ".$row['firstName']." ".$row['lastName']; ?></td>
                    <?php }?>
                    
                    <td><?php echo $row['specialization'] ?></td>
                    <td><?php echo date("M-d-Y",strtotime($row['fromSchedule']))." to ".date("M-d-Y",strtotime($row['toSchedule']))?></td>
                    <td>
                      <div data-toggle="tooltip" data-placement="bottom" title="Edit" class="d-flex align-items-center justify-content-center">
                        <button class="btn btn-sm btn-primary mx-1" data-toggle="modal" data-target="#editSchedModal<?php echo $row['sched_id']; ?>" ><i class="fas fa-edit"></i></button>
                      </div>
                    </td>
                </tr>

                <div class="modal fade" id="editSchedModal<?php echo $row['sched_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Sched</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="../Controller/ScheduleController.php" method="post">
                      <div class="row">
                        <input type="hidden" name="user_id" value="<?php echo $active_id ?>">
                        <input type="hidden" name="sched_id" value="<?php echo $row['sched_id']; ?>">
                        <div class="col">
                            <label>From</label>
                            <input type="date" name="fromSchedule"  class="form-control" required min="<?php echo date('Y-m-d') ?>" value="<?php echo $row['fromSchedule'] ?>">
                        </div>
                        <div class="col">
                            <label>To</label>
                            <input type="date" name="toSchedule"  class="form-control" required min="<?php echo date('Y-m-d') ?>" value="<?php echo $row['toSchedule'] ?>">
                        </div>
                      </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="edit_schedule" class="btn btn-primary">Update</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                

               

                <?php endwhile;?>
                    
                </tbody>
                
            </table>
        </div>
        

</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="schedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Sched</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../Controller/ScheduleController.php" method="post">
       <div class="row">
        <input type="hidden" name="user_id" value="<?php echo $active_id ?>">
        <input type="hidden" name="med_prof_id" value="<?php echo $active_med_prof_id; ?>">
        <div class="col">
            <label>From</label>
            <input type="date" name="fromSchedule" class="form-control" id="addFromDate" required min="<?php echo date('Y-m-d') ?>">
        </div>
        <div class="col">
            <label>To</label>
            <input type="date" name="toSchedule" class="form-control" id="addToDate" required min="<?php echo date('Y-m-d') ?>" >
        </div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add_schedule" class="btn btn-primary">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $("#addToDate").change(function() {
      var startDate = document.getElementById("addFromDate").value;
      var endDate = document.getElementById("addToDate").value;

      if ((Date.parse(endDate) <= Date.parse(startDate))) {
      alert("To date should be greater than From date");
      document.getElementById("addToDate").value = "";
      }
  });
</script>



<script>
$(document).ready(function () {
    $('#schedule').DataTable();
});
</script>






<?php include_once("layouts/footer.php") ?>