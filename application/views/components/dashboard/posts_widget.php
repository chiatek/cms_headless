<!-- posts_widget -->
<?php if ($config->setting_dashboard_posts_widget): ?>
<div class="d-flex mb-5">
    <?php if (isset($total_comments)): ?>
    <div class="flex-fill">
        <div class="column-card">
            <div class="card-body bg-primary">
                <div class="row">
                    <div class="col-3 text-light">
                        <i class="fa fa-comments widget-icon"></i>
                    </div>
                    <div class="col-9 text-light text-right">
                        <h2 class="text-light"><?php echo $total_comments; ?></h2>
                        <div class="widget-heading">Comments</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo site_url('comments'); ?>">
                <div class="card-footer text-primary">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>
    <?php if (isset($total_posts)): ?>
    <div class="flex-fill pl-3">
        <div class="column-card">
            <div class="card-body bg-success">
                <div class="row">
                    <div class="col-3 text-light">
                        <i class="fa fa-tasks widget-icon"></i>
                    </div>
                    <div class="col-9 text-light text-right">
                        <h2 class="text-light"><?php echo $total_posts; ?></h2>
                        <div class="widget-heading">Posts</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo site_url('posts'); ?>">
                <div class="card-footer text-success">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<!-- End posts_widget -->