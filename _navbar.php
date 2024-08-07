
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item">
      <span class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    </li>
    <li class="nav-item dropdown">
      <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><?php echo $_SESSION['user_name'] . "  "; ?></a>
      <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
        <li><a class="dropdown-item" href="#" onclick="window.open('/cms/upload/files/manual_cms.pdf', '_blank');">Manual</a></li>
        <li><a class="dropdown-item" data-toggle="modal" data-target="#signoutModal">Sign out</a>
        </li>
      </ul>
    </li>
  </ul>
  </li>
  </ul>
</nav>
<!-- /.navbar -->

<div id="changepassModal" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card-body">
        <form method="post" id="form_changepassword">
          <div class="form-group">
            <label>New Password <em>รหัสผ่านใหม่</em></label>
            <input type="password" class="form-control" id="newpassword" name="newpassword">
          </div>
          <div class="form-group">
            <label>Confirm Password <em>ยืนยันรหัสผ่าน</em></label>
            <input type="password" class="form-control" id="confpassword" name="confpassword">
          </div>
          <div class="row col-md-12">
            <span id="message2" class="text-danger">&nbsp;</span>
          </div>
          <button type="button" class="btn btn-primary" onclick="changePassword()">Yes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="success-alert" class="alert alert-success alert-dismissible col-8 float-right modal-sm shadow-1" style="z-index:99999;position: fixed; right:15px; top:20px; max-width: 300px; display:none;">
  <h5><i class="icon fas fa-check"></i>Alert!</h5>
  Updated Successfully!
</div>

<div class="modal fade" id="signoutModal" tabindex="-1" role="dialog" aria-labelledby="signoutModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sign out</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row col-md-12">
          <p>Do you want to signout <em>Yes or No?</em></p>
        </div>
        <button type="button" class="btn btn-primary" onclick="window.location.href = 'logout.php'">Yes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="messageContent">
      </div>
    </div>
  </div>
</div>

<div id="uploadfile" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card-body">
        <form id="form_uploadfile" onsubmit="false">
          <div class="row">
            <div class="col-sm-12">
              <label>Choose file <em>เลือกไฟล์</em></label><span class="text-danger"> * file size maximum 30mb</span>
              <div class="input-group mb-3">
                <input type="file" class="form-control" id="file" name="file" required />
                <input type="hidden" class="form-control" id="id" name="id" />
                <input type="hidden" class="form-control" id="doc_id" name="doc_id" />
                <input type="hidden" class="form-control" id="type" name="type" />
                <input type="hidden" class="form-control" id="redirect" name="redirect" />
                <input type="hidden" class="form-control" id="selectSize" name="selectSize" />
                <input type="hidden" class="form-control" id="doc_no" name="doc_no" />
              </div>
            </div>
            <div class="col-sm-12">
              <button type="submit" class="btn btn-primary">Upload</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>