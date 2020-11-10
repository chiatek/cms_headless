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
                        <h3 class="page-title mb-2 mt-4"><?php echo $this->database; ?></h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <?php if ($user->user_role == "administrator"): ?>
                                    <a href="<?php echo site_url('database'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-sitemap"></i></span>All Tables
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo site_url('query/saved_query'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-hdd-o"></i></span>Saved Queries
                                </a>
                                <?php if ($user->user_role == "administrator"): ?>
                                    <a href="<?php echo site_url('database/sql'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-terminal"></i></span>SQL Query
                                    </a>
                                    <a href="<?php echo site_url('database/archive'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mb-3">
                                        <span class="icon mr-3"><i class="fa fa-archive"></i></span>Backup/Restore
                                    </a>
                                    <a href="<?php echo site_url('database/column/'.$table); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-folder-open-o"></i></span><?php echo ucfirst($table); ?>
                                    </a>
                                    <a href="<?php echo current_url(); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                        <span class="icon mr-3"><i class="fa fa-pencil"></i></span>Edit <?php echo $column_name; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card mt-70">

                            <div class="card-body">

                                <?php $column = $query->fetch(); ?>

                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="column_name" form="database-form" value="<?php echo $column->column_name; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Type</label>
                                    <select class="custom-select" name="column_type" form="database-form">
                                        <optgroup label="Numeric">
                                            <option value="int" <?php echo $column->data_type == 'int' ? "selected" : ""; ?>>int</option>
                                            <option value="tinyint" <?php echo $column->data_type == 'tinyint' ? "selected" : ""; ?>>tinyint</option>
                                            <option value="smallint" <?php echo $column->data_type == 'smallint' ? "selected" : ""; ?>>smallint</option>
                                            <option value="mediumint" <?php echo $column->data_type == 'mediumint' ? "selected" : ""; ?>>mediumint</option>
                                            <option value="bigint" <?php echo $column->data_type == 'bigint' ? "selected" : ""; ?>>bigint</option>
                                            <option value="decimal" <?php echo $column->data_type == 'decimal' ? "selected" : ""; ?>>decimal</option>
                                            <option value="float" <?php echo $column->data_type == 'float' ? "selected" : ""; ?>>float</option>
                                            <option value="double" <?php echo $column->data_type == 'double' ? "selected" : ""; ?>>double</option>
                                            <option value="boolean" <?php echo $column->data_type == 'boolean' ? "selected" : ""; ?>>boolean</option>
                                        </optgroup>

                                        <optgroup label="String">
                                            <option value="char" <?php echo $column->data_type == 'char' ? "selected" : ""; ?>>char</option>
                                            <option value="varchar" <?php echo $column->data_type == 'varchar' ? "selected" : ""; ?>>varchar</option>
                                            <option value="tinytext" <?php echo $column->data_type == 'tinytext' ? "selected" : ""; ?>>tinytext</option>
                                            <option value="text" <?php echo $column->data_type == 'text' ? "selected" : ""; ?>>text</option>
                                            <option value="mediumtext" <?php echo $column->data_type == 'mediumtext' ? "selected" : ""; ?>>mediumtext</option>
                                            <option value="longtext" <?php echo $column->data_type == 'longtext' ? "selected" : ""; ?>>longtext</option>
                                            <option value="tinyblob" <?php echo $column->data_type == 'tinyblob' ? "selected" : ""; ?>>tinyblob</option>
                                            <option value="mediumblob" <?php echo $column->data_type == 'mediumblob' ? "selected" : ""; ?>>mediumblob</option>
                                            <option value="blob" <?php echo $column->data_type == 'blob' ? "selected" : ""; ?>>blob</option>
                                            <option value="longblob" <?php echo $column->data_type == 'longblob' ? "selected" : ""; ?>>longblob</option>
                                            <option value="enum" <?php echo $column->data_type == 'enum' ? "selected" : ""; ?>>enum</option>
                                        </optgroup>

                                        <optgroup label="Date and Time">
                                            <option value="date" <?php echo $column->data_type == 'date' ? "selected" : ""; ?>>date</option>
                                            <option value="datetime" <?php echo $column->data_type == 'datetime' ? "selected" : ""; ?>>datetime</option>
                                            <option value="timestamp" <?php echo $column->data_type == 'timestamp' ? "selected" : ""; ?>>timestamp</option>
                                            <option value="time" <?php echo $column->data_type == 'time' ? "selected" : ""; ?>>time</option>
                                            <option value="year" <?php echo $column->data_type == 'year' ? "selected" : ""; ?>>year</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <?php if (isset($column->char_length)): ?>
                                <div class="form-group">
                                    <label class="form-label">Char Length</label>
                                    <input type="text" class="form-control" name="char_length" form="database-form" value="<?php echo $column->char_length; ?>">
                                </div>
                                <?php endif; ?>

                                <?php if (isset($column->num_length)): ?>
                                <div class="form-group">
                                    <label class="form-label">Num Length</label>
                                    <input type="text" class="form-control" name="num_length" form="database-form" value="<?php echo $column->num_length; ?>">
                                </div>
                                <?php endif; ?>

                                <br />

                                <div class="form-check">
                                    <label class="form-check-label">
                                        <?php if ($column->column_key == 'PRI' || $column->column_key == 'MUL' || $column->column_key == 'UNI'): ?>
                                            <input type="checkbox" class="form-check-input" name="is_nullable" form="database-form" value="YES" disabled>
                                        <?php else: ?>
                                            <input type="checkbox" class="form-check-input" name="is_nullable" form="database-form" value="YES" <?php echo ($column->nullable == 'YES') ? "checked" : ""; ?>>
                                        <?php endif; ?>
                                        Is Nullable
                                    </label>
                                </div>

                                <br />

                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="column_key" form="database-form" value="PRI" <?php echo ($column->column_key == 'PRI') ? "checked " : " "; ?>disabled>
                                        Primary Key
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="column_key" form="database-form" value="MUL" <?php echo ($column->column_key == 'MUL') ? "checked " : " "; ?>disabled>
                                        Foreign Key
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="form-check-label">
                                        <?php if ($column->column_key == 'PRI' || $column->column_key == 'MUL'): ?>
                                            <input type="checkbox" class="form-check-input" name="column_key" form="database-form" value="UNI" disabled>
                                        <?php elseif ($column->column_key == 'UNI'): ?>
                                            <input type="checkbox" class="form-check-input" name="column_key" form="database-form" value="UNI" checked>
                                            <?php $key = 'UNI'; ?>
                                        <?php else: ?>
                                            <input type="checkbox" class="form-check-input" name="column_key" form="database-form" value="UNI">
                                            <?php $key = NULL; ?>
                                        <?php endif; ?>
                                        Unique
                                    </label>
                                </div>

                                <br />

                            </div>

                            <form action="<?php echo site_url('database/edit_column/'.$table.'/'.$column_name.'/'.$key); ?>" method="post" id="database-form">
                                <div class="text-right mr-5 mt-3 pb-5">
                                    <button type="submit" class="btn btn-primary save-btn spinner">Save</button>&nbsp;
                                    <a href="<?php echo site_url('database'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
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