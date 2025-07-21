<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tambah Event Baru</h3>
      </div>
      <form action="<?= base_url('events/store') ?>" method="post">
        <div class="card-body">
          <div class="form-group">
            <label for="title">Judul Event <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" required>
            <?php if(session()->getFlashdata('errors')['title'] ?? false): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['title'] ?></small>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="description">Deskripsi Event <span class="text-danger">*</span></label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?= old('description') ?></textarea>
            <?php if(session()->getFlashdata('errors')['description'] ?? false): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['description'] ?></small>
            <?php endif; ?>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="event_date">Tanggal Event <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="event_date" name="event_date" value="<?= old('event_date') ?>" required>
                <?php if(session()->getFlashdata('errors')['event_date'] ?? false): ?>
                  <small class="text-danger"><?= session()->getFlashdata('errors')['event_date'] ?></small>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="event_time">Waktu Event <span class="text-danger">*</span></label>
                <input type="time" class="form-control" id="event_time" name="event_time" value="<?= old('event_time') ?>" required>
                <?php if(session()->getFlashdata('errors')['event_time'] ?? false): ?>
                  <small class="text-danger"><?= session()->getFlashdata('errors')['event_time'] ?></small>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="location">Lokasi Event <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="location" name="location" value="<?= old('location') ?>" required>
            <?php if(session()->getFlashdata('errors')['location'] ?? false): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['location'] ?></small>
            <?php endif; ?>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="capacity">Kapasitas <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="capacity" name="capacity" value="<?= old('capacity') ?>" min="1" required>
                <?php if(session()->getFlashdata('errors')['capacity'] ?? false): ?>
                  <small class="text-danger"><?= session()->getFlashdata('errors')['capacity'] ?></small>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="ticket_price">Harga Tiket <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                  </div>
                  <input type="number" class="form-control" id="ticket_price" name="ticket_price" value="<?= old('ticket_price') ?>" min="0" required>
                </div>
                <?php if(session()->getFlashdata('errors')['ticket_price'] ?? false): ?>
                  <small class="text-danger"><?= session()->getFlashdata('errors')['ticket_price'] ?></small>
                <?php endif; ?>
              </div>
            </div>
          </div>


        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
          </button>
          <a href="<?= base_url('events') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </form>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Panduan</h3>
      </div>
      <div class="card-body">
        <p><strong>Judul Event:</strong> Berikan judul yang menarik dan deskriptif</p>
        <p><strong>Deskripsi:</strong> Jelaskan detail event secara lengkap</p>
        <p><strong>Tanggal & Waktu:</strong> Pastikan tanggal tidak di masa lalu</p>
        <p><strong>Lokasi:</strong> Berikan alamat yang jelas dan mudah ditemukan</p>
        <p><strong>Kapasitas:</strong> Tentukan jumlah maksimal peserta</p>
        <p><strong>Harga Tiket:</strong> Sesuaikan dengan biaya event</p>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

 