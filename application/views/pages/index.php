<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('components/common/meta_css', $data); ?>
    <!-- Additional CSS / Morrisjs.css-->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/datatables/datatables.min.css'); ?>">

</head>
<body>

	<!-- Wrapper -->
	<div class="wrapper">

        <!-- Navbar -->
        <?php $this->view('components/common/navbar', $data); ?>
        <!-- End Navbar -->

        <!-- Main Content -->
        <div class="content my-md-5">
            <div class="container">
                <h1 class="page-title"><?php echo "Welcome, ".$user->user_name; ?></h1>
                <h3 class="page-subtitle pb-3"><small><?php echo "Today is ".date("l, F j, Y"); ?></small></h3>

                <div class="column-container">

                    <?php
                    
                        $this->view('components/dashboard/posts_widget', $data);

                        $this->view('components/dashboard/analytics_widget', $data);

                        $this->view('components/dashboard/recent_posts', $data);

                        $this->view('components/dashboard/latest_comments', $data);

                        $this->view('components/dashboard/analytics_chart', $data);
                    
                        $this->view('components/dashboard/analytics_stats', $data);

                        $this->view('components/dashboard/saved_queries', $data);

                    ?>

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
    <!-- Additional Javascript / Morris.js -->
    <script src="<?php echo site_url('assets/vendor/datatables/datatables.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/datatables.js'); ?>" type="text/javascript"></script>
    <?php if ($config->setting_dashboard_GA_chart || $config->setting_dashboard_GA_stats || $config->setting_dashboard_GA_widget): ?>
    <script src="<?php echo site_url('assets/js/analytics.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <?php endif; ?>

</body>
</html>