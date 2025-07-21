<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar User</h3>
        <div class="card-tools">
          <a href="<?= base_url('users/create') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah User
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="usersTable">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th width="15%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach($users as $user): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $user['full_name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td>
                  <span class="badge badge-<?= $user['role_name'] == 'admin' ? 'danger' : ($user['role_name'] == 'event_organizer' ? 'warning' : 'info') ?>">
                    <?= ucfirst(str_replace('_', ' ', $user['role_name'])) ?>
                  </span>
                </td>
                <td>
                  <span class="badge badge-success">
                    Aktif
                  </span>
                </td>
                <td>
                  <a href="<?= base_url('users/edit/' . $user['user_id']) ?>" class="btn btn-sm btn-info">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser(<?= $user['user_id'] ?>)">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(document).ready(function() {
  $('#usersTable').DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#usersTable_wrapper .col-md-6:eq(0)');
});

function deleteUser(userId) {
  if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
    window.location.href = '<?= base_url('users/delete/') ?>' + userId;
  }
}
</script>
<?= $this->endSection() ?> 