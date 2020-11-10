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
                                <a href="<?php echo site_url('database/archive'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mb-3">
                                    <span class="icon mr-3"><i class="fa fa-archive"></i></span>Backup/Restore
                                </a>
                                <a href="<?php echo site_url('database/table'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Table
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mt-70">

                        <div class="card">

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="table_name" form="table-form">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Number of Columns</label>
                                    <input type="number" class="form-control" name="num_columns" form="table-form">
                                </div>

                                <p class="text-danger"><?php echo $this->form_validation->validation_errors(); ?></p>
                            </div>

                        </div>

                        <form action="<?php echo site_url('database/table'); ?>" method="post" id="table-form">
                            <div class="text-right mt-3 pb-5">
                                <button type="submit" class="btn btn-primary save-btn spinner">Go</button>&nbsp;
                                <a href="<?php echo site_url('database'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
                            </div>
                        </form>

                    </div>

                </div>

            </div>
            <!-- End Page Content -->

		</div>
		<!-- End Main Content -->

        <!-- Toastr -->
        <?php $this->view('components/common/toastr'); ?>
        <!-- End Toastr -->

        <!-- Footer -->
        <?php $this->view('components/common/footer', $data); ?>
        <!-- End Footer -->

    </div>
    <!-- End Wrapper -->

    <!-- Base Javascript -->
    <?php $this->view('components/common/javascript', $data); ?>

</body>
</html>