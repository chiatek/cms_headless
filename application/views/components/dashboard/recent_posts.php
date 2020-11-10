<!-- Recent Posts -->
<?php if ($config->setting_dashboard_posts && isset($posts)): ?>
<div class="column-card mb-5">
    <div class="card-header mb-0 pb-0">
        <div class="card-title"><h6>Recent Posts</h6></div>
        <div class="card-options">
            <a href="<?php echo site_url('posts/insert'); ?>" class="btn btn-outline-primary btn-sm">New Post</a>
        </div>
    </div>
    <div class="card-body">

        <?php if ($posts->rowCount() == 0): ?>
            <div class="text-muted mt-3 mb-3">No articles have been posted</div>
        <?php else: ?>
            <?php while ($post = $posts->fetch()): ?>
                <div class="pb-1 mb-3">
                    <div class="text-primary badge float-right"><?php echo $post->status; ?></div>
                    <a href="<?php echo site_url('posts/edit/'.$post->id); ?>"><?php echo $post->title; ?></a>&nbsp;
                    <br>
                    <small class="text-muted">Created by
                        <span class="text-muted"><?php echo $post->author; ?></span> &nbsp;·&nbsp; <?php echo $post->modified; ?>
                    </small>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>

    </div>
    <a href="<?php echo site_url('posts'); ?>" class="card-footer d-block text-center text-muted small">SHOW MORE</a>
</div>
<?php endif; ?>
<!-- End Recent Posts -->