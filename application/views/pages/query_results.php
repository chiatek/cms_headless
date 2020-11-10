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
                        <h3 class="page-title mb-2 mt-4"><?php echo $config->setting_saved_queries; ?></h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <?php
                                    if (!empty($config->setting_saved_queries) && $saved_query_list->rowCount() > 0) {
                                        for ($i = 0; $i < $saved_query_list->rowCount(); $i++) {
                                            $row = $saved_query_list->fetch();

                                            if ($id == $row->id) {
                                                echo '<a href="'.site_url("query/saved_query/".$row->id).'" class="list-group-item list-group-item-action d-flex align-items-center active">
                                                    <span class="icon mr-3"><i class="'.$row->icon.'"></i></span>'.ucfirst($row->name).'
                                                    </a>';
                                            }
                                            else {
                                                echo '<a href="'.site_url("query/saved_query/".$row->id).'" class="list-group-item list-group-item-action d-flex align-items-center">
                                                    <span class="icon mr-3"><i class="'.$row->icon.'"></i></span>'.ucfirst($row->name).'
                                                    </a>';
                                            }
                                        }
                                    }

                                    if (!empty($table)) {
                                        echo '<a href="'.site_url('database/insert_query/'.$table).'" class="list-group-item list-group-item-action d-flex align-items-center mt-3">
                                            <span class="icon mr-3"><i class="fa fa-plus-square-o"></i></span>Insert into '.ucfirst($table).'
                                            </a>';
                                    }

                                    if (!empty($ref_table)) {
                                        echo '<a href="'.site_url('database/insert_query/'.$ref_table).'" class="list-group-item list-group-item-action d-flex align-items-center">
                                            <span class="icon mr-3"><i class="fa fa-plus-square-o"></i></span>Insert into '.ucfirst($ref_table).'
                                            </a>';
                                    }

                                ?>

                                <a href="<?php echo site_url('query/edit_saved_query/queries/id/'.$id); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-pencil"></i></span>Edit Saved Query
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-10 mt-70">

                        <div class="table-responsive">
                            <table id="edit-table" class="table table-striped table-bordered">
                                <?php

                                    if (isset($table)) {
                                        echo '<thead><tr class="table-primary"><th></th>';

                                        for ($i = 0; $i < $query->columnCount(); $i++) {
                                            $col = $query->getColumnMeta($i);

                                            echo '<th>' . $col['name'] . '</th>';
                                        }

                                        echo '</tr></thead><tbody>';

                                        for ($j = 0; $j < $query->rowCount(); $j++) {
                                            $row = $query->fetch(PDO::FETCH_ASSOC);

                                            $primary_key = $foreign_key = $pkey_val = $fkey_val = '';
                                            echo '<tr>';

                                            for ($k = 0; $k < $query->columnCount(); $k++) {
                                                $col = $query->getColumnMeta($k);

                                                if (in_array('primary_key', $col['flags']) == TRUE) {
                                                    $primary_key = $col['name'];
                                                    $pkey_val = $row[$col['name']];
                                                }

                                                if (in_array('multiple_key', $col['flags']) == TRUE) {
                                                    $foreign_key = $col['name'];
                                                    $fkey_val = $row[$col['name']];
                                                }

                                                if ($k == 0) {
                                                    echo '<td><div class="form-check"><input class="form-check-input delete-chk" name="delete[]" form="delete-form" type="checkbox" value="'.$primary_key.'/'.$pkey_val.'"></div></td>';
                                                }

                                                if (!empty($ref_table) && !empty($fkey_val)) {
                                                    if ($col['native_type'] == "BLOB" || ($col['native_type'] == 'VAR_STRING' && $col['len'] >= 250)) {
                                                        echo '<td><a href="'.site_url('query/saved_query/'.$id.'/'.$pkey_val.'/'.$fkey_val).'" class="text-dark table-link">'.get_summary($row[$col['name']], config('summary_sentence_limit')).'</a></td>';
                                                    }
                                                    else {
                                                        echo '<td><a href="'.site_url('query/saved_query/'.$id.'/'.$pkey_val.'/'.$fkey_val).'" class="text-dark table-link">'.$row[$col['name']].'</a></td>';
                                                    }
                                                }
                                                else if (!empty($ref_table) && !empty($pkey_val)) {
                                                    echo '<td>'.$pkey_val.'</td>';
                                                }
                                                else {
                                                    if ($col['native_type'] == "BLOB" || ($col['native_type'] == 'VAR_STRING' && $col['len'] >= 250)) {
                                                        echo '<td><a href="'.site_url('query/saved_query/'.$id.'/'.$pkey_val).'" class="text-dark table-link">'.get_summary($row[$col['name']], config('summary_sentence_limit')).'</a></td>';
                                                    }
                                                    else {
                                                        echo '<td><a href="'.site_url('query/saved_query/'.$id.'/'.$pkey_val).'" class="text-dark table-link">'.$row[$col['name']].'</a></td>';
                                                    }
                                                }

                                            }

                                            echo '</tr>';
                                        }

                                        echo '</tbody>';
                                    }
                                    else {
                                        show_error_404();
                                    }

                                ?>
                            </table>
                        </div>

                        <form action="<?php echo site_url('query/delete/'.$table); ?>" method="post" id="delete-form">
                            <div class="text-left mt-3">
                                <?php if ($user->user_role == "administrator"): ?>
                                    <button type="submit" Onclick="return confirm_delete();" class="btn btn-primary delete-btn spinner" disabled>Delete</button>
                                <?php else: ?>
                                    <button type="button" Onclick="return confirm_delete();" class="btn btn-primary" disabled>Delete</button>
                                <?php endif; ?>
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