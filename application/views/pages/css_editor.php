<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('components/common/meta_css', $data); ?>
    <!-- Additional CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/codemirror/lib/codemirror.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/codemirror/theme/material.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/codemirror/addon/display/fullscreen.css'); ?>">
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
                        <h3 class="page-title mb-2 mt-4">Appearance</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="<?php echo site_url('settings/css_editor'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-file-code-o"></i></span>CSS Editor
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mt-35">

                        <div class="form-group mt-2">
                            <textarea class="form-control" name="css_textarea" id="cm-textarea" form="css-form"><?php echo $css; ?></textarea>
                        </div>

                        <form action="<?php echo site_url('settings/css_editor'); ?>" method="post" id="css-form">
                            <div class="text-right mt-5 pb-5">
                                <?php if (!empty($config->setting_css)): ?>
                                    <button type="submit" class="btn btn-primary spinner">Save</button>&nbsp;
                                <?php else: ?>
                                    <button type="submit" class="btn btn-primary spinner" disabled>Save</button>&nbsp;
                                <?php endif; ?>
                                <a href="<?php echo site_url(); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
                            </div>
                        </form>

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
    <!-- Additional JavaScript / Nestable JS -->
    <script src="<?php echo site_url('assets/vendor/codemirror/lib/codemirror.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/codemirror/mode/css/css.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/codemirror/addon/edit/closebrackets.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/codemirror/addon/display/fullscreen.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/codemirror.js'); ?>" type="text/javascript"></script>

</body>
</html>