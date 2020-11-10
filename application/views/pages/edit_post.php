<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('components/common/meta_css', $data); ?>
    <!-- Additional CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/codemirror/lib/codemirror.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/codemirror/theme/material.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/summernote/summernote-bs4.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/toastr/toastr.min.css'); ?>">
</head>

<body>

    <!-- Wrapper -->
	<div class="wrapper">

        <!-- Navbar -->
        <form action="<?php echo site_url('posts/edit/'.$pkey_val); ?>" method="post" id="post-form">
            <?php $this->view('components/common/navbar', $data); ?>
            <input type="hidden" id="post_status" name="status" form="post-form" value="" />
        </form>
        <!-- End Navbar -->

        <!-- Main Content -->
        <div class="content my-3 my-md-5">

            <!-- Page Content -->
            <div class="container">

	            <div class="row">
	              	<div class="col">

						<!-- Summernote -->
		    			<textarea name="body" form="post-form" id="summernote"><?php echo $post->body; ?></textarea>
						<!-- End SUmmernote -->
						<br />

						<!-- Tabs -->
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="tab" href="#general">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#meta">Meta</a>
                                    </li>
                                </ul>
                            </div>

    						<div class="card-body tab-body p-3">
    							<div id="myTabContent" class="tab-content">

    							  	<div class="tab-pane fade active show" id="general">
    									<div class="container">
    										<div class="form-group">
    							  				<label class="form-label">Title</label>
    							  				<input type="text" class="form-control" name="title" id="title" form="post-form" value="<?php echo $post->title; ?>">
    										</div>
    										<div class="form-group">
    							  				<label class="form-label">Slug</label>
    							  				<input type="text" class="form-control" name="slug" id="slug" form="post-form" value="<?php echo $post->slug; ?>">
    										</div>
    										<div class="form-group">
    							  				<label class="form-label">Description</label>
    							  				<textarea class="form-control" name="description" form="post-form" rows="3"><?php echo $post->description; ?></textarea>
    										</div>
    										<div class="form-group">
    										  	<label class="form-label">Categories</label>
    										  	<select class="form-control" name="category_id[]" form="post-form" multiple>
                                                    <?php $sel_array = array();
                                                        while ($selected = $category_post->fetch()):
                                                            array_push($sel_array, $selected->id);
                                                        endwhile;
                                                        while ($category = $category_all->fetch()):
                                                            if (in_array($category->id, $sel_array) == TRUE): ?>
                                                                <option value="<?php echo $category->id; ?>" selected><?php echo $category->name; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                                        <?php endif;
                                                        endwhile; ?>
    										  	</select>

                                                <?php foreach($sel_array as $list): ?>
                                                    <input type="hidden" name="prev_category[]" form="post-form" value="<?php echo $list; ?>" />
                                                <?php endforeach; ?>
    										</div>
    										<div class="form-check">
    											<label class="form-check-label">
    												<input class="form-check-input" type="checkbox" name="featured" form="post-form" value="1" <?php echo ($post->featured == '1') ? "checked" : ""; ?>>
    												Featured
    											</label>
    										</div>

                                            <br />
                                            <p class="text-danger"><?php echo $this->form_validation->validation_errors(); ?></p>
    									</div>
    							  	</div>

    							 	<div class="tab-pane fade" id="meta">
    									<div class="container">
    										<div class="form-group">
    							  				<label class="form-label">Caption</label>
    							  				<input type="text" class="form-control" name="meta_caption" form="post-form" value="<?php echo $post->meta_caption; ?>">
    										</div>
    										<div class="form-group">
    							  				<label class="form-label">Description</label>
    							  				<textarea class="form-control" name="meta_description" form="post-form" rows="3"><?php echo $post->meta_description; ?></textarea>
    										</div>
    										<div class="form-group">
    											<label class="form-label">Keywords</label>
    											<input type="text" class="form-control" name="meta_keywords" form="post-form" value="<?php echo $post->meta_keywords; ?>">
    										</div>
    									</div>
    							  	</div>

    							</div>
    						</div>
                        </div>
		                <!-- End Tabs -->

	              	</div>
					<div class="col-md-4 col-xl-3">

		                <!-- Post details -->
		                <div class="card mb-4">
		                  	<h6 class="card-header">Post details</h6>
		                  	<ul class="list-group list-group-flush">
		                    	<li class="list-group-item d-flex justify-content-between align-items-center">
		                      		<div class="text-muted">Title</div>
	                      			<div><?php echo $post->title; ?></div>
		                    	</li>
		                    	<li class="list-group-item d-flex justify-content-between align-items-center">
		                      		<div class="text-muted">Created by</div>
		                      		<div><?php echo $post->author; ?></div>
                                    <input type="hidden" name="author" form="post-form" value="<?php echo $post->author; ?>" />
			                    </li>
		                    	<li class="list-group-item d-flex justify-content-between align-items-center">
		                      		<div class="text-muted">Created at</div>
		                      		<div><?php echo $post->created; ?></div>
		                    	</li>
		                    	<li class="list-group-item d-flex justify-content-between align-items-center">
		                      		<div class="text-muted">Last update</div>
		                      		<div><?php echo $post->modified; ?></div>
		                    	</li>
		                    	<li class="list-group-item d-flex justify-content-between align-items-center">
		                      		<div class="text-muted">Status</div>
		                      		<div><?php echo $post->status; ?></div>
		                    	</li>
		                    	<li class="list-group-item">
		                      		<div class="text-muted small">Categories</div>
		                      		<div class="d-flex flex-wrap">
                                        <?php $category_post->execute(); ?>
                                        <?php while ($category = $category_post->fetch()): ?>
                                            <div class="badge badge-secondary mt-1 mr-1"><?php echo $category->name; ?></div>
                                        <?php endwhile; ?>
		                      		</div>
		                    	</li>
		                  	</ul>
		                </div>
		                <!-- Post details -->

		                <!-- Featured Image -->
		                <div class="card mb-4">
		                  	<div class="card-header">
	                    		<h6 class="float-left">Featured Image</h6>
							</div>
		                  	<ul class="list-group list-group-flush">
		                    	<li class="list-group-item">
		                      		<div class="media">
                                        <img src="<?php echo $post->image; ?>" id="featured-image" class="featured-image" alt="&nbsp;Click modify below to add a featured image.">
                                        <input type="hidden" name="image" id="post_image" form="post-form" value="<?php echo $post->image; ?>" />
		                      		</div>
		                    	</li>
								<li class="list-group-item">
                                    <?php if (!empty($config->setting_url) && !empty($config->setting_root) && !empty($config->setting_media)): ?>
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#image-modal">
                                            <span class="fa fa-plus"></span> Modify
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#image-modal" disabled>
                                            <span class="fa fa-plus"></span> Modify
                                        </button>
                                    <?php endif; ?>
								</li>
		                  	</ul>
		                </div>
						<!-- End Featured Image -->

						<!-- Mobile Button Panel -->
						<div class="post-mobile-btn text-right pt-5 mt-5 mr-1">
							<button class="btn btn-primary spinner" id="m-btn-publish" form="post-form" type="submit">Publish</button>&nbsp;
							<button class="btn btn-primary spinner" id="m-btn-save" form="post-form" type="submit">Save</button>&nbsp;
							<a href="<?php echo site_url('posts'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
						</div>
						<!-- End Mobile Button Panel -->

					</div>
	            </div>

			</div>
			<!-- End Page Content -->

		</div>
		<!-- End Main Content -->

        <!-- Image Modal -->
        <?php $this->view('components/modals/image_modal', $data); ?>
        <?php $this->view('components/modals/editor_modal', $data); ?>
        <!-- End Image Modal -->

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
    <!-- Additional JavaScript -->
    <script src="<?php echo site_url('assets/vendor/codemirror/lib/codemirror.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/codemirror/mode/xml/xml.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/summernote/summernote-bs4.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/summernote.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/toastr/toastr.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/toastr.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo site_url('assets/js/theme.js'); ?>" type="text/javascript"></script>

	<script>
        $(document).ready(function() {

            $("#btn-publish").click(function(){
                $("#post_status").val("published");
            });
            $("#btn-save").click(function(){
                $("#post_status").val("draft");
			});

			$("#m-btn-publish").click(function(){
                $("#post_status").val("published");
            });
            $("#m-btn-save").click(function(){
                $("#post_status").val("draft");
            });

        });
    </script>

</body>
</html>