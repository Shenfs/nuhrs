
<?php
include_once("../db-connection.php");
?>
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-key"></i> Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../Controller/ProfileController.php" method="post">
          <input type="hidden" name="id" value="<?php echo $active_id ?>" required>
          <input type="hidden" name="user_type_id" value="<?php echo $active_user_type_id ?>" required>
        <div class="row">
          <div class="col">
            <label>Current Password</label>
            <div class="input-group-append">
            <input type="password" name="old_password" id="old_password" class="form-control mr-1" required>
                <span class="input-group-text" onclick="old_password_show_hide();">
                  <i class="fas fa-eye" id="old_show_eye"></i>
                  <i class="fas fa-eye-slash d-none" id="old_hide_eye"></i>
                </span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label>New Password</label>
            <div class="input-group-append">
            <input type="password" name="new_password" id="new_password" class="form-control mr-1" required>
                <span class="input-group-text" onclick="new_password_show_hide();">
                  <i class="fas fa-eye" id="new_show_eye"></i>
                  <i class="fas fa-eye-slash d-none" id="new_hide_eye"></i>
                </span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label>Confirm New Password</label>
            <div class="input-group-append">
            <input type="password" name="confirm_password" id="confirm_password" class="form-control mr-1" required>
                <span class="input-group-text" onclick="confirm_password_show_hide();">
                  <i class="fas fa-eye" id="confirm_show_eye"></i>
                  <i class="fas fa-eye-slash d-none" id="confirm_hide_eye"></i>
                </span>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="change_password" class="btn btn-primary">Change</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Change Password Modal -->

<!-- Change Avatar Modal -->
<div class="modal fade" id="changeAvatarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></i> Change Avatar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../Controller/ProfileController.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo $active_id ?>" required>
          <input type="hidden" name="user_type_id" value="<?php echo $active_user_type_id ?>" required>
        <div class="row">
          <div class="col">
            <label>File</label>
            <input type="file" name="file" class="form-control" accept="image/*">
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="change_avatar" class="btn btn-primary">Change</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Change Avatar Modal -->

