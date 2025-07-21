<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Profile Saya</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-md-4">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <div class="profile-user-img img-fluid img-circle" style="width: 100px; height: 100px; background-color: #3b82f6; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                  <i class="fas fa-user" style="font-size: 40px; color: white;"></i>
                </div>
              </div>

              <h3 class="profile-username text-center"><?= $user['full_name'] ?></h3>
              <p class="text-muted text-center">
                <span class="badge badge-<?= $user['role_name'] === 'admin' ? 'danger' : ($user['role_name'] === 'event_organizer' ? 'warning' : 'info') ?>">
                  <?= ucfirst(str_replace('_', ' ', $user['role_name'])) ?>
                </span>
              </p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Username</b> <a class="float-right"><?= $user['username'] ?></a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="float-right"><?= $user['email'] ?></a>
                </li>
                <li class="list-group-item">
                  <b>Bergabung Sejak</b> <a class="float-right"><?= date('d M Y', strtotime($user['created_at'])) ?></a>
                </li>
              </ul>

              <div class="text-center">
                <a href="<?= base_url('profile/edit') ?>" class="btn btn-primary btn-sm">
                  <i class="fas fa-edit"></i> Edit Profile
                </a>
                <a href="<?= base_url('profile/change-password') ?>" class="btn btn-secondary btn-sm">
                  <i class="fas fa-key"></i> Ganti Password
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <!-- Profile Details -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-info-circle"></i> Informasi Detail
              </h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="info-box">
                    <div class="info-box-icon bg-primary">
                      <i class="fas fa-user"></i>
                    </div>
                    <div class="info-box-content">
                      <span class="info-box-text">Nama Lengkap</span>
                      <span class="info-box-number"><?= $user['full_name'] ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="info-box">
                    <div class="info-box-icon bg-success">
                      <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-box-content">
                      <span class="info-box-text">Email</span>
                      <span class="info-box-number"><?= $user['email'] ?></span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="info-box">
                    <div class="info-box-icon bg-warning">
                      <i class="fas fa-user-tag"></i>
                    </div>
                    <div class="info-box-content">
                      <span class="info-box-text">Username</span>
                      <span class="info-box-number"><?= $user['username'] ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="info-box">
                    <div class="info-box-icon bg-info">
                      <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="info-box-content">
                      <span class="info-box-text">Role</span>
                      <span class="info-box-number"><?= ucfirst(str_replace('_', ' ', $user['role_name'])) ?></span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="info-box">
                    <div class="info-box-icon bg-secondary">
                      <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="info-box-content">
                      <span class="info-box-text">Tanggal Bergabung</span>
                      <span class="info-box-number"><?= date('d M Y', strtotime($user['created_at'])) ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="info-box">
                    <div class="info-box-icon bg-dark">
                      <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-box-content">
                      <span class="info-box-text">Waktu Bergabung</span>
                      <span class="info-box-number"><?= date('H:i', strtotime($user['created_at'])) ?> WIB</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Role Specific Information -->
          <?php if ($user['role_name'] === 'admin'): ?>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-crown"></i> Informasi Admin
                </h3>
              </div>
              <div class="card-body">
                <p class="text-muted">
                  Sebagai Administrator, Anda memiliki akses penuh ke semua fitur sistem termasuk:
                </p>
                <ul class="list-unstyled">
                  <li><i class="fas fa-check text-success"></i> Manajemen User</li>
                  <li><i class="fas fa-check text-success"></i> Manajemen Event</li>
                  <li><i class="fas fa-check text-success"></i> Monitoring Tiket</li>
                  <li><i class="fas fa-check text-success"></i> Laporan Sistem</li>
                </ul>
              </div>
            </div>
          <?php elseif ($user['role_name'] === 'event_organizer'): ?>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-calendar-plus"></i> Informasi Event Organizer
                </h3>
              </div>
              <div class="card-body">
                <p class="text-muted">
                  Sebagai Event Organizer, Anda dapat mengelola event yang Anda buat:
                </p>
                <ul class="list-unstyled">
                  <li><i class="fas fa-check text-success"></i> Membuat Event Baru</li>
                  <li><i class="fas fa-check text-success"></i> Mengelola Event</li>
                  <li><i class="fas fa-check text-success"></i> Monitoring Penjualan Tiket</li>
                  <li><i class="fas fa-check text-success"></i> Laporan Event</li>
                </ul>
              </div>
            </div>
          <?php else: ?>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-ticket-alt"></i> Informasi Customer
                </h3>
              </div>
              <div class="card-body">
                <p class="text-muted">
                  Sebagai Customer, Anda dapat:
                </p>
                <ul class="list-unstyled">
                  <li><i class="fas fa-check text-success"></i> Melihat Event Tersedia</li>
                  <li><i class="fas fa-check text-success"></i> Membeli Tiket</li>
                  <li><i class="fas fa-check text-success"></i> Melihat Riwayat Pembelian</li>
                  <li><i class="fas fa-check text-success"></i> Mengelola Profile</li>
                </ul>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?> 