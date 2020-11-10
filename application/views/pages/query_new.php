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
                                <?php endif; ?>
                                <a href="<?php echo site_url('query/insert_saved_query'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Saved Query
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mt-70">

                        <div class="card mt-3 pb-5">

                            <form id="regForm" action="<?php echo site_url('query/insert_saved_query'); ?>" id="wizard-form" method="post">

                                <div class="row card-body">
                                    <div class="col-md step py-3">1. Select Table</div>
                                    <div class="col-md step py-3">2. Select Columns</div>
                                    <div class="col-md step py-3">3. Filter Results</div>
                                    <div class="col-md step py-3">4. Choose Name</div>
                                    <div class="col-md step py-3">5. Choose Icon</div>
                                    <div class="col-md step py-3">6. Finish</div>
                                </div>

                                <br />

                                <!-- One "tab" for each step in the form: -->

                                <div class="tab">
                                    <div class="card-body pb-2">
                                        <div class="form-group">
                                            <br>
                                            <select class="custom-select" name="table_name" onchange="getdata(this.value)">
                                                <option value="" selected>select a table</option>
                                                <?php while ($table = $tables->fetch()): ?>
                                                    <option value="<?php echo $table->table_name.'@'.$table->column_name; ?>"><?php echo $table->table_name; ?></option>
                                                <?php endwhile; ?>
                                                <?php while ($ref_table = $ref_tables->fetch()): ?>
                                                    <option value="<?php echo $ref_table->table_name.'@'.$ref_table->referenced_table_name.'@'.$ref_table->column_name.'@'.$ref_table->referenced_column_name; ?>">
                                                        <?php echo $ref_table->table_name . ' and ' . $ref_table->referenced_table_name; ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <br />

                                </div>

                                <div class="tab">
                                    <div class="card-body pb-2">
                                        <h4>Select columns from the table</h4><br>
                                        <div class="form-group">
                                            <div id="ajax_output"></div>
                                        </div>
                                        <br />
                                    </div>
                                </div>

                                <div class="tab">
                                    <div class="card-body pb-2">
                                        <h4>Filter Results</h4>
                                        <br />
                                        <div class="form-group">
                                            <label class="form-label">Where</label>
                                            <textarea class="form-control" name="where_stmt" rows="3"></textarea>
                                        </div>
                                        <br />
                                        <div class="form-group">
                                            <label class="form-label">Order By</label>
                                            <input type="text" class="form-control" name="orderby_stmt">
                                        </div>
                                        <br />
                                        <div class="form-group">
                                            <label class="form-label">Limit</label>
                                            <input type="number" class="form-control" name="limit_stmt">
                                        </div>
                                    </div>
                                </div>

                                <div class="tab">
                                    <div class="card-body pb-2">
                                        <h4>Choose a name</h4>
                                        <br />
                                        <div class="form-group">
                                            <input type="text" class="form-control required" name="name" placeholder="Saved query name...">
                                        </div>
                                        <br />
                                    </div>
                                </div>

                                <div class="tab">
                                    <div class="card-body pb-2">
                                        <div class="form-group">
                                            <h4>Select an icon</h4>
                                            <br />
                                            <?php $this->view('components/misc/icon_list'); ?>
                                        </div>
                                        <br />
                                    </div>
                                </div>

                                <div class="tab">
                                    <div class="card-body pb-2">
                                        <h6>Add this query to the navbar menu or dashboard?</h6>
                                        <br />
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="add_to_menu" value="1" checked>
                                                Add to menu
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="add_to_dashboard" value="1">
                                                Add to dashboard
                                            </label>
                                        </div>
                                        <br /><br /><br />
                                        <h4>To save this query click finish.</h4>
                                    </div>
                                </div>

                                <br>
                                <div style="overflow:auto;">
                                    <div style="float:right;">
                                        <button type="button" id="prevBtn" class="btn btn-primary" onclick="nextPrev(-1)">Previous</button>
                                        <button type="button" id="nextBtn" class="btn btn-primary mr-5" onclick="nextPrev(1)">Next</button>
                                    </div>
                                </div>

                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                    <span class="indicator"></span>
                                    <span class="indicator"></span>
                                    <span class="indicator"></span>
                                    <span class="indicator"></span>
                                    <span class="indicator"></span>
                                    <span class="indicator"></span>
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
    <!-- Additinal Javascript -->
    <script src="<?php echo site_url('assets/js/wizard.js'); ?>" type="text/javascript"></script>

</body>
</html>