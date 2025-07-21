<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Ganti Password</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('profile') ?>">Profile</a></li>
            <li class="breadcrumb-item active">Ganti Password</li>
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
                <i class="fas fa-key"></i> Form Ganti Password
              </h3>
            </div>
            <form action="<?= base_url('profile/update-password') ?>" method="post">
              <div class="card-body">
                <div class="form-group">
                  <label for="current_password">Password Saat Ini <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="current_password" name="current_password" required>
                  <?php if(isset(session()->getFlashdata('errors')['current_password'])): ?>
                    <small class="text-danger"><?= session()->getFlashdata('errors')['current_password'] ?></small>
                  <?php endif; ?>
                  <small class="text-muted">Masukkan password yang sedang digunakan</small>
                </div>

                <div class="form-group">
                  <label for="new_password">Password Baru <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="new_password" name="new_password" required>
                  <?php if(isset(session()->getFlashdata('errors')['new_password'])): ?>
                    <small class="text-danger"><?= session()->getFlashdata('errors')['new_password'] ?></small>
                  <?php endif; ?>
                  <small class="text-muted">Minimal 6 karakter</small>
                </div>

                <div class="form-group">
                  <label for="confirm_password">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                  <?php if(isset(session()->getFlashdata('errors')['confirm_password'])): ?>
                    <small class="text-danger"><?= session()->getFlashdata('errors')['confirm_password'] ?></small>
                  <?php endif; ?>
                  <small class="text-muted">Masukkan ulang password baru</small>
                </div>

                <div class="alert alert-info">
                  <h5><i class="fas fa-info-circle"></i> Tips Keamanan Password</h5>
                  <ul class="mb-0">
                    <li>Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol</li>
                    <li>Minimal 8 karakter untuk keamanan yang lebih baik</li>
                    <li>Jangan gunakan informasi pribadi seperti tanggal lahir</li>
                    <li>Jangan bagikan password dengan siapapun</li>
                  </ul>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Ganti Password
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
                <i class="fas fa-user"></i> Profile Saya
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
              </ul>
            </div>
          </div>

          <!-- Security Tips -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-shield-alt"></i> Keamanan Akun
              </h3>
            </div>
            <div class="card-body">
              <div class="info-box">
                <div class="info-box-icon bg-success">
                  <i class="fas fa-check"></i>
                </div>
                <div class="info-box-content">
                  <span class="info-box-text">Password Terakhir Diubah</span>
                  <span class="info-box-number">-</span>
                </div>
              </div>
              
              <div class="info-box">
                <div class="info-box-icon bg-info">
                  <i class="fas fa-clock"></i>
                </div>
                <div class="info-box-content">
                  <span class="info-box-text">Bergabung Sejak</span>
                  <span class="info-box-number"><?= date('d M Y', strtotime($user['created_at'])) ?></span>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-bolt"></i> Aksi Cepat
              </h3>
            </div>
            <div class="card-body">
              <a href="<?= base_url('profile/edit') ?>" class="btn btn-outline-primary btn-block mb-2">
                <i class="fas fa-edit"></i> Edit Profile
              </a>
              <a href="<?= base_url('profile') ?>" class="btn btn-outline-secondary btn-block">
                <i class="fas fa-user"></i> Lihat Profile
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Password strength indicator
document.getElementById('new_password').addEventListener('input', function() {
  const password = this.value;
  const strength = checkPasswordStrength(password);
  updatePasswordStrengthIndicator(strength);
});

function checkPasswordStrength(password) {
  let score = 0;
  
  if (password.length >= 8) score++;
  if (/[a-z]/.test(password)) score++;
  if (/[A-Z]/.test(password)) score++;
  if (/[0-9]/.test(password)) score++;
  if (/[^A-Za-z0-9]/.test(password)) score++;
  
  if (score < 2) return 'weak';
  if (score < 4) return 'medium';
  return 'strong';
}

function updatePasswordStrengthIndicator(strength) {
  const indicator = document.getElementById('password-strength');
  if (!indicator) {
    const newIndicator = document.createElement('div');
    newIndicator.id = 'password-strength';
    newIndicator.className = 'mt-2';
    document.getElementById('new_password').parentNode.appendChild(newIndicator);
  }
  
  const indicator = document.getElementById('password-strength');
  let color, text;
  
  switch(strength) {
    case 'weak':
      color = 'danger';
      text = 'Lemah';
      break;
    case 'medium':
      color = 'warning';
      text = 'Sedang';
      break;
    case 'strong':
      color = 'success';
      text = 'Kuat';
      break;
  }
  
  indicator.innerHTML = `
    <small class="text-${color}">
      <i class="fas fa-${strength === 'weak' ? 'times' : strength === 'medium' ? 'minus' : 'check'}-circle"></i>
      Kekuatan Password: ${text}
    </small>
  `;
}
</script>
<?= $this->endSection() ?> 