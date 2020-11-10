<?php
defined('SYSPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error</title>

    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url('assets/img/favicon.ico'); ?>">
    <link rel="icon" type="image/png" href="<?php echo site_url('assets/img/favicon.png'); ?>"> 
    <link rel="apple-touch-icon" href="<?php echo site_url('assets/img/apple-touch-icon.png'); ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/bootstrap/css/theme/default.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/fontawesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/css/main.css'); ?>">

</head>
<body>

	<!-- Wrapper -->
	<div class="page">

		<!-- Main Content -->
		<div class="content">
			<div class="container text-center">

				<h1 class="h2 mb-3"><?php echo $heading; ?></h1>
				<p class="h4 text-muted font-weight-normal mb-7"><?php echo $message; ?></p>
				<a class="btn btn-primary" href="javascript:history.back()">
					<i class="fa fa-arrow-left mr-2"></i>Go back
				</a>

			</div>
		</div>
		<!-- End Main Content -->

	</div>
	<!-- End Wrapper -->

    <!-- Base Javascript -->
    <script src="<?php echo site_url('assets/vendor/jquery/jquery-3.3.1.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/endor/bootstrap/js/popper.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/main.js'); ?>" type="text/javascript"></script>

</body>
</html>