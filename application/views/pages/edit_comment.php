<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('components/common/meta_css', $data); ?>
    <!-- Additional CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/toastr/toastr.min.css'); ?>">
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
                                <a href="<?php echo current_url(); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-pencil"></i></span>Edit comment id <?php echo $comment->id; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card mt-35">

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">ID</label>
                                    <input type="text" class="form-control" name="id" form="comment-form" value="<?php echo $comment->id; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select class="custom-select" name="status" form="comment-form">
                                        <option value="pending" <?php echo ($comment->status == 'pending') ? "selected" : ""; ?>>Pending</option>
                                        <option value="approved" <?php echo ($comment->status == 'approved') ? "selected" : ""; ?>>Approved</option>
                                        <option value="spam" <?php echo ($comment->status == 'spam') ? "selected" : ""; ?>>Spam</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Date</label>
                                    <input type="datetime" class="form-control" name="date" form="comment-form" value="<?php echo $comment->date; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" form="comment-form" value="<?php echo $comment->name; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" form="comment-form" value="<?php echo $comment->email; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Website</label>
                                    <input type="text" class="form-control" name="website" form="comment-form" value="<?php echo $comment->website; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Comment</label>
                                    <textarea class="form-control" rows="8" name="comment" form="comment-form" disabled><?php echo $comment->comment; ?></textarea>
                                </div>

                                <br />
                            </div>

                            <form action="<?php echo site_url('comments/edit/'.$comment->id); ?>" method="post" id="comment-form">
                                <div class="text-right mr-5 mt-3 pb-5">
                                    <button type="submit" class="btn btn-primary save-btn spinner">Save changes</button>&nbsp;
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
    <!-- Additinal Javascript -->
    <script src="<?php echo site_url('assets/vendor/toastr/toastr.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/toastr.js'); ?>" type="text/javascript"></script>

</body>
</html>