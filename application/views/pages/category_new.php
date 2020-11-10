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
                                <a href="<?= site_url('category'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-tags"></i></span>Categories
                                </a>
                                <a href="<?= site_url('comments'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mb-3">
                                    <span class="icon mr-3"><i class="fa fa-comments"></i></span>Comments
                                </a>
                                <a href="<?= site_url('category/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Category
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card mt-35">

                            <div class="card-body">
	    						<div class="form-group">
	    					  		<label class="form-label">Name</label>
	    					  		<input type="text" id="post_title" class="form-control" name="name" form="category-form">
	    						</div>
	                            <div class="form-group">
	                                <label class="form-label">Slug</label>
	                                <input type="text" id="post_slug" class="form-control" name="slug" form="category-form" value="">
	                            </div>
								<div class="form-group">
									<label class="form-label">Parent Category</label>
									<select class="custom-select" name="parent" form="category-form">
                                        <option value="" selected>none</option>
                                        <?php while ($category = $category_all->fetch()): ?>
											<option value="<?php echo $category->name; ?>"><?php echo $category->name; ?></option>
                                        <?php endwhile; ?>
									</select>
								</div>
								<div class="form-group">
									<label class="form-label">Description</label>
									<textarea class="form-control" rows="5" name="description" form="category-form"></textarea>
								</div>

                                <p class="text-danger"><?php echo $this->form_validation->validation_errors(); ?></p>
							</div>

                            <form action="<?php echo site_url('category/insert'); ?>" method="post" id="category-form">
                                <div class="text-right mr-5 mt-3 pb-5">
                                    <button type="submit" class="btn btn-primary save-btn spinner">Create Category</button>&nbsp;
                                    <a href="<?php echo site_url('admin'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
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