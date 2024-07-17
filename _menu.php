<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="dist/img/logo.svg" height="50" style="padding:6px 12px 5px 12px;">
    <span class="brand-text font-weight-light"><img src="dist/img/appname.png" width="160"></span>
  </a>


  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item <?php if($ismenu == 0){ echo "active";}?>">
          <a href="dashboard.php" class="nav-link <?php if($current_menu == "dashboard"){ echo "active";}?>">
          <img src="dist/img/icon/home (1).png" width="30" style="margin-right: 5px;"/>
            <p>Home
            </p>
          </a>
        </li>

        <li class="nav-item <?php if($ismenu == 1){ echo "menu-open";}?>">
          <a href="#" class="nav-link <?php if($current_menu == ""){ echo "active";}?>">
          <img src="dist/img/icon/folder.png" width="30" style="margin-right: 5px;"/>
            <p>Method Statement
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="documents_list.php" class="nav-link <?php if($current_menu == "documents_list"){ echo "active";}?>">
              <img src="dist/img/icon/checklist.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>Document List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="documents.php"
                class="nav-link <?php if($current_menu == "documents"){ echo "active";}?>">
                <img src="dist/img/icon/file.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>My Document</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="request.php" class="nav-link <?php if($current_menu == "request"){ echo "active";}?>">
                <img src="dist/img/icon/request.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>My Request</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item <?php if($ismenu == 2){ echo "menu-open";}?>">
          <a href="#" class="nav-link <?php if($current_menu == ""){ echo "active";}?>">
          <img src="dist/img/icon/approve_menu.png" width="30" style="margin-right: 5px;"/>
            <p>Approvals
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
              <a href="approval_create.php" class="nav-link <?php if($current_menu == "approval_create"){ echo "active";}?>">
                <img src="dist/img/icon/add.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>Create</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="approval_download.php" class="nav-link <?php if($current_menu == "approval_download"){ echo "active";}?>">
                <img src="dist/img/icon/download.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>Download</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="approval_del.php" class="nav-link <?php if($current_menu == "approval_del"){ echo "active";}?>">
                <img src="dist/img/icon/delete_menu.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>Delete</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="approval_revise.php" class="nav-link <?php if($current_menu == "approval_revise"){ echo "active";}?>">
                <img src="dist/img/icon/pen.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>Revise</p>
              </a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item <?php if($ismenu == 3){ echo "menu-open";}?>">
          <a href="#" class="nav-link">
          <img src="dist/img/icon/configuration.png" width="30" style="margin-right: 5px;"/>
            <p>
              Administrator
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="add_permission.php" class="nav-link <?php if($current_menu == "add_permission"){ echo "active";}?>">
                <img src="dist/img/icon/new-moon.png" width="16" style="margin: 5px 10px 5px 5px;"/>
                <p>Add Permission</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>