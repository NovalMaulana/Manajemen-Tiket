<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Beli Tiket</h3>
        <div class="card-tools">
          <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <h4><?= $event['event_name'] ?></h4>
            <p class="text-muted"><?= $event['description'] ?></p>
            
            <div class="info-box bg-light mb-3">
              <span class="info-box-icon bg-info"><i class="fas fa-calendar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Tanggal & Waktu</span>
                <span class="info-box-number"><?= date('d/m/Y', strtotime($event['event_date'])) ?></span>
                <span class="info-box-number"><?= date('H:i', strtotime($event['event_time'])) ?> WIB</span>
              </div>
            </div>
            
            <div class="info-box bg-light mb-3">
              <span class="info-box-icon bg-success"><i class="fas fa-map-marker-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Lokasi</span>
                <span class="info-box-number"><?= $event['venue'] ?></span>
              </div>
            </div>
            
            <div class="info-box bg-light mb-3">
              <span class="info-box-icon bg-warning"><i class="fas fa-ticket-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Tiket Tersedia</span>
                <span class="info-box-number"><?= number_format($event['available_tickets']) ?> tiket</span>
              </div>
            </div>
            
            <div class="info-box bg-light">
              <span class="info-box-icon bg-danger"><i class="fas fa-money-bill-wave"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Harga per Tiket</span>
                <span class="info-box-number">Rp <?= number_format($event['price']) ?></span>
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <form action="<?= base_url('tickets/purchase/' . $event['event_id']) ?>" method="post">
              <div class="form-group">
                <label for="quantity">Jumlah Tiket</label>
                <input type="number" class="form-control" id="quantity" name="quantity" 
                       min="1" max="<?= $event['available_tickets'] ?>" value="1" required>
                <small class="form-text text-muted">Maksimal <?= number_format($event['available_tickets']) ?> tiket</small>
              </div>
              
              <div class="form-group">
                <label>Total Harga</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                  </div>
                  <input type="text" class="form-control" id="totalPrice" readonly 
                         value="<?= number_format($event['price']) ?>">
                </div>
              </div>
              
              <div class="alert alert-info">
                <h6><i class="fas fa-info-circle"></i> Informasi Pembayaran</h6>
                <ul class="mb-0">
                  <li>Pembayaran dilakukan setelah pemesanan</li>
                  <li>Status tiket akan "Menunggu Pembayaran"</li>
                  <li>Setelah pembayaran, status berubah menjadi "Lunas"</li>
                </ul>
              </div>
              
              <button type="submit" class="btn btn-primary btn-lg btn-block">
                <i class="fas fa-shopping-cart"></i> Beli Tiket
              </button>
            </form>
          </div>
        </div>
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
        <p><strong>Kapasitas:</strong> <?= number_format($event['total_tickets']) ?> orang</p>
        <p><strong>Tersisa:</strong> <?= number_format($event['available_tickets']) ?> tiket</p>
        <p><strong>Terjual:</strong> <?= number_format($event['total_tickets'] - $event['available_tickets']) ?> tiket</p>
        
        <hr>
        
        <h6>Persentase Terjual</h6>
        <div class="progress">
          <?php $percentage = $event['total_tickets'] > 0 ? (($event['total_tickets'] - $event['available_tickets']) / $event['total_tickets']) * 100 : 0; ?>
          <div class="progress-bar bg-success" style="width: <?= $percentage ?>%"></div>
        </div>
        <small class="text-muted"><?= number_format($percentage, 1) ?>% terjual</small>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(document).ready(function() {
  // Update total price when quantity changes
  $('#quantity').on('input', function() {
    var quantity = parseInt($(this).val()) || 0;
    var pricePerTicket = <?= $event['price'] ?>;
    var totalPrice = quantity * pricePerTicket;
    
    $('#totalPrice').val(totalPrice.toLocaleString('id-ID'));
  });
});
</script>
<?= $this->endSection() ?> 