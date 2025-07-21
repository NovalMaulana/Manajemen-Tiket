<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6 col-12">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= count($my_events) ?></h3>
                <p>Events Saya</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <a href="<?= base_url('events') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-6 col-12">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $total_tickets_sold ?></h3>
                <p>Total Tiket Terjual</p>
            </div>
            <div class="icon">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <a href="<?= base_url('tickets/sold-tickets') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Event Saya</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Nama Event</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Tiket Tersedia</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($my_events as $event): ?>
                        <tr>
                            <td><?= $event['event_name'] ?></td>
                            <td><?= date('d/m/Y', strtotime($event['event_date'])) ?></td>
                            <td><?= $event['venue'] ?></td>
                            <td><?= $event['available_tickets'] ?></td>
                            <td>Rp <?= number_format($event['price'], 0, ',', '.') ?></td>
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