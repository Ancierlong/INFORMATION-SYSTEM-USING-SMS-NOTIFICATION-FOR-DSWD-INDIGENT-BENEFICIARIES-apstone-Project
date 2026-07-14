<aside class="main-sidebar elevation-4 sidebar-dark-warning">
  <!-- Brand Logo -->
  <a href="dashboard.php" class="brand-link">
    <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
    <span class="brand-text font-weight-light">BMIS</span>
  </a>

  <!-- Sidebar user panel (optional) -->

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <i class="fas fa-user elevation-2" style="color: white"></i>
        <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
      </div>
      <div class="info">

        <a href="#" class="d-block"><?= $_SESSION['user']['name']; ?></a>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link <?= basename($_SERVER["REQUEST_URI"], ".php") == 'dashboard' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <?php if ($_SESSION['user']['role'] == 3) {?>
        <li class="nav-item">
          <a href="accounts.php" class="nav-link <?= basename($_SERVER["REQUEST_URI"], ".php") == 'accounts' ? 'active' : '' ?>">
            <i class="nav-icon  fas fa-user-tie"></i>
            <p>
              Accounts
            </p>
          </a>
        </li>
        <?php }?>


        <li class="nav-item">
          <a href="notifications.php" class="nav-link <?= basename($_SERVER["REQUEST_URI"], ".php") == 'notifications' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-bell"></i>
            <p>
              Notification
            </p>
          </a>
        </li>

        <?php if ($_SESSION['user']['role'] == 3) {?>
        <li class="nav-item">
          <a href="history_log.php" class="nav-link <?= basename($_SERVER["REQUEST_URI"], ".php") == 'history_log' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-folder-open"></i>
            <p>
              History Log
            </p>
          </a>
        </li>
        <?php }?>
        <li class="nav-item">
          <a href="beneficiaries.php" class="nav-link <?= in_array(explode('?', basename($_SERVER["REQUEST_URI"], ".php"))[0], ['beneficiaries', 'beneficiary.php']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Beneficiaries
            </p>
          </a>
          </li><li class="nav-item">
          <a href="beneficiaries_inactive.php" class="nav-link <?= in_array(explode('?', basename($_SERVER["REQUEST_URI"], ".php"))[0], ['beneficiaries_inactive', 'beneficiaries_inactive.php']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-slash"></i>
            <p>
              Inactive Beneficiaries
            </p>
          </a>
        </li>

          <?php 
          if ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 3) {
          ?>
        <li class="nav-item">
          <a href="beneficiaries_pending.php" class="nav-link <?= in_array(explode('?', basename($_SERVER["REQUEST_URI"], ".php"))[0], ['beneficiaries_pending', 'beneficiaries_pending.php']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-slash"></i>
            <p>
              Pending Beneficiaries
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="beneficiaries_rejected.php" class="nav-link <?= in_array(explode('?', basename($_SERVER["REQUEST_URI"], ".php"))[0], ['beneficiaries_rejected', 'beneficiaries_rejected.php']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-slash"></i>
            <p>
              Rejected Beneficiaries
            </p>
          </a>
        </li>
          <?php
          }
          ?>

        <li class="nav-item">
          <a href="my_profile.php" class="nav-link <?= in_array(explode('?', basename($_SERVER["REQUEST_URI"], ".php"))[0], ['my_profile']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-id-badge"></i>
            <p>
              My Profile
            </p>
          </a>
        </li>

        <?php 
          if ($_SESSION['user']['role'] == 3) {
          ?>
        <li class="nav-item">
          <a href="data_setting.php" class="nav-link <?= in_array(explode('?', basename($_SERVER["REQUEST_URI"], ".php"))[0], ['data_setting', 'data_setting.php']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-slash"></i>
            <p>
              Data Setting
            </p>
          </a>
        </li>
          <?php
          }
          ?>

        <li class="nav-item">
          <a href="logout.php" class="nav-link">
            <i class="nav-icon  fas fa-door-open"></i>
            <p>
              Logout
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
