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
    <link rel="stylesheet" href="<?php echo site_url('assets/css/users/'.$user_id.'.css'); ?>">
</head>
<body>

    <div class="wrapper">
        <?php if ($error): ?>
            <br />
            <h1>An error occured when sending your message.</h1>
            <hr />
            <br />
        <?php else: ?>
            <br />
            <h1>Thanks for your interest!<h1>
            <hr />
            <h3>Your message has been sent.<h3>
            <br />
        <?php endif; ?>
        
        <a href="<?php echo $site_url; ?>" class="btn-primary">Return Home</a>
    </div>

</body>
</html>