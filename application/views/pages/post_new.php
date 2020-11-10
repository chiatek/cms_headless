<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('components/common/meta_css', $data); ?>
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
                        <h3 class="page-title mb-2 mt-4">Posts</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="<?php echo site_url('posts'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-pencil-square-o"></i></span>All Posts
                                </a>
                                <a href="<?php echo site_url('category'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-tags"></i></span>Categories
                                </a>
                                <a href="<?php echo site_url('comments'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mb-3">
                                    <span class="icon mr-3"><i class="fa fa-comments"></i></span>Comments
                                </a>
                                <a href="<?php echo site_url('posts/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Post
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card mt-35">

                            <input type="hidden" name="author" form="post-form" value="<?= $user->user_name; ?>" />

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" id="post_title" class="form-control" name="title" form="post-form">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Slug</label>
                                    <input type="text" id="post_slug" class="form-control" name="slug" form="post-form" value="" readonly="readonly">
                                </div>

                                <p class="text-danger"><?php echo $this->form_validation->validation_errors(); ?></p>

                            </div>

                            <form action="<?php echo site_url('posts/insert'); ?>" method="post" id="post-form">
                                <div class="text-right mr-5 mt-3 pb-5">
                                    <button type="submit" class="btn btn-primary save-btn spinner">Create Post</button>&nbsp;
                                    <a href="<?php echo site_url(); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
                                </div>
                            </form>

                        </div>

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

</body>
</html>