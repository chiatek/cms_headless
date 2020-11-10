<!-- Comments -->
<?php if ($config->setting_dashboard_comments && isset($comments)): ?>
<div class="column-card mb-5">
    <h6 class="card-header">Latest Comments</h6>
    <div class="card-body">

        <?php if ($total_comments === 0): ?>
            <div class="text-muted mt-3 mb-3">No comments have been posted</div>
        <?php else: ?>
            <?php while ($comment = $comments->fetch()): ?>
                <div class="media pb-1 mb-3">
                    <div class="media-body ml-3">
                        <div class="text-primary badge float-right"><?php echo $comment->status; ?></div>
                        <i class="text-dark"><?php echo $comment->user; ?></i>
                        <span class="text-muted">commented on</span>
                        <a href="<?php echo site_url('comments/edit/'.$comment->id); ?>" target="_blank"><?php echo $comment->post; ?></a>
                        <p class="my-1"><?php echo get_summary($comment->comment, config('summary_sentence_limit')); ?></p>
                        <div class="clearfix">
                            <span class="float-left text-muted small"><?php echo $comment->date; ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>

    </div>
    <a href="<?php echo site_url('comments'); ?>" class="card-footer d-block text-center text-muted small">SHOW MORE</a>
</div>
<?php endif; ?>
<!-- End Comments -->