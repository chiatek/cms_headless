<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>

    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url('assets/img/favicon.ico'); ?>">
    <link rel="icon" type="image/png" href="<?php echo site_url('assets/img/favicon.png'); ?>">
    <link rel="apple-touch-icon" href="<?php echo site_url('assets/img/apple-touch-icon.png'); ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/bootstrap/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/fontawesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/css/login.css'); ?>">
</head>
<body>

	<!-- Login Wrapper -->
    <div class="login-wrapper login ui-bg-cover ui-bg-overlay-container px-4" style="background-image: url('<?php echo site_url('assets/img/login.jpg'); ?>');">
        <div class="ui-bg-overlay bg-dark opacity-25"></div>

        <div class="login-inner py-5">

            <div class="row">
                <div class="col col-login mx-auto">

                    <div class="card">
                        <div class="card-body">
                            <!-- Form -->
                            <form action="<?php echo site_url('users/reset_password'); ?>" method="post" id="reset-form">

                                <h6 class="text-center text-shadow text-white mb-3 pb-1">Reset Your Password</h6>

                                <hr class="mt-0 mb-3">

                                <p class="text-light text-shadow text-center">
                                    <small>Enter your email address and we will send you a new temporary password.</small>
                                </p>

                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="bg-primary text-white input-group-text"><i class="ml-1">@</i></span>
                                    </div>
                                    <input type="text" class="form-control" name="email_address" form="reset-form" placeholder="Enter your email address">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block spinner">Reset Password</button>
                                </div>

                                <div class="mb-4">
                                    <?php if ($error == 0): ?>
                                        <p class="text-light text-shadow-dark text-center">Your password has been emailed to you.</p>
                                    <?php endif; ?>

                                    <?php if ($error == 1): ?>
                                        <p class="text-white text-shadow-dark text-center"><small>Invalid email. Please try again.</small></p>
                                    <?php endif; ?>

                                    <?php if ($error == 2): ?>
                                        <p class="text-danger text-shadow-dark text-center">Unable to send email. Please contact your system administrator.</p>
                                    <?php endif; ?>
                                </div>

                            </form>
                            <!-- End Form -->
                        </div>
                        <div class="card-footer bg-secondary">
                            <div class="d-flex justify-content-center text-light">
                                <small><a class="text-light ml-2" href="<?php echo site_url('users/login'); ?>">Log In to Your Account</a></small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- End Login Wrapper -->

    <!-- Base Javascript -->
    <script src="<?php echo site_url('assets/vendor/jquery/jquery-3.3.1.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/bootstrap/js/popper.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/main.js'); ?>" type="text/javascript"></script>

</body>
</html>