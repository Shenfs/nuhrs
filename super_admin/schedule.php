<?php 
$page_title = "SCHEDULE";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2 border border-rounded ">

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
                        
                        
                    </tr>
                </thead>
                <tbody>
                 
                <?php 
                $selectMedSched = mysqli_query($conn,"SELECT *, schedule.id AS sched_id FROM schedule INNER JOIN medicalprofessional ON schedule.medprofID = medicalprofessional.id INNER JOIN users ON users.id = medicalprofessional.userID");

                while($row = $selectMedSched->fetch_assoc()):?>
                <tr>
                    <td><?php echo "Dr. ".$row['firstName']." ".$row['lastName']; ?></td>
                    <td><?php echo $row['specialization'] ?></td>
                    <td><?php echo date("M-d-Y",strtotime($row['fromSchedule']))." to ".date("M-d-Y",strtotime($row['toSchedule']))?></td>
                </tr>

                

                <?php endwhile;?>
                    
                </tbody>
                
            </table>
        </div>
        

</div>
<!-- /.container-fluid -->







<script>
$(document).ready(function () {
    $('#schedule').DataTable();
});
</script>






<?php include_once("layouts/footer.php") ?>