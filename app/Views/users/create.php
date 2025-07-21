<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tambah User Baru</h3>
      </div>
      <form action="<?= base_url('users/store') ?>" method="post">
        <div class="card-body">
          <div class="form-group">
            <label for="full_name">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name') ?>" required>
            <?php if(isset(session()->getFlashdata('errors')['full_name'])): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['full_name'] ?></small>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
            <?php if(isset(session()->getFlashdata('errors')['email'])): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['email'] ?></small>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="password">Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password" name="password" required>
            <?php if(isset(session()->getFlashdata('errors')['password'])): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['password'] ?></small>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="confirm_password">Konfirmasi Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            <?php if(isset(session()->getFlashdata('errors')['confirm_password'])): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['confirm_password'] ?></small>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="role_id">Role <span class="text-danger">*</span></label>
            <select class="form-control" id="role_id" name="role_id" required>
              <option value="">Pilih Role</option>
              <?php foreach($roles as $role): ?>
                <option value="<?= $role['role_id'] ?>" <?= old('role_id') == $role['role_id'] ? 'selected' : '' ?>>
                  <?= ucfirst(str_replace('_', ' ', $role['role_name'])) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if(isset(session()->getFlashdata('errors')['role_id'])): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['role_id'] ?></small>
            <?php endif; ?>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
          </button>
          <a href="<?= base_url('users') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </form>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Informasi</h3>
      </div>
      <div class="card-body">
        <p><strong>Admin:</strong> Akses penuh ke semua fitur sistem</p>
        <p><strong>Event Organizer:</strong> Dapat mengelola event dan tiket</p>
        <p><strong>Customer:</strong> Dapat membeli dan melihat tiket</p>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?> 