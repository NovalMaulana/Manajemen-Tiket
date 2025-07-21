<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Edit Event</h3>
      </div>
      <form action="<?= base_url('events/update/' . $event['event_id']) ?>" method="post">
        <div class="card-body">
          <div class="form-group">
            <label for="title">Judul Event <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="title" name="title" value="<?= old('title', $event['event_name']) ?>" required>
            <?php if(session()->getFlashdata('errors')['title'] ?? false): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['title'] ?></small>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="description">Deskripsi Event <span class="text-danger">*</span></label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?= old('description', $event['description']) ?></textarea>
            <?php if(session()->getFlashdata('errors')['description'] ?? false): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['description'] ?></small>
            <?php endif; ?>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="event_date">Tanggal Event <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="event_date" name="event_date" value="<?= old('event_date', $event['event_date']) ?>" required>
                <?php if(session()->getFlashdata('errors')['event_date'] ?? false): ?>
                  <small class="text-danger"><?= session()->getFlashdata('errors')['event_date'] ?></small>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="event_time">Waktu Event <span class="text-danger">*</span></label>
                <input type="time" class="form-control" id="event_time" name="event_time" value="<?= old('event_time', $event['event_time']) ?>" required>
                <?php if(session()->getFlashdata('errors')['event_time'] ?? false): ?>
                  <small class="text-danger"><?= session()->getFlashdata('errors')['event_time'] ?></small>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="location">Lokasi Event <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="location" name="location" value="<?= old('location', $event['venue']) ?>" required>
            <?php if(session()->getFlashdata('errors')['location'] ?? false): ?>
              <small class="text-danger"><?= session()->getFlashdata('errors')['location'] ?></small>
            <?php endif; ?>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="capacity">Kapasitas <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="capacity" name="capacity" value="<?= old('capacity', $event['total_tickets']) ?>" min="1" required>
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
                  <input type="number" class="form-control" id="ticket_price" name="ticket_price" value="<?= old('ticket_price', $event['price']) ?>" min="0" required>
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
            <i class="fas fa-save"></i> Update
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
        <h3 class="card-title">Informasi Event</h3>
      </div>
      <div class="card-body">
        <p><strong>ID:</strong> <?= $event['event_id'] ?></p>
        <p><strong>Dibuat:</strong> <?= date('d/m/Y H:i', strtotime($event['created_at'])) ?></p>
        <p><strong>Tiket Terjual:</strong> <?= number_format($event['sold_tickets'] ?? 0) ?> dari <?= number_format($event['total_tickets']) ?></p>
        <p><strong>Organizer:</strong> <?= $event['organizer_name'] ?? 'N/A' ?></p>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

 