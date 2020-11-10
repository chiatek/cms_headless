<!-- analytics_widget -->
<?php if ($config->setting_dashboard_GA_widget): ?>
<div class="d-flex mb-5">
    <div class="flex-fill">
        <div class="column-card">
            <div class="card-body bg-danger">
                <div class="row">
                    <div class="col-3 text-light">
                        <i class="fa fa-eye widget-icon"></i>
                    </div>
                    <div class="col-9 text-light text-right">
                        <?php
                            if ($page_views) {
                                echo '<h2 class="text-light">' . $page_views[0][0] . '</h2>';
                            }
                            else {
                                echo '<h2 class="text-light">0</h2>';
                            }
                        ?>
                        <div class="widget-heading">Views today</div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-danger">
                <span class="pull-left"></span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="flex-fill pl-3">
        <div class="column-card">
            <div class="card-body bg-info">
                <div class="row">
                    <div class="col-3 text-light">
                        <i class="fa fa-user-circle widget-icon"></i>
                    </div>
                    <div class="col-9 text-light text-right">
                        <?php
                            if ($users) {
                                echo '<h2 class="text-light">' . $users[0][0] . '</h2>';
                            }
                            else {
                                echo '<h2 class="text-light">0</h2>';
                            }
                        ?>
                        <div class="widget-heading">Users this week</div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-info">
                <span class="pull-left"></span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- End analytics_widget -->