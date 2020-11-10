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
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/smartwizard/smart_wizard.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/smartwizard/smart_wizard_theme_arrows.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/css/login.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/css/main.css'); ?>">
</head>
<body>

	<!-- Login Wrapper -->
    <div class="login-wrapper login ui-bg-cover ui-bg-overlay-container px-4" style="background-image: url('<?php echo site_url('assets/img/login.jpg'); ?>');">
        <div class="ui-bg-overlay bg-dark opacity-25"></div>

        <!-- Setup Modal -->
        <div class="modal fade" id="setup_modal" tabindex="-1" role="dialog" aria-labelledby="setup_modal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="<?php echo site_url('assets/img/logo_sm_gray.svg'); ?>" style="width: 125px;" alt="logo">
                    </div>
                    <div class="modal-body">

                        <form action="#" id="wizard-form" method="post">
                        <!-- Smart Wizard HTML -->
                        <div id="smartwizard">
                            <ul>
                                <li><a href="#step-1">Welcome<br /><small></small></a></li>
                                <li><a href="#step-2">Database<br /><small></small></a></li>
                                <li><a href="#step-3">User Account<br /><small></small></a></li>
                                <li><a href="#step-4">Summary<br /><small></small></a></li>
                                <li><a href="#step-5" data-content-url="<?php echo site_url('users/setup'); ?>">Finish<br /><small></small></a></li>
                            </ul>

                            <div>
                                <div id="step-1">
                                    <div class="d-flex" id="form-step-0">
                                        <div class="p-2 flex-fill">
                                            <img src="<?php echo site_url('assets/img/logo.png'); ?>" class="media-thumbnail py-5" />
                                        </div>
                                        <div class="flex-fill py-5 my-4">
                                            <h3><?php echo config('cms_name') . config('title_separator') . ' Setup <small>' . config('cms_version') . '</small>'; ?></h3>
                                            <h6>Click next to start setting up your CMS!</h6>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-2">
                                    <div class="d-flex" id="form-step-1">
                                        <div class="p-2 flex-fill">
                                            <h5 class="text-center pt-5 text-muted">Connect to a MySQL Database</h5><br /><br />
                                            <img src="<?php echo site_url('assets/img/mysql.png'); ?>" class="media-thumbnail" /></div>
                                        <div class="p-2 flex-fill">
                                            <br />
                                            <div class="form-group">
                                                <label for="db_name" class="form-label">Database Name</label>
                                                <input type="text" class="form-control mb-1" id="db_name" name="db_name" form="wizard-form" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="db_username" class="form-label">Username</label>
                                                <input type="text" class="form-control mb-1" id="db_username" name="db_username" form="wizard-form" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="db_password" class="form-label">Password</label>
                                                <input type="password" class="form-control mb-1" id="db_password" name="db_password" form="wizard-form" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="db_hostname" class="form-label">Hostname</label>
                                                <input type="text" class="form-control mb-1" id="db_hostname" name="db_hostname" form="wizard-form" placeholder="localhost" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-3">
                                    <div class="d-flex" id="form-step-2">
                                        <div class="p-2 flex-fill">
                                            <h5 class="text-center text-muted pt-5">Create an Administrator Account</h5><br /><br />
                                            <img src="<?php echo site_url('assets/img/user.png'); ?>" class="media-thumbnail" />
                                        </div>
                                        <div class="p-2 flex-fill">
                                            <br />
                                            <div class="form-group">
                                                <label for="user_name" class="form-label">Name</label>
                                                <input type="text" class="form-control mb-1" id="user_name" name="user_name" form="wizard-form" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="user_email" class="form-label">Email</label>
                                                <input type="email" class="form-control mb-1" id="user_email" name="user_email" form="wizard-form" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="user_username" class="form-label">Username</label>
                                                <input type="text" class="form-control mb-1" id="user_username" name="user_username" form="wizard-form" required>
                                            </div>
                                            <div class="d-flex">
                                                <div class="mr-3 flex-fill">
                                                    <div class="form-group">
                                                        <label for="user_password" class="form-label">Password</label>
                                                        <input type="password" class="form-control mb-1" id="user_password" name="user_password" form="wizard-form" required>
                                                    </div>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="form-group">
                                                        <label for="user_password" class="form-label">Confirm Password</label>
                                                        <input type="password" class="form-control mb-1" id="user_confirm" name="user_confirm" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-4">
                                    <div class="d-flex" id="form-step-3">
                                        <div class="p-2 flex-fill">
                                            <img src="<?php echo site_url('assets/img/info.png'); ?>" class="media-thumbnail py-5" />
                                            <h6 class="text-muted text-center">Click next to apply settings and finish!</h6>
                                        </div>
                                        <div class="flex-fill mt-3">
                                            <table class="table table-borderless table-sm">
                                                <thead>
                                                    <tr>
                                                        <td><h6>Database</h6></td>
                                                        <td><h6>User Account</h6></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label class="form-label">Database Name:&nbsp;&nbsp;</label><i><span id="_db_name"></span></i><br />
                                                            <label class="form-label">Username:&nbsp;&nbsp;</label><i><span id="_db_username"></span></i><br />
                                                            <label class="form-label">Password:&nbsp;&nbsp;</label><i><span id="_db_password"></span></i><br />
                                                            <label class="form-label">Hostname:&nbsp;&nbsp;</label><i><span id="_db_hostname"></span></i>
                                                        </td>
                                                        <td>
                                                            <label class="form-label">Name:&nbsp;&nbsp;</label><i><span id="_user_name"></span></i><br />
                                                            <label class="form-label">Email:&nbsp;&nbsp;</label><i><span id="_user_email"></span></i><br />
                                                            <label class="form-label">Username:&nbsp;&nbsp;</label><i><span id="_user_username"></span></i><br />
                                                            <label class="form-label">Password:&nbsp;&nbsp;</label><i><span id="_user_password"></span></i>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-5">
                                    <div class="d-flex" id="form-step-4">
                                        <div class="p-2 flex-fill">
                                            <img src="<?php echo site_url('assets/img/info.png'); ?>" class="media-thumbnail py-5" />
                                        </div>
                                        <div class="flex-fill py-5 my-3">
                                            <br /><br />
                                            <h3>All Done!</h3>
                                            <p>Click finish to begin building your CMS.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Setup Modal -->

    </div>
    <!-- End Login Wrapper -->

    <!-- Base Javascript -->
    <script src="<?php echo site_url('assets/vendor/jquery/jquery-3.3.1.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/bootstrap/js/popper.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
    <!-- Additinal Javascript -->
	<script src="<?php echo site_url('assets/vendor/validate/validate.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/smartwizard/jquery.smartWizard.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/smartwizard.js'); ?>" type="text/javascript"></script>

</body>
</html>