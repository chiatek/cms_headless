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
                        <h3 class="page-title mb-2 mt-4">Settings</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="#settings-general" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-info-circle"></i></span>General
                                </a>
                                <a href="#settings-database" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-database"></i></span>Database
                                </a>
                                <a href="#settings-media" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-photo"></i></span>Media
                                </a>
                                <a href="#settings-preferences" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-sliders"></i></span>Preferences
                                </a>
                                <a href="#settings-analytics" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-share-alt"></i></span>Analytics
                                </a>
                                <a href="#settings-backup" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-download"></i></span>Export
                                </a>
                                <a href="#settings-about" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-info-circle"></i></span>About
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mt-35">
                        <div class="card tab-content">

                            <div class="tab-pane fade show active" id="settings-general">
                                <div class="card-body">
                                    <h4 class="mb-4">General</h4><br />
                                    <div class="form-group">
                                        <label class="form-label">CMS Address</label>
                                        <input type="text" class="form-control mb-1" value="<?php echo site_url(); ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Website Address (URL)</label>
                                        <input type="text" class="form-control" name="setting_url" form="settings-form" value="<?php echo $config->setting_url; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Index.html (Document Root) File Location</label>
                                        <input type="text" class="form-control" id="setting_root" name="setting_root" form="settings-form" value="<?php echo $config->setting_root; ?>">
                                        <div class="alert alert-warning mt-3">
                                            Your website must be hosted on the same server as the CMS for the index.html (document root) file location to be set.
                                        </div>
                                    </div>  
                                    <div class="form-group">
                                        <label class="form-label">Site Title</label>
                                        <?php if (!empty($config->setting_root)): ?>
                                            <input type="text" class="form-control" name="setting_title" form="settings-form" value="<?php echo $config->setting_title; ?>">
                                        <?php else: ?>
                                            <input type="text" class="form-control" name="setting_title" form="settings-form" value="" readonly>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tagline</label>
                                        <?php if (!empty($config->setting_root)): ?>
                                            <input type="text" class="form-control" name="setting_tagline" form="settings-form" value="<?php echo $config->setting_tagline; ?>">
                                        <?php else: ?>
                                            <input type="text" class="form-control" name="setting_tagline" form="settings-form" value="" readonly>
                                            <div class="alert alert-warning mt-3">
                                                Enter the index.html (document root) file location above to set the site title and tagline.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="settings-database">
                                <div class="card-body">
                                    <h4 class="mb-4">Database</h4><br />
                                    <div class="form-group">
                                        <label class="form-label">Database Name</label>
                                        <input type="text" class="form-control" name="setting_database" form="settings-form" value="<?php echo $config->setting_database; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Saved Query Menu Title</label>
                                        <input type="text" class="form-control" name="setting_saved_queries" form="settings-form" value="<?php echo $config->setting_saved_queries; ?>">
                                    </div>
                                    <br />
                                    <h4 class="mb-4">Content Delivery API</h4><br />
                                    <?php if (!empty($config->setting_database)): ?>
                                        <div class="form-group">
                                            <label class="form-label">Content Delivery File Location</label>
                                            <input type="text" class="form-control" name="setting_api" form="settings-form" value="<?php echo $config->setting_api; ?>">
                                        </div>
                                        <div class="alert alert-secondary mt-3">
                                            <?php if (!empty($_SESSION["user_api"])): ?>
                                                <p>Use the following path to retrieve data from your database:<br />
                                                <strong><?php echo $_SESSION["user_api"]; ?></strong></p>
                                            <?php endif; ?>
                                            <p>Use the following URL to send updates to your database:<br />
                                            <strong><?php echo site_url('users/api'); ?></strong></p>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning mt-3">
                                            Enter a database name above to enable content delivery API.
                                        </div>
                                    <?php endif; ?>       
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="settings-media">
                                <div class="card-body">
                                    <h4 class="mb-4">Media</h4><br />
                                    <div class="form-group">
                                        <label class="form-label">Media Folder Location</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="setting_media"></span>
                                            </div>
                                            <?php if (!empty($config->setting_url) && !empty($config->setting_root)): ?>
                                                <input type="text" class="form-control" name="setting_media" form="settings-form" value="<?php echo $config->setting_media; ?>">
                                            <?php else: ?>
                                                <input type="text" class="form-control" name="setting_media" form="settings-form" value="" readonly>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (empty($config->setting_url) || empty($config->setting_root)): ?>
                                            <div class="alert alert-warning mt-3">
                                                The website address (URL) and index.html (document root) file location must be set in the <i>General</i> tab to enable media folder access.
                                            </div>
                                        <?php endif; ?>
                                    </div> 
                                    <div class="form-group">
                                        <label class="form-label">Site Icon</label>
										<div class="row">
											<div class="col-9">
												<input type="text" class="form-control" id="site-icon" name="setting_siteicon" form="settings-form" value="<?php echo $config->setting_siteicon; ?>" readonly>
											</div>
	                                        <div class="col-3">
                                                <?php if (!empty($config->setting_url) && !empty($config->setting_root) && !empty($config->setting_media)): ?>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#icon-modal">Select</button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#icon-modal" disabled>Select</button>
                                                <?php endif; ?>
											</div>
										</div>
                                        <?php if (empty($config->setting_media)): ?>
                                            <div class="alert alert-warning mt-3">
                                                Enter a media folder location above to enable site icon selection.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="settings-preferences">
                                <div class="card-body">
                                    <h4 class="mb-5">Preferences</h4><br />
                                    <h5 class="mb-4">Style</h5><br />
                                    <div class="form-group">
                                        <label class="form-label">CSS File Location</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="setting_css"></span>
                                            </div>
                                            <?php if (!empty($config->setting_root)): ?>
                                                <input type="text" class="form-control" name="setting_css" form="settings-form" value="<?php echo $config->setting_css; ?>">
                                            <?php else: ?>
                                                <input type="text" class="form-control" name="setting_css" form="settings-form" value="" readonly>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (empty($config->setting_root)): ?>
                                            <div class="alert alert-warning mt-3">
                                                The index.html (document root) file location must be set in the <i>General</i> tab enable CSS file selection.
                                            </div>
                                        <?php endif; ?>
                                    </div> 
									<div class="form-group">
										<label class="form-label">Date/Time Format</label>
										<select class="custom-select" name="setting_datetime" form="settings-form">
											<option value="F d Y, h:i:s A" <?php echo ($config->setting_datetime == 'F d Y, h:i:s A') ? "selected" : ""; ?>>October 12 2018, 09:58:00 PM (F d Y, h:i:s A)</option>
											<option value="Y-m-d h:i:sa" <?php echo ($config->setting_datetime == 'Y-m-d h:i:sa') ? "selected" : ""; ?>>2014-08-12 11:14:54am (Y-m-d h:i:sa)</option>
                                            <option value="m/d/Y h:i:sa" <?php echo ($config->setting_datetime == 'm/d/Y h:i:sa') ? "selected" : ""; ?>>08/12/2018 11:14:54am (m/d/Y h:i:sa)</option>
                                            <option value="m.d.Y h:i:sa" <?php echo ($config->setting_datetime == 'm.d.Y h:i:sa') ? "selected" : ""; ?>>08.12.2018 11:14:54am (m.d.Y h:i:sa)</option>
                                            <option value="F d Y" <?php echo ($config->setting_datetime == 'F d Y') ? "selected" : ""; ?>>October 12 2018 (F d Y)</option>
										</select>
									</div>
                                </div>

                                <hr class="border-light m-0">

                                <div class="card-body">
                                    <h5 class="mb-4">Dashboard</h5><br />
                                    <div class="d-flex flex-wrap">
                                        <div class="form-check pr-4">
                                            <?php if ($config->setting_posts): ?>
                                            <label class="form-check-label mb-2">
                                                <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_posts_widget" form="settings-form" value="1" <?php echo ($config->setting_dashboard_posts_widget == '1') ? "checked" : ""; ?>>
                                            <?php else: ?>
                                                <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_posts_widget" form="settings-form" value="0" disabled>
                                            <?php endif; ?>
                                                Posts Widget
                                            </label>
                                        </div>
                                        <div class="form-check pr-4">
                                            <label class="form-check-label mb-2">
                                            <?php if ($config->setting_posts): ?>
                                                <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_posts" form="settings-form" value="1" <?php echo ($config->setting_dashboard_posts == '1') ? "checked" : ""; ?>>
                                            <?php else: ?>
                                                <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_posts" form="settings-form" value="0" disabled>
                                            <?php endif; ?>
                                                Recent Posts
                                            </label>
                                        </div>
                                        <div class="form-check pr-4">
                                            <label class="form-check-label mb-2">
                                            <?php if ($config->setting_posts): ?>
                                                <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_comments" form="settings-form" value="1" <?php echo ($config->setting_dashboard_comments == '1') ? "checked" : ""; ?>>
                                            <?php else: ?>
                                                <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_comments" form="settings-form" value="0" disabled>
                                            <?php endif; ?>
                                                Latest Comments
                                            </label>
                                        </div>
                                        <div class="form-check pr-4">
                                            <label class="form-check-label mb-2">
                                                <?php if (!empty($config->setting_GA_key_location)): ?>
                                                    <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_GA_widget" form="settings-form" value="1" <?php echo ($config->setting_dashboard_GA_widget == '1') ? "checked" : ""; ?>>
                                                <?php else: ?>
                                                    <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_GA_widget" form="settings-form" value="0" disabled>
                                                <?php endif; ?>
                                                Analytics Widget
                                            </label>
                                        </div>
                                        <div class="form-check pr-4">
                                            <label class="form-check-label mb-2">
                                                <?php if (!empty($config->setting_GA_key_location)): ?>
                                                    <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_GA_chart" form="settings-form" value="1" <?php echo ($config->setting_dashboard_GA_chart == '1') ? "checked" : ""; ?>>
                                                <?php else: ?>
                                                    <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_GA_chart" form="settings-form" value="0" disabled>
                                                <?php endif; ?>
                                                Analytics Chart
                                            </label>
                                        </div>
                                        <div class="form-check pr-4">
                                            <label class="form-check-label mb-2">
                                                <?php if (!empty($config->setting_GA_key_location)): ?>
                                                    <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_GA_stats" form="settings-form" value="1" <?php echo ($config->setting_dashboard_GA_stats == '1') ? "checked" : ""; ?>>
                                                <?php else: ?>
                                                    <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_GA_stats" form="settings-form" value="0" disabled>
                                                <?php endif; ?>
                                                Analytics Info
                                            </label>
                                        </div>
                                        <?php if (empty($config->setting_GA_key_location)): ?>
                                            <div class="alert alert-warning mt-3">
                                                To display Google Analytics on the dashboard the key file location and tracking code must be set in the <i>Analytics</i> tab. For information about obtaining this code check out the
                                                <i><a href="https://developers.google.com/analytics/devguides/config/mgmt/v3/quickstart/service-php" target="_blank">Hello Analytics API</a></i> documentation.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

								<hr class="border-light m-0">

								<div class="card-body">
                                <h5 class="mb-4">Posts</h5><br />
									<div class="form-check">
										<label class="form-check-label">
                                            <?php if (!empty($config->setting_database)): ?>
											    <input type="checkbox" class="form-check-input" name="setting_posts" form="settings-form" value="1" <?php echo ($config->setting_posts == '1') ? "checked" : ""; ?>>
                                            <?php else: ?>
                                                <input type="checkbox" class="form-check-input" name="setting_posts" form="settings-form" value="0" disabled>
                                            <?php endif; ?>
											Enable Posts
										</label>
									</div>
                                    <?php if (empty($config->setting_database)): ?>
                                        <div class="alert alert-warning mt-3">
                                            Enter a database name in the <i>Database</i> tab to enable posts and dashboard post widgets.
                                        </div>
                                    <?php endif; ?>
								</div>
                            </div>

                            <div class="tab-pane fade" id="settings-analytics">
                                <div class="card-body">
                                    <h4 class="mb-4">Analytics</h4><br />
                                    <div class="form-group">
                                        <label class="form-label">Tracking ID</label>
                                        <input type="text" class="form-control mb-1" name="setting_GA_trackingid" form="settings-form" value="<?php echo $config->setting_GA_trackingid; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Key File Location</label>
                                        <input type="text" class="form-control mb-1" name="setting_GA_key_location" form="settings-form" value="<?php echo $config->setting_GA_key_location; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tracking Code</label>
                                        <textarea class="form-control" name="setting_GA_code" form="settings-form" rows="8"><?php echo $config->setting_GA_code; ?></textarea>
                                    </div>
                                    <div class="alert alert-warning mt-3">
                                        *Do not include the <code>&lt;script&gt;</code> tags or <i>async src</i> in the tracking code.
                                    </div>
                                    <br />
                                </div>
                            </div>

							<div class="tab-pane fade" id="settings-backup">
								<div class="card-body">
                                    <h4 class="mb-4">Export</h4><br />
									<div class="form-group">
										<fieldset class="form-group">
										  	<legend>Choose what to export</legend>
										  	<div class="form-check m-3">
										  		<label class="form-check-label">
											  	<input type="radio" class="form-check-input" name="download" form="download-form" value="sql" checked>
											  		Database
												</label>
										  	</div>
                                            <div class="form-check m-3">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="download" form="download-form" value="logs">
                                                    Error Log
                                                </label>
                                            </div>
										</fieldset>

                                        <form action="<?php echo site_url('settings/download'); ?>" method="post" id="download-form">
                                            <button type="submit" class="btn btn-outline-primary btn-sm">Download Export FIle</button>
                                        </form>
									</div>
								</div>
							</div>

                            <div class="tab-pane fade" id="settings-about">
                                <div class="card-body">
                                    <img src="<?php echo site_url('assets/img/logo_sm_gray.svg'); ?>" class="about-logo" alt="logo">
                                    <hr />
                                    <div class="form-group">
										<label class="form-label">CMS Version:
											<span class="text-muted"><?php echo config('cms_version'); ?></span>
										</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Database Name:
											<span class="text-muted"><?php echo $this->db->database(); ?></span>
										</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Base Path:
											<span class="text-muted"><?php echo BASEPATH; ?></span>
										</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">PHP Version:
											<span class="text-muted"><?php echo phpversion(); ?></span>
										</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Client Library Version:
											<span class="text-muted"><?php echo $this->db->client_version(); ?></span>
										</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Server Version:
											<span class="text-muted"><?php echo $this->db->server_version(); ?></span>
										</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Server Info:
											<span class="text-muted"><?php echo $this->db->server_info(); ?></span>
										</label>
                                    </div>
                                    <br><br>
                                    <label class="form-label text-muted">© Copyright 2020 halografix</label>
                                </div>
                            </div>

                            <br />

                            <form action="<?php echo site_url('settings'); ?>" method="post" id="settings-form">
                                <div class="card-body text-right mt-3">
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

        <!-- Image Modal -->
        <?php $this->view('components/modals/icon_modal', $data); ?>
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
    <!-- Additinal Javascript -->
    <script src="<?php echo site_url('assets/vendor/toastr/toastr.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/toastr.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/theme.js'); ?>" type="text/javascript"></script>

</body>
</html>