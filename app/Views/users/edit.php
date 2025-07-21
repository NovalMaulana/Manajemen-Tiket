<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Edit User</h3>
      </div>
      <form action="<?= base_url('users/update/' . $user['user_id']) ?>" method="post">
        <div class="card-body">
          <div class="form-group">
            <label for="full_name">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name', $user['full_name']) ?>" required>
            <?php if(session()->getFlashdata('errors')['full_name'] ?? false): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['full_name'] ?></small>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
            <?php if(session()->getFlashdata('errors')['email'] ?? false): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['email'] ?></small>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="password">Password Baru (kosongkan jika tidak ingin mengubah)</label>
            <input type="password" class="form-control" id="password" name="password">
            <?php if(session()->getFlashdata('errors')['password'] ?? false): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['password'] ?></small>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="confirm_password">Konfirmasi Password Baru</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            <?php if(session()->getFlashdata('errors')['confirm_password'] ?? false): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['confirm_password'] ?></small>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="role_id">Role <span class="text-danger">*</span></label>
            <select class="form-control" id="role_id" name="role_id" required>
              <option value="">Pilih Role</option>
              <?php foreach($roles as $role): ?>
                <option value="<?= $role['role_id'] ?>" <?= old('role_id', $user['role_id']) == $role['role_id'] ? 'selected' : '' ?>>
                  <?= ucfirst(str_replace('_', ' ', $role['role_name'])) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if(session()->getFlashdata('errors')['role_id'] ?? false): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['role_id'] ?></small>
            <?php endif; ?>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update
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
        <h3 class="card-title">Informasi User</h3>
      </div>
      <div class="card-body">
        <p><strong>ID:</strong> <?= $user['user_id'] ?></p>
        <p><strong>Username:</strong> <?= $user['username'] ?></p>
        <p><strong>Dibuat:</strong> <?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></p>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?> 