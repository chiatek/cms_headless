<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('components/common/meta_css', $data); ?>
</head>

<body>

    <!-- Wrapper -->
	<div class="wrapper">

        <!-- Navbar -->
        <?php $this->view('components/common/navbar', $data); ?>
        <!-- End Navbar -->

        <!-- Main Content -->
        <div class="content my-3 my-md-5">

            <!-- Page Content -->
            <div class="container">

                <div class="row no-gutters overflow-hidden">
                    <div class="col-md-3 pt-0">
                        <h3 class="page-title mb-2 mt-4"><?php echo $this->database; ?></h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <?php if ($user->user_role == "administrator"): ?>
                                <a href="<?php echo site_url('database'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-sitemap"></i></span>All Tables
                                </a>
                                <?php endif; ?>
                                <a href="<?php echo site_url('query/saved_query'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-hdd-o"></i></span>Saved Queries
                                </a>
                                <?php if ($user->user_role == "administrator"): ?>
                                <a href="<?php echo site_url('database/sql'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-terminal"></i></span>SQL Query
                                </a>
                                <a href="<?php echo site_url('database/archive'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-archive"></i></span>Backup/Restore
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mt-70">

                        <div class="form-group">
                            <fieldset class="form-group">
                                <legend>Backup Database</legend>
                                <div class="form-check m-3">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="backup" form="backup-form" value="<?php echo $this->database; ?>" checked>
                                        <?php echo $this->database . '.sql'; ?>
                                    </label>
                                </div>
                            </fieldset>

                            <form action="<?php echo site_url('database/archive'); ?>" method="post" id="backup-form">
                                <button type="submit" class="btn btn-outline-primary btn-sm">Download .sql FIle</button>
                            </form>
                        </div>

                        <br /><hr /><br />

                        <div class="form-group">
                            <fieldset class="form-group">

                                <legend>Restore Database</legend>

                                <br />

                                <form method="post" action="<?php echo site_url('database/archive'); ?>" enctype="multipart/form-data" />
                                    Select a file: <input type="file" name="userfile" size="20"><br /><br />
                                    <button type="submit" class="btn btn-outline-primary btn-sm spinner">Restore .sql File</button>
                                </form>

                                <br />

                                <?php if ($success): ?>
                                    <h5>Database: <?php echo $this->database ?> has been restored!</h5>

                                    <ul>
                                        <?php foreach ($upload_data as $item => $value): ?>
                                            <li><?php echo $item . ': ' . $value; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <?php echo $error; ?>
                            </fieldset>

                        </div>

                    </div>
                </div>
            </div>
            <!-- End Page Content -->

		</div>
		<!-- End Main Content -->

        <!-- Footer -->
        <?php $this->view('components/common/footer', $data); ?>
        <!-- End Footer -->

    </div>
    <!-- End Wrapper -->

    <!-- Base Javascript -->
    <?php $this->view('components/common/javascript', $data); ?>
    <!-- Additional JavaScript -->
    <script src="<?php echo site_url('assets/js/theme.js'); ?>" type="text/javascript"></script>

</body>
</html>