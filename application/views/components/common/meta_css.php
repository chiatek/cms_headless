<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<meta name="description" content="Dashboard Template">
<meta name="keywords" content="">
<meta name="author" content="">

<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url('assets/img/favicon.ico'); ?>">
<link rel="icon" type="image/png" href="<?php echo site_url('assets/img/favicon.png'); ?>">
<link rel="apple-touch-icon" href="<?php echo site_url('assets/img/apple-touch-icon.png'); ?>">

<!-- CSS -->
<?php if ($user->user_theme): ?>
<link id="page-theme" rel="stylesheet" href="<?php echo site_url('assets/vendor/bootstrap/css/theme/'.$user->user_theme); ?>">
<?php else: ?>
<link id="page-theme" rel="stylesheet" href="<?php echo site_url('assets/vendor/bootstrap/css/theme/default.css'); ?>">
<?php endif; ?>
<link rel="stylesheet" href="<?php echo site_url('assets/vendor/fontawesome/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?php echo site_url('assets/css/main.css'); ?>">