<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <?php if(session()->get('role_name') == 'admin'): ?>
            Daftar Semua Tiket Terjual
          <?php else: ?>
            Daftar Tiket Terjual Event Saya
          <?php endif; ?>
        </h3>
        <div class="card-tools">
          <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="ticketsTable">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Event</th>
                <th>Pembeli</th>
                <th>Jumlah Tiket</th>
                <th>Total Harga</th>
                <th>Tanggal Pembelian</th>
                <th>Status</th>
                <th width="10%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach($tickets as $ticket): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <strong><?= $ticket['event_name'] ?></strong><br>
                  <small class="text-muted">
                    <?= date('d/m/Y', strtotime($ticket['event_date'])) ?> - 
                    <?= date('H:i', strtotime($ticket['event_time'])) ?> WIB<br>
                    <?= $ticket['venue'] ?>
                  </small>
                </td>
                <td><?= $ticket['buyer_name'] ?></td>
                <td><?= number_format($ticket['quantity']) ?> tiket</td>
                <td>Rp <?= number_format($ticket['total_price']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($ticket['purchase_date'])) ?></td>
                <td>
                  <?php
                  $statusClass = [
                      'pending' => 'warning',
                      'paid' => 'success',
                      'cancelled' => 'danger'
                  ];
                  $statusText = [
                      'pending' => 'Menunggu Pembayaran',
                      'paid' => 'Lunas',
                      'cancelled' => 'Dibatalkan'
                  ];
                  ?>
                  <span class="badge badge-<?= $statusClass[$ticket['status']] ?>">
                    <?= $statusText[$ticket['status']] ?>
                  </span>
                </td>
                <td>
                  <a href="<?= base_url('events/view/' . $ticket['event_id']) ?>" class="btn btn-sm btn-info" title="Lihat Event">
                    <i class="fas fa-eye"></i>
                  </a>
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

<!-- Statistik Card -->
<div class="row">
  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fas fa-ticket-alt"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Tiket</span>
        <span class="info-box-number"><?= number_format(array_sum(array_column($tickets, 'quantity'))) ?></span>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-success"><i class="fas fa-money-bill-wave"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Pendapatan</span>
        <span class="info-box-number">Rp <?= number_format(array_sum(array_column($tickets, 'total_price'))) ?></span>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Menunggu Pembayaran</span>
        <span class="info-box-number"><?= number_format(count(array_filter($tickets, function($t) { return $t['status'] == 'pending'; }))) ?></span>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-danger"><i class="fas fa-times-circle"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Dibatalkan</span>
        <span class="info-box-number"><?= number_format(count(array_filter($tickets, function($t) { return $t['status'] == 'cancelled'; }))) ?></span>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(document).ready(function() {
  $('#ticketsTable').DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#ticketsTable_wrapper .col-md-6:eq(0)');
});
</script>
<?= $this->endSection() ?> 