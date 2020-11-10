<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('components/common/meta_css', $data); ?>
    <!-- Additional CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/toastr/toastr.min.css'); ?>">
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

                    <div class="col-lg-2 pt-0">
                        <h3 class="page-title mb-2 mt-4">Media</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="<?php echo site_url('media'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-book"></i></span>Library
                                </a>
                                <a href="<?php echo site_url('media/upload'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-plus-circle"></i></span>New Media
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-10 mt-70">

                        <div class="table-responsive">
                            <table id="edit-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-primary">
                                        <th></th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Path</th>
                                        <th>Size</th>
                                        <th>Date</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($file_info as $file): ?>

                                        <?php $path = site_url('media/edit/'.$file['name']); ?>

                                        <tr>
                                            <td><div class="form-check"><input class="form-check-input delete-chk" name="delete[]" form="delete-form" type="checkbox" value="<?php echo $file['server_path']; ?>"></div></td>
                                            <td><a href="<?php echo $path; ?>" class="text-dark table-link"><img class="media-thumbnail" src="<?php echo $config->setting_url . '/' . $config->setting_media . '/' . $file['name']; ?>"></a></td>
                                            <td><a href="<?php echo $path; ?>" class="text-dark table-link"><?php echo $file['name']; ?></a></td>
                                            <td><a href="<?php echo $path; ?>" class="text-dark table-link"><?php echo $file['relative_path']; ?></a></td>
                                            <td><a href="<?php echo $path; ?>" class="text-dark table-link"><?php echo $file['size'].' bytes'; ?></a></td>
                                            <td><a href="<?php echo $path; ?>" class="text-dark table-link"><?php echo format_timestamp($file['date']); ?></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <form action="<?php echo site_url('media/delete'); ?>" method="post" id="delete-form">
                            <div class="text-left mt-3">
                                <?php if ($user->user_role == "administrator"): ?>
                                    <button type="submit" Onclick="return confirm_delete();" class="btn btn-primary delete-btn spinner" disabled>Delete</button>
                                <?php else: ?>
                                    <button type="button" Onclick="return confirm_delete();" class="btn btn-primary" disabled>Delete</button>
                                <?php endif; ?>
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
    <!-- Additinal Javascript -->
    <script src="<?php echo site_url('assets/vendor/datatables/datatables.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/toastr/toastr.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/datatables.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/toastr.js'); ?>" type="text/javascript"></script>

</body>
</html>