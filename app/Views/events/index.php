<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <?php if(session()->get('role_name') == 'admin'): ?>
            Daftar Semua Event
          <?php else: ?>
            Daftar Event Saya
          <?php endif; ?>
        </h3>
        <div class="card-tools">
          <a href="<?= base_url('events/create') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Event
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="eventsTable">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Nama Event</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Kapasitas</th>
                <th>Harga Tiket</th>
                <th>Status</th>
                <th width="15%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach($events as $event): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <strong><?= $event['event_name'] ?></strong><br>
                  <small class="text-muted"><?= $event['description'] ?></small>
                </td>
                <td>
                  <?= date('d/m/Y', strtotime($event['event_date'])) ?><br>
                  <small class="text-muted"><?= date('H:i', strtotime($event['event_time'])) ?> WIB</small>
                </td>
                <td><?= $event['venue'] ?></td>
                <td>
                  <?= number_format($event['total_tickets']) ?> orang<br>
                  <small class="text-muted">Terjual: <?= number_format($event['sold_tickets'] ?? 0) ?></small>
                </td>
                <td>Rp <?= number_format($event['price']) ?></td>
                <td>
                  <?php 
                  $now = new DateTime();
                  $eventDate = new DateTime($event['event_date'] . ' ' . $event['event_time']);
                  $status = '';
                  $badgeClass = '';
                  
                                     if ($eventDate < $now) {
                     $status = 'Selesai';
                     $badgeClass = 'dark';
                   } elseif ($event['total_tickets'] <= ($event['sold_tickets'] ?? 0)) {
                     $status = 'Habis';
                     $badgeClass = 'warning';
                   } else {
                     $status = 'Aktif';
                     $badgeClass = 'success';
                   }
                  ?>
                  <span class="badge badge-<?= $badgeClass ?>"><?= $status ?></span>
                </td>
                <td>
                  <a href="<?= base_url('events/view/' . $event['event_id']) ?>" class="btn btn-sm btn-info">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="<?= base_url('events/edit/' . $event['event_id']) ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-danger" onclick="deleteEvent(<?= $event['event_id'] ?>)">
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
  $('#eventsTable').DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#eventsTable_wrapper .col-md-6:eq(0)');
});

function deleteEvent(eventId) {
  if (confirm('Apakah Anda yakin ingin menghapus event ini?')) {
    window.location.href = '<?= base_url('events/delete/') ?>' + eventId;
  }
}
</script>
<?= $this->endSection() ?> 