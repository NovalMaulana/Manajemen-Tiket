<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redirect - Event Ticket Management</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition">
    <div class="wrapper">
        <div class="content-wrapper" style="margin-left: 0;">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0 text-center">Event Ticket Management</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <i class="<?= $icon ?> fa-4x text-<?= $color ?>"></i>
                                    </div>
                                    
                                    <h3 class="text-<?= $color ?>"><?= $message ?></h3>
                                    
                                    <p class="text-muted"><?= $submessage ?></p>
                                    
                                    <div class="mt-4">
                                        <div class="progress mb-3" style="height: 6px;">
                                            <div class="progress-bar bg-<?= $color ?> progress-bar-striped progress-bar-animated" 
                                                 role="progressbar" 
                                                 style="width: 0%" 
                                                 id="progressBar"></div>
                                        </div>
                                        
                                        <p class="text-muted small">Redirecting in <span id="countdown">5</span> seconds...</p>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <a href="<?= $redirect_url ?>" class="btn btn-<?= $color ?>">
                                            <i class="fas fa-arrow-right mr-2"></i>
                                            <?= $redirect_text ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
    
    <script>
        // Countdown dan progress bar
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');
        const progressBar = document.getElementById('progressBar');
        
        const timer = setInterval(function() {
            countdown--;
            countdownElement.textContent = countdown;
            
            // Update progress bar
            const progress = ((5 - countdown) / 5) * 100;
            progressBar.style.width = progress + '%';
            
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = '<?= $redirect_url ?>';
            }
        }, 1000);
    </script>
</body>
</html> 