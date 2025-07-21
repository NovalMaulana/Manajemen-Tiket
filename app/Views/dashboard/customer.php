<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Event yang Akan Datang</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <?php foreach ($upcoming_events as $event): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= $event['event_name'] ?></h5>
                                <p class="card-text">
                                    <strong>Tanggal:</strong> <?= date('d/m/Y', strtotime($event['event_date'])) ?><br>
                                    <strong>Waktu:</strong> <?= $event['event_time'] ?><br>
                                    <strong>Lokasi:</strong> <?= $event['venue'] ?><br>
                                    <strong>Harga:</strong> Rp <?= number_format($event['price'], 0, ',', '.') ?>
                                </p>
                                <?php if($event['available_tickets'] > 0): ?>
                                <a href="<?= base_url('tickets/buy/'.$event['event_id']) ?>" class="btn btn-primary">
                                    Beli Tiket (<?= $event['available_tickets'] ?> tersedia)
                                </a>
                                <?php else: ?>
                                <button class="btn btn-secondary" disabled>Tiket Habis</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tiket Saya</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Nama Event</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Jumlah Tiket</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($my_tickets as $ticket): ?>
                        <tr>
                            <td><?= $ticket['event_name'] ?></td>
                            <td><?= date('d/m/Y', strtotime($ticket['event_date'])) ?></td>
                            <td><?= $ticket['venue'] ?></td>
                            <td><?= $ticket['quantity'] ?></td>
                            <td>Rp <?= number_format($ticket['total_price'], 0, ',', '.') ?></td>
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
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<?= $this->endSection() ?> 