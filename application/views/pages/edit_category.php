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
                                <a href="<?= site_url('category/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mb-3">
                                    <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Category
                                </a>
                                <a href="<?php echo current_url(); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-pencil"></i></span>Edit <?php echo $row->name; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card mt-35">

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="post_title" form="category-form" value="<?php echo $row->name; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="post_slug" form="category-form" value="<?php echo $row->slug; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Parent Category</label>
                                    <select class="custom-select" name="parent" form="category-form">
                                        <option value="">none</option>
                                        <?php while ($category = $category_all->fetch()): ?>
                                            <option value="<?php echo $category->name; ?>" <?php echo ($row->parent == $category->name) ? "selected" : ""; ?>><?php echo $category->name; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" rows="5" name="description" form="category-form"><?php echo $row->description; ?></textarea>
                                </div>

                                <br />

                                <p class="text-danger"><?php echo $this->form_validation->validation_errors(); ?></p>
                            </div>

                            <form action="<?php echo site_url('category/edit/'.$row->id); ?>" method="post" id="category-form">
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