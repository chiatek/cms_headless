<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('components/common/meta_css', $data); ?>
    <!-- Additional CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/dropzone/dropzone.css'); ?>">
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
                        <h3 class="page-title mb-2 mt-4">Media</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="<?php echo site_url('media'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-book"></i></span>Library
                                </a>
                                <a href="<?php echo site_url('media/upload'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-plus-circle"></i></span>New Media
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mt-35">

                        <?php if ($success): ?>
                            <h3>Your file was successfully uploaded!</h3>

                            <ul>
                                <?php foreach ($upload_data as $item => $value): ?>
                                    <li><?php echo $item . ': ' . $value; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <h5>Select a file to upload:</h5>
                        <?php echo $error; ?>

                        <form method="post" action="<?php echo site_url('media/do_upload'); ?>" enctype="multipart/form-data" />
                            Select a file: <input type="file" name="userfile" size="20"><br /><br />
                            <button type="submit" class="btn btn-primary btn-sm save-btn spinner">Upload</button>
                        </form>

                        <br /><br /><br />

                        <!-- Dropzone -->
                        <h5>Or drag and drop multiple files below:</h5>
                        <form method="post" action="<?php echo site_url('media/do_upload'); ?>" enctype="multipart/form-data" class="dropzone needsclick" id="dropzone" />
                            <div class="dz-message needsclick">
                                Drop files here or click to upload
                            </div>
                            <div class="fallback">
                                <input name="userfile" type="file">
                            </div>
                        </form>
                        <!-- End Dropzone -->

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
    <script src="<?php echo site_url('assets/vendor/dropzone/dropzone.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/dropzone.js'); ?>" type="text/javascript"></script>

</body>
</html>