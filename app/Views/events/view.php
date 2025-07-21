<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Detail Event</h3>
        <div class="card-tools">
          <a href="<?= base_url('events/edit/' . $event['event_id']) ?>" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
          </a>
          <a href="<?= base_url('events') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <h4><?= $event['event_name'] ?></h4>
            <p class="text-muted"><?= $event['description'] ?></p>
            
            <div class="row mt-3">
              <div class="col-md-6">
                <div class="info-box bg-light">
                  <span class="info-box-icon bg-info"><i class="fas fa-calendar"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Tanggal & Waktu</span>
                    <span class="info-box-number"><?= date('d/m/Y', strtotime($event['event_date'])) ?></span>
                    <span class="info-box-number"><?= date('H:i', strtotime($event['event_time'])) ?> WIB</span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box bg-light">
                  <span class="info-box-icon bg-success"><i class="fas fa-map-marker-alt"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Lokasi</span>
                    <span class="info-box-number"><?= $event['venue'] ?></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-md-6">
                <div class="info-box bg-light">
                  <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Kapasitas</span>
                    <span class="info-box-number"><?= number_format($event['total_tickets']) ?> orang</span>
                    <span class="info-box-number">Terjual: <?= number_format($event['sold_tickets'] ?? 0) ?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box bg-light">
                  <span class="info-box-icon bg-danger"><i class="fas fa-ticket-alt"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Harga Tiket</span>
                    <span class="info-box-number">Rp <?= number_format($event['price']) ?></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-3">
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
              <span class="badge badge-<?= $badgeClass ?> badge-lg">Status: <?= $status ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tiket Terjual -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Tiket Terjual</h3>
      </div>
      <div class="card-body">
        <?php if(!empty($tickets)): ?>
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>ID Tiket</th>
                  <th>Pembeli</th>
                  <th>Jumlah</th>
                  <th>Total Harga</th>
                  <th>Tanggal Beli</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php foreach($tickets as $ticket): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $ticket['ticket_id'] ?></td>
                  <td><?= $ticket['buyer_name'] ?></td>
                  <td><?= $ticket['quantity'] ?></td>
                  <td>Rp <?= number_format($ticket['total_price']) ?></td>
                  <td><?= date('d/m/Y H:i', strtotime($ticket['purchase_date'])) ?></td>
                  <td>
                    <span class="badge badge-<?= $ticket['status'] == 'paid' ? 'success' : ($ticket['status'] == 'pending' ? 'warning' : 'danger') ?>">
                      <?= ucfirst($ticket['status']) ?>
                    </span>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="text-muted text-center">Belum ada tiket yang terjual untuk event ini.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Informasi Event</h3>
      </div>
      <div class="card-body">
        <p><strong>ID Event:</strong> <?= $event['event_id'] ?></p>
        <p><strong>Organizer:</strong> <?= $event['organizer_name'] ?? 'N/A' ?></p>
        <p><strong>Dibuat:</strong> <?= date('d/m/Y H:i', strtotime($event['created_at'])) ?></p>
        
        <hr>
        
        <h6>Statistik Tiket</h6>
        <div class="progress-group">
                   <span class="float-right"><b><?= $event['sold_tickets'] ?? 0 ?></b>/<?= $event['total_tickets'] ?></span>
         <span>Tiket Terjual</span>
         <div class="progress">
           <?php $percentage = $event['total_tickets'] > 0 ? (($event['sold_tickets'] ?? 0) / $event['total_tickets']) * 100 : 0; ?>
            <div class="progress-bar bg-success" style="width: <?= $percentage ?>%"></div>
          </div>
        </div>
        
        <div class="mt-3">
          <h6>Pendapatan</h6>
          <h4 class="text-success">Rp <?= number_format(($event['sold_tickets'] ?? 0) * $event['price']) ?></h4>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?> 