<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('components/common/meta_css', $data); ?>
    <!-- Additional CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/datatables/datatables.min.css'); ?>">
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

                    <div class="col-lg-2 pt-0">
                        <?php if ($table == 'users'): ?>
                        <h3 class="page-title mb-2 mt-4">Users</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <?php if ($user->user_role == "administrator"): ?>
                                    <a href="<?php echo site_url('users'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                        <span class="icon mr-3"><i class="fa fa-users"></i></span>All Users
                                    </a>
                                    <a href="<?php echo site_url('users/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-user-plus"></i></span>New User
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo site_url('users/profile'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-user"></i></span>My Profile
                                </a>
                            </div>
                        </div>
                        <?php else: ?>
                        <h3 class="page-title mb-2 mt-4">Posts</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">

                                <a href="<?php echo site_url('posts'); ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo (segment(1) == 'posts') ? "active" : ""; ?>">
                                    <span class="icon mr-3"><i class="fa fa-pencil-square-o"></i></span>All Posts
                                </a>
                                <a href="<?php echo site_url('category'); ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo (segment(1) == 'category') ? "active" : ""; ?>">
                                    <span class="icon mr-3"><i class="fa fa-tags"></i></span>Categories
                                </a>
                                <a href="<?php echo site_url('comments'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mb-3 <?php echo (segment(1) == 'comments') ? "active" : ""; ?>">
                                    <span class="icon mr-3"><i class="fa fa-comments"></i></span>Comments
                                </a>
                                <?php if (segment(1) == 'posts'): ?>
                                    <a href="<?php echo site_url('posts/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Post
                                    </a>
                                <?php endif; ?>
                                <?php if (segment(1) == 'category'): ?>
                                    <a href="<?php echo site_url('category/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Category
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>

                    <div class="col-lg-10 mt-70">

                        <div class="table-responsive">
                            <table id="edit-table" class="table table-striped table-bordered">
                                <?php
                                    $pkey = "";
                                    $table_name = explode(".", $table);
                                    if (isset($table_name[1])) {
                                        $table = $table_name[1];
                                    }

                                    echo '<thead><tr class="table-primary"><th></th>';

                                    for ($i = 0; $i < $query->columnCount(); $i++) {
                                        $col = $query->getColumnMeta($i);
                                        echo '<th>' . $col['name'] . '</th>';
                                    }

                                    echo '</tr></thead><tbody>';

                                    for ($i = 0; $i < $query->rowCount(); $i++) {
                                        $row = $query->fetch(PDO::FETCH_ASSOC);

                                        echo '<tr>';

                                        for ($j = 0; $j < $query->columnCount(); $j++) {
                                            $col = $query->getColumnMeta($j);

                                            if ($col['name'] == 'id') {
                                                $pkey = $row[$col['name']];
                                                echo '<td><div class="form-check"><input class="form-check-input delete-chk" name="delete[]" form="delete-form" type="checkbox" value="'.$pkey.'"></div></td>';
                                            }

                                            echo '<td><a href="'.site_url($table.'/'.'edit/'.$pkey).'" class="text-dark table-link">'.$row[$col['name']].'</a></td>';
                                        }

                                        echo '</tr>';
                                    }

                                    echo '</tbody>';
                                ?>
                            </table>
                        </div>

                        <form action="<?php echo site_url($table.'/delete'); ?>" method="post" id="delete-form">
                            <div class="text-left mt-3">
                                <button type="submit" Onclick="return confirm_delete();" class="btn btn-primary delete-btn spinner" disabled>Delete</button>
                            </div>
                        </form>

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
    <script src="<?php echo site_url('assets/vendor/datatables/datatables.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/toastr/toastr.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/datatables.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/toastr.js'); ?>" type="text/javascript"></script>

</body>
</html>