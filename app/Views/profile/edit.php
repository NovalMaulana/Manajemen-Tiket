<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('profile') ?>">Profile</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-edit"></i> Form Edit Profile
              </h3>
            </div>
            <form action="<?= base_url('profile/update') ?>" method="post">
              <div class="card-body">
                <div class="form-group">
                  <label for="full_name">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name', $user['full_name']) ?>" required>
                  <?php if(isset(session()->getFlashdata('errors')['full_name'])): ?>
                    <small class="text-danger"><?= session()->getFlashdata('errors')['full_name'] ?></small>
                  <?php endif; ?>
                </div>

                <div class="form-group">
                  <label for="username">Username <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user['username']) ?>" required>
                  <?php if(isset(session()->getFlashdata('errors')['username'])): ?>
                    <small class="text-danger"><?= session()->getFlashdata('errors')['username'] ?></small>
                  <?php endif; ?>
                </div>

                <div class="form-group">
                  <label for="email">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
                  <?php if(isset(session()->getFlashdata('errors')['email'])): ?>
                    <small class="text-danger"><?= session()->getFlashdata('errors')['email'] ?></small>
                  <?php endif; ?>
                </div>

                <div class="form-group">
                  <label for="role_id">Role</label>
                  <input type="text" class="form-control" value="<?= ucfirst(str_replace('_', ' ', $user['role_name'])) ?>" readonly>
                  <small class="text-muted">Role tidak dapat diubah</small>
                </div>

                <hr>

                <div class="form-group">
                  <label for="password">Password Baru</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                  <?php if(isset(session()->getFlashdata('errors')['password'])): ?>
                    <small class="text-danger"><?= session()->getFlashdata('errors')['password'] ?></small>
                  <?php endif; ?>
                  <small class="text-muted">Minimal 6 karakter</small>
                </div>

                <div class="form-group">
                  <label for="confirm_password">Konfirmasi Password Baru</label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password baru">
                  <?php if(isset(session()->getFlashdata('errors')['confirm_password'])): ?>
                    <small class="text-danger"><?= session()->getFlashdata('errors')['confirm_password'] ?></small>
                  <?php endif; ?>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
                  <i class="fas fa-arrow-left"></i> Kembali
                </a>
              </div>
            </form>
          </div>
        </div>

        <div class="col-md-4">
          <!-- Profile Info -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-info-circle"></i> Informasi Profile
              </h3>
            </div>
            <div class="card-body">
              <div class="text-center mb-3">
                <div class="profile-user-img img-fluid img-circle" style="width: 80px; height: 80px; background-color: #3b82f6; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                  <i class="fas fa-user" style="font-size: 30px; color: white;"></i>
                </div>
                <h5 class="mt-2"><?= $user['full_name'] ?></h5>
                <span class="badge badge-<?= $user['role_name'] === 'admin' ? 'danger' : ($user['role_name'] === 'event_organizer' ? 'warning' : 'info') ?>">
                  <?= ucfirst(str_replace('_', ' ', $user['role_name'])) ?>
                </span>
              </div>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Username</b> <span class="float-right"><?= $user['username'] ?></span>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <span class="float-right"><?= $user['email'] ?></span>
                </li>
                <li class="list-group-item">
                  <b>Bergabung</b> <span class="float-right"><?= date('d M Y', strtotime($user['created_at'])) ?></span>
                </li>
              </ul>
            </div>
          </div>

          <!-- Tips -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-lightbulb"></i> Tips
              </h3>
            </div>
            <div class="card-body">
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success"></i> Pastikan email valid</li>
                <li><i class="fas fa-check text-success"></i> Username harus unik</li>
                <li><i class="fas fa-check text-success"></i> Password minimal 6 karakter</li>
                <li><i class="fas fa-check text-success"></i> Kosongkan password jika tidak ingin mengubah</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?> 