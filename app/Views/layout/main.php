<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title ?? 'Event Ticket Management' ?></title>

  <!-- Google Font: Inter -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>" />
  <!-- AdminLTE -->
  <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>" />
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>" />

  <!-- Custom Formal Style -->
  <style>
    body {
      font-family: 'Inter', sans-serif !important;
      font-size: 15px;
      background-color: #f9fafb;
    }

    .main-header.navbar {
      background-color: #f8fafc !important;
      border-bottom: 1px solid #e2e8f0;
    }

    .navbar-light .navbar-nav .nav-link {
      color: #1e293b;
      font-weight: 500;
    }

    .main-sidebar {
      background-color: #1e293b; /* Navy dark sidebar */
    }

    .brand-link {
      background-color: #1e293b;
      font-weight: 600;
      font-size: 18px;
      color: #ffffff !important;
      border-bottom: 1px solid #374151;
    }

    .nav-sidebar .nav-link {
      color: #cbd5e1;
    }

    .nav-sidebar .nav-link:hover {
      background-color: #334155;
      color: #ffffff;
    }

    .nav-sidebar .nav-link.active {
      background-color: #0f172a;
      color: #ffffff;
    }

    .content-header h1 {
      font-size: 22px;
      font-weight: 600;
      color: #1e293b;
    }

    footer.main-footer {
      background-color: #f8fafc;
      color: #6b7280;
      font-size: 14px;
      border-top: 1px solid #e5e7eb;
    }

    .user-panel .info a {
      color: #e2e8f0;
      font-weight: 500;
    }

    .alert {
      font-size: 14px;
    }

    /* Card styling */
    .card {
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background-color: #f8fafc;
      border-bottom: 1px solid #e5e7eb;
      font-weight: 600;
    }

    /* Table styling */
    .table th {
      background-color: #f8fafc;
      border-color: #e5e7eb;
      font-weight: 600;
      color: #374151;
    }

    .table td {
      border-color: #e5e7eb;
      vertical-align: middle;
    }

    /* Button styling */
    .btn {
      border-radius: 6px;
      font-weight: 500;
      font-size: 14px;
    }

    .btn-sm {
      padding: 0.375rem 0.75rem;
      font-size: 13px;
    }

    /* Form styling */
    .form-control {
      border-color: #d1d5db;
      border-radius: 6px;
      font-size: 14px;
    }

    .form-control:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }

    /* Badge styling */
    .badge {
      font-size: 12px;
      font-weight: 500;
      padding: 0.375rem 0.75rem;
    }

    .badge-lg {
      font-size: 14px;
      padding: 0.5rem 1rem;
    }

    /* Info box styling */
    .info-box {
      border: 1px solid #e5e7eb;
      border-radius: 6px;
      padding: 15px;
      margin-bottom: 15px;
    }

    .info-box-icon {
      width: 50px;
      height: 50px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      float: left;
      margin-right: 15px;
    }

    .info-box-content {
      overflow: hidden;
    }

    .info-box-text {
      display: block;
      font-size: 12px;
      color: #6b7280;
      text-transform: uppercase;
      font-weight: 600;
    }

    .info-box-number {
      display: block;
      font-size: 16px;
      font-weight: 600;
      color: #1f2937;
    }

    /* Progress styling */
    .progress {
      height: 8px;
      border-radius: 4px;
      background-color: #f3f4f6;
    }

    .progress-bar {
      border-radius: 4px;
    }

    /* Custom file input */
    .custom-file-label {
      border-color: #d1d5db;
      border-radius: 6px;
    }

    .custom-file-label::after {
      background-color: #f3f4f6;
      border-left: 1px solid #d1d5db;
      color: #374151;
    }

    /* Switch styling */
    .custom-switch .custom-control-label::before {
      border-color: #d1d5db;
    }

    .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
      background-color: #3b82f6;
      border-color: #3b82f6;
    }
  </style>

  <?= $this->renderSection('css') ?>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('auth/logout') ?>" role="button">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url() ?>" class="brand-link">
        <span class="brand-text">Event Ticket</span>
      </a>

      <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <a href="#" class="d-block"><?= session()->get('full_name') ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="<?= base_url('dashboard') ?>" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <?php if(session()->get('role_name') == 'admin'): ?>
            <li class="nav-item">
              <a href="<?= base_url('users') ?>" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Manajemen User</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if(in_array(session()->get('role_name'), ['admin', 'event_organizer'])): ?>
            <li class="nav-item">
              <a href="<?= base_url('events') ?>" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>Manajemen Event</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if(session()->get('role_name') == 'customer'): ?>
            <li class="nav-item">
              <a href="<?= base_url('tickets/my-tickets') ?>" class="nav-link">
                <i class="nav-icon fas fa-ticket-alt"></i>
                <p>Tiket Saya</p>
              </a>
            </li>
            <?php endif; ?>

            <!-- Profile Menu - Available for all roles -->
            <li class="nav-item">
              <a href="<?= base_url('profile') ?>" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile Saya</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </aside>
    <!-- /.sidebar -->

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <!-- Header -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?= $title ?? 'Dashboard' ?></h1>
            </div>
          </div>
        </div>
      </div>

      <!-- Content -->
      <div class="content">
        <div class="container-fluid">
          <?php if(session()->getFlashdata('success')): ?>
          <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
          <?php endif; ?>

          <?php if(session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>

          <?= $this->renderSection('content') ?>
        </div>
      </div>
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <footer class="main-footer text-center">
      <strong>&copy; <?= date('Y') ?> Event Ticket Management.</strong> All rights reserved.
    </footer>
  </div>

  <!-- Scripts -->
  <script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
  <!-- DataTables -->
  <script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('plugins/jszip/jszip.min.js') ?>"></script>
  <script src="<?= base_url('plugins/pdfmake/pdfmake.min.js') ?>"></script>
  <script src="<?= base_url('plugins/pdfmake/vfs_fonts.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
  <!-- SweetAlert2 -->
  <script src="<?= base_url('plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
  <link rel="stylesheet" href="<?= base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <?= $this->renderSection('js') ?>
</body>
</html>
