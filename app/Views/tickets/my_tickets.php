<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
<style>
/* Accessibility improvements for modal */
.modal[aria-hidden="true"] {
  pointer-events: none;
}

.modal[aria-hidden="true"] * {
  pointer-events: none;
}

.modal:not([aria-hidden="true"]) {
  pointer-events: auto;
}

.modal:not([aria-hidden="true"]) * {
  pointer-events: auto;
}

/* Ensure focus is visible */
.modal button:focus,
.modal input:focus,
.modal select:focus,
.modal textarea:focus {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tiket Saya</h3>
        <div class="card-tools">
          <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
          </a>
        </div>
      </div>
      <div class="card-body">
        <?php if(!empty($tickets)): ?>
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="ticketsTable">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Event</th>
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
                    <?php if($ticket['status'] == 'pending'): ?>
                      <button class="btn btn-sm btn-warning" onclick="showPaymentInfo(<?= $ticket['ticket_id'] ?>)" title="Info Pembayaran">
                        <i class="fas fa-credit-card"></i>
                      </button>
                    <?php elseif($ticket['status'] == 'paid'): ?>
                      <button class="btn btn-sm btn-success" onclick="downloadTicket(<?= $ticket['ticket_id'] ?>)" title="Download Tiket">
                        <i class="fas fa-download"></i>
                      </button>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="text-center py-5">
            <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Belum Ada Tiket</h4>
            <p class="text-muted">Anda belum memiliki tiket untuk event apapun.</p>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-primary">
              <i class="fas fa-calendar-alt"></i> Lihat Event Tersedia
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Statistik Card -->
<?php if(!empty($tickets)): ?>
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
        <span class="info-box-text">Total Pembayaran</span>
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
<?php endif; ?>

<!-- Modal Info Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">Informasi Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Silakan lakukan pembayaran melalui:</p>
        <ul>
          <li><strong>Cash:</strong> Pembayaran langsung di kantor kami</li>
          <li><strong>Bank Transfer:</strong> BCA 1234567890</li>
          <li><strong>E-Wallet:</strong> DANA, OVO, GoPay</li>
          <li><strong>Minimarket:</strong> Indomaret, Alfamart</li>
        </ul>
        <p class="text-muted">Setelah pembayaran, status tiket akan berubah menjadi "Lunas" dalam 1x24 jam.</p>
        
        <hr>
        <div class="alert alert-info">
          <h6><i class="fas fa-info-circle"></i> Informasi Pembayaran Cash:</h6>
          <ul class="mb-0">
            <li>Alamat: Jl. Event Ticket No. 123, Jakarta</li>
            <li>Jam Operasional: Senin-Jumat 09:00-17:00</li>
            <li>Bawa bukti pemesanan tiket</li>
            <li>Pembayaran langsung akan mengubah status menjadi "Lunas"</li>
          </ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="markAsPaid()" tabindex="0">
          <i class="fas fa-check"></i> Tandai Sebagai Lunas (Test)
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="0">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(document).ready(function() {
  if ($('#ticketsTable').length) {
    $('#ticketsTable').DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#ticketsTable_wrapper .col-md-6:eq(0)');
  }
  
  // Accessibility improvements for modal
  $('#paymentModal').on('show.bs.modal', function () {
    // Store the element that had focus before modal opened
    $(this).data('previousFocus', document.activeElement);
    // Remove aria-hidden to allow focus
    $(this).removeAttr('aria-hidden');
  });
  
  $('#paymentModal').on('shown.bs.modal', function () {
    // Focus the first focusable element in modal
    var firstFocusable = $(this).find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])').first();
    if (firstFocusable.length) {
      firstFocusable.focus();
    }
  });
  
  $('#paymentModal').on('hide.bs.modal', function () {
    // Restore aria-hidden when modal is hidden
    $(this).attr('aria-hidden', 'true');
  });
  
  $('#paymentModal').on('hidden.bs.modal', function () {
    // Restore focus to the element that had focus before modal opened
    var previousFocus = $(this).data('previousFocus');
    if (previousFocus && previousFocus.length) {
      previousFocus.focus();
    }
  });
  
  // Trap focus within modal when open
  $('#paymentModal').on('keydown', function (e) {
    if (e.key === 'Tab') {
      var focusableElements = $(this).find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
      var firstElement = focusableElements.first();
      var lastElement = focusableElements.last();
      
      if (e.shiftKey) {
        if (document.activeElement === firstElement[0]) {
          e.preventDefault();
          lastElement.focus();
        }
      } else {
        if (document.activeElement === lastElement[0]) {
          e.preventDefault();
          firstElement.focus();
        }
      }
    }
  });
});

function showPaymentInfo(ticketId) {
  // Store ticket ID for payment processing
  $('#paymentModal').data('ticketId', ticketId);
  $('#paymentModal').modal('show');
}

function markAsPaid() {
  var ticketId = $('#paymentModal').data('ticketId');
  
  if (!ticketId) {
    alert('ID Tiket tidak ditemukan!');
    return;
  }
  
  // Show loading state
  var btn = $('button[onclick="markAsPaid()"]');
  var originalText = btn.html();
  btn.html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
  btn.prop('disabled', true);
  
  // Send AJAX request to update ticket status
  $.ajax({
    url: '<?= base_url('tickets/mark-as-paid') ?>',
    type: 'POST',
    data: {
      ticket_id: ticketId
    },
    dataType: 'json',
    success: function(response) {
      if (response.success) {
        // Close modal
        $('#paymentModal').modal('hide');
        
        // Show success message
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Status tiket berhasil diubah menjadi Lunas',
          confirmButtonText: 'OK'
        }).then((result) => {
          // Reload page to show updated status
          location.reload();
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          text: response.message || 'Terjadi kesalahan saat mengubah status tiket',
          confirmButtonText: 'OK'
        });
      }
    },
    error: function() {
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Terjadi kesalahan pada server',
        confirmButtonText: 'OK'
      });
    },
    complete: function() {
      // Restore button state
      btn.html(originalText);
      btn.prop('disabled', false);
    }
  });
}

function downloadTicket(ticketId) {
  // Implementasi download tiket
  alert('Fitur download tiket akan segera tersedia!');
}
</script>
<?= $this->endSection() ?> 