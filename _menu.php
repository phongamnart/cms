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
      <li class="nav-item <?php if($ismenu == 0){ echo "menu-open";}?>">
          <a href="dashboard.php" class="nav-link <?php if($current_menu == "Home"){ echo "active";}?>">
          <img src="dist/img/icon/home (1).png" width="26" style="margin-right: 5px;"/>
            <p>Home
            </p>
          </a>
        </li>
        <li class="nav-item <?php if($ismenu == 1){ echo "menu-open";}?>">
          <a href="#" class="nav-link <?php if($current_menu == ""){ echo "active";}?>">
          <img src="dist/img/icon/folder.png" width="26" style="margin-right: 5px;"/>
            <p>Method Statement
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="documents_list.php" class="nav-link <?php if($current_menu == "documents_list"){ echo "active";}?>">
              <img src="dist/img/icon/new-moon.png" width="16" style="margin: 5px 10px 5px 5px;"/>
                <p>
                  Document List
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="documents.php"
                class="nav-link <?php if($current_menu == "documents"){ echo "active";}?>">
                <img src="dist/img/icon/new-moon.png" width="16" style="margin: 5px 10px 5px 5px;"/>
                <p>My Document</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="approval.php" class="nav-link <?php if($current_menu == "approval"){ echo "active";}?>">
                <img src="dist/img/icon/new-moon.png" width="16" style="margin: 5px 10px 5px 5px;"/>
                <p>Approvals</p>
              </a>
            </li>

          </ul>
        </li>
        <li class="nav-item <?php if($ismenu == 2){ echo "menu-open";}?>">
          <a href="#" class="nav-link">
          <img src="dist/img/icon/configuration.png" width="26" style="margin-right: 5px;"/>
            <p>
              Administrator
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="discipline.php" class="nav-link <?php if($current_menu == "discipline"){ echo "active";}?>">
                <img src="dist/img/icon/new-moon.png" width="16" style="margin: 5px 10px 5px 5px;"/>
                <p>Discipline</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="work.php" class="nav-link <?php if($current_menu == "work"){ echo "active";}?>">
                <img src="dist/img/icon/new-moon.png" width="16" style="margin: 5px 10px 5px 5px;"/>
                <p>
                Works
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="type.php"
                class="nav-link <?php if($current_menu == "type"){ echo "active";}?>">
                <img src="dist/img/icon/new-moon.png" width="16" style="margin: 5px 10px 5px 5px;"/>
                <p>
                  Type
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="users.php" class="nav-link <?php if($current_menu == "users"){ echo "active";}?>">
                <img src="dist/img/icon/new-moon.png" width="16" style="margin: 5px 10px 5px 5px;"/>
                <p>Users</p>
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