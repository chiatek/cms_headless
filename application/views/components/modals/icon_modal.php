<!-- modal -->
<div class="modal" id="icon-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <!-- modal header -->
        <div class="modal-header bg-light">
            <h5 class="modal-title">Site Icon</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- modal body -->
        <div class="modal-body bg-light">
            <?php if (!empty($media_info)): ?>
            <div class="d-flex flex-wrap align-content-start">
                <?php foreach ($media_info as $media): ?>
                    <div class="image-container m-1" data-icon="<?php echo $config->setting_root . '/' . $config->setting_media . '/' . $media['name']; ?>">
                        <img src="<?php echo $config->setting_url . '/' . $config->setting_media . '/' . $media['name']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <h6 class="text-center m-5 p-5">No images have been uploaded yet... <a href="<?php echo site_url('media/upload'); ?>">Upload Images</a></h6>
            <?php endif; ?>
        </div>

        <!-- modal footer -->
        <div class="modal-footer bg-light">
            <a href="<?php echo site_url('media/upload'); ?>" class="btn btn-outline-primary" role="button">Upload Image</a>
            <button type="button" class="btn btn-primary" id="icon-btn" data-dismiss="modal">Select</button>
        </div>

        </div>
    </div>
</div>
<!-- End modal -->