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
                        <h3 class="page-title mb-2 mt-4">Users</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <?php if ($user->user_role == "administrator"): ?>
                                <a href="<?php echo site_url('users'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-users"></i></span>All Users
                                </a>
                                <a href="<?php echo site_url('users/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-user-plus"></i></span>New User
                                </a>
                                <?php endif; ?>
                                <a href="<?= site_url('users/profile'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-user"></i></span>My Profile
                                </a>
                            </div>
                        </div>

                        <h3 class="page-title mb-2 mt-4">Profile</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <?php if (isset($change_password)): ?>
                                    <a href="#account-general" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-wrench"></i></span>General
                                    </a>
                                    <a href="#account-change-password" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center active">
                                        <span class="icon mr-3"><i class="fa fa-lock"></i></span>Change Password
                                    </a>
                                <?php else: ?>
                                    <a href="#account-general" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center active">
                                        <span class="icon mr-3"><i class="fa fa-wrench"></i></span>General
                                    </a>
                                    <a href="#account-change-password" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-lock"></i></span>Change Password
                                    </a>
                                <?php endif; ?>
                                <a href="#account-info" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-info-circle"></i></span>Info
                                </a>
                                <a href="#account-social-links" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-share-alt"></i></span>Social Links
                                </a>
                                <a href="#account-theme" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-picture-o"></i></span>Theme
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mt-35">
                        <div class="card tab-content">
                            <?php if (isset($change_password)): ?>
                            <div class="tab-pane fade" id="account-general">
                            <?php else: ?>
                            <div class="tab-pane fade show active" id="account-general">
                            <?php endif; ?>

                                <div class="card-body">
                                    <h6 class="mb-4">Avatar</h6>

                                    <div class="d-flex flex-wrap align-content-start">
                                        <div class="p-2 m-2">
                                            <img src="<?php echo site_url('assets/img/avatar1.png'); ?>" data-avatar="<?php echo site_url('assets/img/avatar1.png'); ?>" class="avatar <?php echo ($user->user_avatar == site_url('assets/img/avatar1.png')) ? "selected" : ""; ?>">
                                        </div>
                                        <div class="p-2 m-2">
                                            <img src="<?php echo site_url('assets/img/avatar2.png'); ?>" data-avatar="<?php echo site_url('assets/img/avatar2.png'); ?>" class="avatar <?php echo ($user->user_avatar == site_url('assets/img/avatar2.png')) ? "selected" : ""; ?>">
                                        </div>
                                        <div class="p-2 m-2">
                                            <img src="<?php echo site_url('assets/img/avatar3.png'); ?>" data-avatar="<?php echo site_url('assets/img/avatar3.png'); ?>" class="avatar <?php echo ($user->user_avatar == site_url('assets/img/avatar3.png')) ? "selected" : ""; ?>">
                                        </div>
                                        <div class="p-2 m-2">
                                            <img src="<?php echo site_url('assets/img/avatar4.png'); ?>" data-avatar="<?php echo site_url('assets/img/avatar4.png'); ?>" class="avatar <?php echo ($user->user_avatar == site_url('assets/img/avatar4.png')) ? "selected" : ""; ?>">
                                        </div>
                                        <div class="p-2 m-2">
                                            <img src="<?php echo site_url('assets/img/avatar5.png'); ?>" data-avatar="<?php echo site_url('assets/img/avatar5.png'); ?>" class="avatar <?php echo ($user->user_avatar == site_url('assets/img/avatar5.png')) ? "selected" : ""; ?>">
                                        </div>
                                        <div class="p-2 m-2">
                                            <img src="<?php echo site_url('assets/img/avatar6.png'); ?>" data-avatar="<?php echo site_url('assets/img/avatar6.png'); ?>" class="avatar <?php echo ($user->user_avatar == site_url('assets/img/avatar6.png')) ? "selected" : ""; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3 ml-4">
                                        <div class="row">
                                            <div class="col-9">
                                                <input type="text" class="form-control" name="user_avatar" id="user_avatar" form="profile-form" value="<?php echo $user->user_avatar; ?>" readonly>
                                            </div>
                                            <div class="col-3">
                                                <?php if (!empty($config->setting_url) && !empty($config->setting_root) && !empty($config->setting_media)): ?>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#image-modal">Custom</button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#image-modal" disabled>Custom</button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <br /><hr /><br />

                                    <h6 class="mb-4">General Info</h6><br />
                                    <div class="form-group">
                                        <label class="form-label">User ID</label>
                                        <input type="text" class="form-control mb-1" name="user_id" value="<?php echo $user->user_id; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control mb-1" name="user_username" value="<?php echo $user->user_username; ?>" disabled>
                                        <input type="hidden" name="user_username" form="profile-form" value="<?php echo $user->user_username; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="user_name" form="profile-form" value="<?php echo $user->user_name; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" class="form-control mb-1" name="user_email" form="profile-form" value="<?php echo $user->user_email; ?>">
                                    </div>

                                    <br />

                                    <div class="form-group">
                                        <label class="form-label">Company</label>
                                        <input type="text" class="form-control" name="user_company" form="profile-form" value="<?php echo $user->user_company; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control" name="user_role" value="<?php echo $user->user_role; ?>" disabled>
                                    </div>

                                    <p class="text-danger"><?php echo $this->form_validation->validation_errors(); ?></p>
                                    <br />
                                </div>
                            </div>

                            <?php if (isset($change_password)): ?>
                            <div class="tab-pane fade show active" id="account-change-password">
                            <?php else: ?>
                            <div class="tab-pane fade" id="account-change-password">
                            <?php endif; ?>
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" class="form-control" name="current_password" autocomplete="current-password" form="password-form">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control" name="new_password" autocomplete="new-password" form="password-form">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Repeat new password</label>
                                        <input type="password" class="form-control" name="repeat_password" autocomplete="new-password" form="password-form">
                                    </div>
                                    <form action="<?php echo site_url('users/change_password'); ?>" method="post" id="password-form">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">Change Password</button>
                                    </form>

                                    <br /><br />

                                    <p class="text-danger"><?php echo $this->form_validation->validation_errors(); ?></p>
                                    <br />
                                </div>
                            </div>

                            <div class="tab-pane fade" id="account-info">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Bio</label>
                                        <textarea class="form-control" name="user_bio" form="profile-form" rows="5"><?php echo $user->user_bio; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Birthday</label>
                                        <input type="date" class="form-control" name="user_birthday" form="profile-form" value="<?php echo $user->user_birthday; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Country</label>
                                        <input type="text" class="form-control" name="user_country" form="profile-form" value="<?php echo $user->user_country; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="user_phone" form="profile-form" value="<?php echo $user->user_phone; ?>">
                                    </div>
                                </div>

                                <br />
                            </div>

                            <div class="tab-pane fade" id="account-social-links">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Twitter</label>
                                        <input type="text" class="form-control" name="user_twitter" form="profile-form" value="<?php echo $user->user_twitter; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Facebook</label>
                                        <input type="text" class="form-control" name="user_facebook" form="profile-form" value="<?php echo $user->user_facebook; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">YouTube</label>
                                        <input type="text" class="form-control" name="user_youtube" form="profile-form" value="<?php echo $user->user_youtube; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">LinkedIn</label>
                                        <input type="text" class="form-control" name="user_linkedin" form="profile-form" value="<?php echo $user->user_linkedin; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Instagram</label>
                                        <input type="text" class="form-control" name="user_instagram" form="profile-form" value="<?php echo $user->user_instagram; ?>">
                                    </div>

                                    <br />
                                </div>
                            </div>

                            <div class="tab-pane fade" id="account-theme">
                                <div class="card-body">
                                    <h6 class="mb-4">Theme</h6>
                                    <div class="d-flex flex-wrap">
                                        <div class="p-2 m-2">
                                            <h6>Default</h6>
                                            <a href="#" data-theme="default.css" data-header="bg-dark header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/default.css'); ?>')" class="theme <?php echo ($user->user_theme == 'default.css') ? "selected" : ""; ?>">
                                                  <div class="d-flex">
                                                      <div class="p-2 default-dark theme-color"></div><div class="p-2 default-light theme-color"></div><div class="p-2 default-primary theme-color"></div>
                                                  </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Cerulean</h6>
                                            <a href="#" data-theme="cerulean.css" data-header="bg-primary header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/cerulean.css'); ?>')" class="theme <?php echo ($user->user_theme == 'cerulean.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 cerulean-dark theme-color"></div><div class="p-2 cerulean-light theme-color"></div><div class="p-2 cerulean-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Cosmo</h6>
                                            <a href="#" data-theme="cosmo.css" data-header="bg-dark header-dark" data-footer="bg-dark header-dark" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/cosmo.css'); ?>')" class="theme <?php echo ($user->user_theme == 'cosmo.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 cosmo-dark theme-color"></div><div class="p-2 cosmo-light theme-color"></div><div class="p-2 cosmo-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Cyborg</h6>
                                            <a href="#" data-theme="cyborg.css" data-header="bg-primary header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/cyborg.css'); ?>')" class="theme <?php echo ($user->user_theme == 'cyborg.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 cyborg-dark theme-color"></div><div class="p-2 cyborg-light theme-color"></div><div class="p-2 cyborg-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Darkly</h6>
                                            <a href="#" data-theme="darkly.css" data-header="bg-primary header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/darkly.css'); ?>')" class="theme <?php echo ($user->user_theme == 'darkly.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 darkly-dark theme-color"></div><div class="p-2 darkly-light theme-color"></div><div class="p-2 darkly-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Flatly</h6>
                                            <a href="#" data-theme="flatly.css" data-header="bg-primary header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/flatly.css'); ?>')" class="theme <?php echo ($user->user_theme == 'flatly.css') ? "selected" : ""; ?>">
                                                  <div class="d-flex">
                                                      <div class="p-2 flatly-dark theme-color"></div><div class="p-2 flatly-light theme-color"></div><div class="p-2 flatly-primary theme-color"></div>
                                                  </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Journal</h6>
                                            <a href="#" data-theme="journal.css" data-header="bg-dark header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/journal.css'); ?>')" class="theme <?php echo ($user->user_theme == 'journal.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 journal-dark theme-color"></div><div class="p-2 journal-light theme-color"></div><div class="p-2 journal-primary theme-color"></div>
                                                </div>
                                            </a>
                                          </div>
                                          <div class="p-2 m-2">
                                              <h6>Litera</h6>
                                              <a href="#" data-theme="litera.css" data-header="bg-primary header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/litera.css'); ?>')" class="theme <?php echo ($user->user_theme == 'litera.css') ? "selected" : ""; ?>">
                                              <div class="d-flex">
                                                  <div class="p-2 litera-dark theme-color"></div><div class="p-2 litera-light theme-color"></div><div class="p-2 litera-primary theme-color"></div>
                                              </div>
                                          </a>
                                        </div>
                                        <div class="p-2 m-2">
                                          <h6>Lumen</h6>
                                          <a href="#" data-theme="lumen.css" data-header="bg-primary header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/lumen.css'); ?>')" class="theme <?php echo ($user->user_theme == 'lumen.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 lumen-dark theme-color"></div><div class="p-2 lumen-light theme-color"></div><div class="p-2 lumen-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Lux</h6>
                                            <a href="#" data-theme="lux.css" data-header="bg-dark header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/lux.css'); ?>')" class="theme <?php echo ($user->user_theme == 'lux.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 lux-dark theme-color"></div><div class="p-2 lux-light theme-color"></div><div class="p-2 lux-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Materia</h6>
                                            <a href="#" data-theme="materia.css" data-header="bg-primary header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/materia.css'); ?>')" class="theme <?php echo ($user->user_theme == 'materia.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 materia-dark theme-color"></div><div class="p-2 materia-light theme-color"></div><div class="p-2 materia-primary theme-color"></div>
                                                  </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Minty</h6>
                                            <a href="#" data-theme="minty.css" data-header="bg-primary header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/minty.css'); ?>')" class="theme <?php echo ($user->user_theme == 'minty.css') ? "selected" : ""; ?>">
                                                  <div class="d-flex">
                                                      <div class="p-2 minty-dark theme-color"></div><div class="p-2 minty-light theme-color"></div><div class="p-2 minty-primary theme-color"></div>
                                                  </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Pulse</h6>
                                            <a href="#" data-theme="pulse.css" data-header="bg-primary header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/pulse.css'); ?>')" class="theme <?php echo ($user->user_theme == 'pulse.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 pulse-dark theme-color"></div><div class="p-2 pulse-light theme-color"></div><div class="p-2 pulse-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Sandstone</h6>
                                            <a href="#" data-theme="sandstone.css" data-header="bg-primary header-dark" data-footer="bg-primary header-dark" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/sandstone.css'); ?>')" class="theme <?php echo ($user->user_theme == 'sandstone.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 sandstone-dark theme-color"></div><div class="p-2 sandstone-light theme-color"></div><div class="p-2 sandstone-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Simplex</h6>
                                            <a href="#" data-theme="simplex.css" data-header="bg-primary header-dark" data-footer="bg-dark header-dark" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/simplex.css'); ?>')" class="theme <?php echo ($user->user_theme == 'simplex.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 simplex-dark theme-color"></div><div class="p-2 simplex-light theme-color"></div><div class="p-2 simplex-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Sketchy</h6>
                                            <a href="#" data-theme="sketchy.css" data-header="bg-primary header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/sketchy.css'); ?>')" class="theme <?php echo ($user->user_theme == 'sketchy.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 sketchy-dark theme-color"></div><div class="p-2 sketchy-light theme-color"></div><div class="p-2 sketchy-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Slate</h6>
                                            <a href="#" data-theme="slate.css" data-header="bg-primary header-dark" data-footer="bg-primary header-dark" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/slate.css'); ?>')" class="theme <?php echo ($user->user_theme == 'slate.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 slate-dark theme-color"></div><div class="p-2 slate-light theme-color"></div><div class="p-2 slate-primary theme-color"></div>
                                                  </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Solar</h6>
                                            <a href="#" data-theme="solar.css" data-header="bg-primary header-dark" data-footer="bg-light header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/solar.css'); ?>')" class="theme <?php echo ($user->user_theme == 'solar.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 solar-dark theme-color"></div><div class="p-2 solar-light theme-color"></div><div class="p-2 solar-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Spacelab</h6>
                                            <a href="#" data-theme="spacelab.css"data-header="bg-primary header-dark" data-footer="bg-white header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/spacelab.css'); ?>')" class="theme <?php echo ($user->user_theme == 'spacelab.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 spacelab-dark theme-color"></div><div class="p-2 spacelab-light theme-color"></div><div class="p-2 spacelab-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Superhero</h6>
                                            <a href="#" data-theme="superhero.css" data-header="bg-primary header-dark" data-footer="bg-secondary header-dark" data-subheader="bg-secondary header-dark" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/superhero.css'); ?>')" class="theme <?php echo ($user->user_theme == 'superhero.css') ? "selected" : ""; ?>">
                                                  <div class="d-flex">
                                                      <div class="p-2 superhero-dark theme-color"></div><div class="p-2 superhero-light theme-color"></div><div class="p-2 superhero-primary theme-color"></div>
                                                  </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>United</h6>
                                            <a href="#" data-theme="united.css" data-header="bg-dark header-dark" data-footer="bg-white header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/united.css'); ?>')" class="theme <?php echo ($user->user_theme == 'united.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 united-dark theme-color"></div><div class="p-2 united-light theme-color"></div><div class="p-2 united-primary theme-color"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="p-2 m-2">
                                            <h6>Yeti</h6>
                                            <a href="#" data-theme="yeti.css" data-header="bg-primary header-dark" data-footer="bg-white header-light" data-subheader="bg-light header-light" onclick="swapStyleSheet('<?php echo site_url('assets/vendor/bootstrap/css/theme/yeti.css'); ?>')" class="theme <?php echo ($user->user_theme == 'yeti.css') ? "selected" : ""; ?>">
                                                <div class="d-flex">
                                                    <div class="p-2 yeti-dark theme-color"></div><div class="p-2 yeti-light theme-color"></div><div class="p-2 yeti-primary theme-color"></div>
                                                  </div>
                                            </a>
                                        </div>

                                        <input type="hidden" name="user_theme" id="user_theme" form="profile-form" value="<?php echo $user->user_theme; ?>" />
                                        <input type="hidden" name="user_theme_header" id="user_theme_header" form="profile-form" value="<?php echo $user->user_theme_header; ?>" />
                                        <input type="hidden" name="user_theme_subheader" id="user_theme_subheader" form="profile-form" value="<?php echo $user->user_theme_subheader; ?>" />
                                        <input type="hidden" name="user_theme_footer" id="user_theme_footer" form="profile-form" value="<?php echo $user->user_theme_footer; ?>" />

                                    </div>

                                    <br />

                                </div>

                            </div>

                            <form action="<?php echo site_url('users/profile/'.$user->user_id); ?>" method="post" id="profile-form">
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

        <!-- Image Modal -->
        <?php $this->view('components/modals/image_modal', $data); ?>
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