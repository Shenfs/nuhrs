<?php 
$page_title = "SCHEDULE";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2 border border-rounded ">

    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="font-weight-bold text-dark" style="width: 90%;">Activity Logs</h3>
            </div>
        
            <table id="activity_logs" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Activity</th>
                        <th>Description</th>
                        <th>Date and Time</th>
                        

                    </tr>
                </thead>
                <tbody>
                 
                <?php 
                $selectActLogs = mysqli_query($conn,"SELECT *, users.id AS user_id FROM user_activity_logs INNER JOIN users ON users.id = user_activity_logs.user_id WHERE users.user_type_id IN ('1','2')");

                while($row = $selectActLogs->fetch_assoc()):?>
                <tr>
                    <td><?php echo $row['firstName']." ".$row['lastName']; ?></td>
                    <td><?php echo $row['email_address'] ?></td>
                    <td><?php echo $row['activity']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo date('M-d-Y h:i A',strtotime($row['date_created'])); ?></td>
                </tr>

                

                <?php endwhile;?>
                    
                </tbody>
                
            </table>
        </div>
        

</div>
<!-- /.container-fluid -->







<script>
$(document).ready(function () {
    $('#activity_logs').DataTable();
});
</script>






<?php include_once("layouts/footer.php") ?>