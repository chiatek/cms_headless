<div class="header <?php echo $user->user_theme_header; ?> py-4">
    <div class="container">
        <div class="d-flex">
            <a class="header-brand" href="<?php echo base_url(); ?>">
                <i class="fa fa-external-link-square"></i> <?= $_SERVER['HTTP_HOST']; ?>
            </a>
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown d-none d-md-flex">
                    <li class="nav-item dropdown mt-3 p-0 mx-2">
                        <a class="header-link top-link" href="<?php echo $config->setting_url; ?>" target="_blank">
                            <i class="fa fa-home" style="font-size:18px"></i>
                        </a>
                    </li>
                </div>
                <div class="dropdown d-none d-md-flex">
                    <a class="nav-link header-link top-link icon mt-3" href="#" data-toggle="dropdown">
                        <i class="fa fa-bell mr-1"></i>
                        <span class="badge badge-pill badge-warning"><?php echo $total_notifications; ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow notifications">
                        <?php if ($total_notifications == 0): ?>
                            <div class="dropdown-item d-flex">
                                <span class="avatar mr-3 mt-1 align-self-top" style="background-image: url('<?php echo site_url('assets/img/alert.png'); ?>');"></span>
                                <div class="notification-content">
                                    <strong>No new notifications!</strong> Please check back later.
                                    <div class="small text-muted"></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php while ($notification = $notifications->fetch()): ?>
                            <div class="dropdown-item d-flex">
                                <?php if (!empty($notification->notification_image)): ?>
                                    <span class="avatar mr-3 mt-1 align-self-top" style="background-image: url('<?php echo site_url($notification->notification_image); ?>');"></span>
                                <?php else: ?>
                                    <span class="avatar mr-3 mt-1 align-self-top" style="background-image: url('<?php echo site_url('assets/img/alert.png'); ?>');"></span>
                                <?php endif; ?>
                                <div class="notification-content">
                                    <?php echo '<h5>' . $notification->notification_title . '</h5>' . $notification->notification_text . '<br />'; ?>
                                    <div class="small text-muted mt-2 mb-4">
                                        <?php echo $notification->notification_startdate; ?> &nbsp; | &nbsp;<a href="<?php echo site_url('users/notifications/'.$notification->nu_id); ?>">Dismiss</a> 
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        <?php endif; ?>

                        <div class="dropdown-divider"></div>
                        <div class="text-center text-muted">Notifications (<?php echo $total_notifications; ?>)</div>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="#" class="nav-link pr-0 leading-none ml-4" data-toggle="dropdown">
                        <?php if (!empty($user->user_avatar)): ?>
                            <img class="img-responsive rounded-circle user-image" id="user-image" src="<?php echo $user->user_avatar; ?>" alt="User picture">
                        <?php endif; ?>
                        <span class="ml-2 d-none d-lg-block">
                            <span class="header-link top-link"><?php echo $user->user_name; ?></span>
                            <small class="text-muted d-block mt-1"><?php echo ucfirst($user->user_role); ?></small>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a class="dropdown-item" href="<?php echo site_url(); ?>"><span class="icon mr-3"><i class="fa fa-dashboard"></i></span>Dashboard</a>
                        <a class="dropdown-item" href="<?php echo site_url('users/profile'); ?>"><span class="icon mr-3"><i class="fa fa-user"></i></span>My Profile</a>
                        <a class="dropdown-item" href="<?php echo site_url('settings'); ?>"><span class="icon mr-3"><i class="fa fa-gear"></i></span>Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('users/logout'); ?>"><span class="icon mr-3"><i class="fa fa-sign-out"></i></span>Logout</a>
                    </div>
                </div>
            </div>
            <?php if (!((segment(1) == 'posts') && (total_segments() >= 3))): ?>
                <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                    <span class="header-toggler-icon"></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if ((segment(1) == 'posts') && (total_segments() >= 3)): ?>
<div class="header subheader <?php echo $user->user_theme_subheader; ?> d-lg-flex p-0" id="headerMenuCollapse">
<?php else: ?>
<div class="header subheader <?php echo $user->user_theme_subheader; ?> collapse d-lg-flex p-0" id="headerMenuCollapse">
<?php endif; ?>
    <div class="container">
        <div class="row align-items-center">

            <?php if (segment(1) == 'posts' && total_segments() == 3 && isset($post)): ?>

                <div class="col-lg-3 ml-auto btn-options">
                    <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                        <li class="nav-item">
                            <a href="<?php echo site_url('posts'); ?>" class="btn btn-light btn-sm">All Posts</a>
                            <a href="<?php echo site_url(); ?>" class="btn btn-light btn-sm">Dashboard</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg order-lg-first btn-panel">
                    <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                        <li class="nav-item">
                            <div class="summernote-toolbar"></div>
                        </li>
                        <li class="nav-item mb-1">
                            <?php if (!empty($config->setting_url) && !empty($config->setting_root) && !empty($config->setting_media)): ?>
                                <button type="button" class="btn btn-light p-0 mt-2 px-2" title="Insert Image" data-toggle="modal" data-target="#editor-modal"><i class="fa fa-image"></i></button>
                            <?php else: ?>
                                <button type="button" class="btn btn-light p-0 mt-2 px-2" title="Insert Image" data-toggle="modal" data-target="#editor-modal" disabled><i class="fa fa-image"></i></button>
                            <?php endif; ?>
                            <button class="btn btn-light p-0 mt-2 px-2 spinner-fa" title="Save" id="btn-save" form="post-form" type="submit"><i class="fa fa-save"></i></button>
                            <button class="btn btn-light btn-sm btn-publish spinner" id="btn-publish" form="post-form" type="submit">Publish</button>
                        </li>
                    </ul>
                </div>

            <?php else: ?>

                <div class="col-lg-3 ml-auto subheader-content navbar-search">
                    <form class="input-icon my-3 my-lg-0" action="<?php echo site_url('posts/search'); ?>" method="post">
                        <?php if (!empty($config->setting_posts)): ?>
                            <input type="text" class="form-control header-search" name="query" placeholder="Search..." tabindex="1">
                        <?php else: ?>
                            <input type="text" class="form-control header-search" name="query" placeholder="Search..." tabindex="1" disabled>
                        <?php endif; ?>
                        <div class="input-icon-addon">
                            <i class="fa fa-search"></i>
                        </div>
                    </form>
                </div>
                <div class="col-lg order-lg-first">
                    <ul class="nav nav-tabs border-0 flex-column flex-lg-row subheader-content">

                        <li class="nav-item">
                            <?php if (url_string() == 'users/dashboard' || url_string() == ''): ?>
                                <a href="<?php echo site_url(); ?>" class="header-link active"><i class="fa fa-dashboard"></i> Dashboard</a>
                            <?php else: ?>
                                <a href="<?php echo site_url(); ?>" class="header-link"><i class="fa fa-dashboard"></i> Dashboard</a>
                            <?php endif; ?>
                        </li>

                        <?php

                            if (isset($config->setting_saved_queries) && $saved_query_menu->rowCount() > 0) {

                                if (segment(2) == 'saved_query' && is_numeric(segment(3))) {
                                    echo '<li class="nav-item dropdown">
                                        <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-external-link"></i>'.$config->setting_saved_queries.'</a>
                                        <div class="dropdown-menu dropdown-menu-arrow">';
                                }
                                else {
                                    echo '<li class="nav-item dropdown">
                                        <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-external-link"></i>'.$config->setting_saved_queries.'</a>
                                        <div class="dropdown-menu dropdown-menu-arrow">';
                                }

                                for ($i = 0; $i < $saved_query_menu->rowCount(); $i++) {
                                    $row = $saved_query_menu->fetch();

                                    echo '<a href="'.site_url("query/saved_query/".$row->id).'" class="dropdown-item "><span class="icon mr-3"><i class="'.$row->icon.'"></i></span>'.$row->name.'</a>';
                                }

                                echo '</div></li>';

                            }
                            else if (isset($config->setting_saved_queries)) {
                                echo '<li class="nav-item dropdown">';

                                if (url_string() == 'database/insert_saved_query') {
                                    echo '<a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-external-link"></i>'.$config->setting_saved_queries.'</a>';
                                }
                                else {
                                    echo '<a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-external-link"></i>'.$config->setting_saved_queries.'</a>';
                                }

                                echo '<div class="dropdown-menu dropdown-menu-arrow">
                                    <a href="'.site_url('query/insert_saved_query').'" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-chain"></i></span>Save a Query</a>
                                    </div></li>';
                            }

                        ?>

                        <?php if (!empty($config->setting_posts)): ?>
                        <li class="nav-item">
                            <?php if (url_string() == 'posts' || url_string() == 'category' || url_string() == 'comments'): ?>
                                <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-thumb-tack"></i> Posts</a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-thumb-tack"></i> Posts</a>
                            <?php endif; ?>
                            <div class="dropdown-menu dropdown-menu-arrow">
                                <a href="<?php echo site_url('posts'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-pencil-square-o"></i></span>All Posts</a>
                                <a href="<?php echo site_url('posts/insert'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-plus"></i></span>Add New</a>
                                <a href="<?php echo site_url('category'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-tags"></i></span>Categories</a>
                                <a href="<?php echo site_url('comments'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-comments"></i></span>Comments</a>
                            </div>
                        </li>
                        <?php endif; ?>

                        <?php if (!empty($config->setting_url) && !empty($config->setting_root) && !empty($config->setting_media)): ?>
                        <li class="nav-item dropdown">
                            <?php if (url_string() == 'media' || url_string() == 'media/upload'): ?>
                                <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-photo"></i> Media</a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-photo"></i> Media</a>
                            <?php endif; ?>
                            <div class="dropdown-menu dropdown-menu-arrow">
                                <a href="<?php echo site_url('media'); ?>" class="dropdown-item"><span class="icon mr-3"><i class="fa fa-book"></i></span>Library</a>
                                <a href="<?php echo site_url('media/upload'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-plus-circle"></i></span>Add New</a>
                            </div>
                        </li>
                        <?php endif; ?>

                        <li class="nav-item dropdown">
                            <?php if (url_string() == "settings/css_editor"): ?>
                                <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-paint-brush"></i> Appearance</a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-paint-brush"></i> Appearance</a>
                            <?php endif; ?>
                            <div class="dropdown-menu dropdown-menu-arrow">
                                <a href="<?php echo site_url('settings/css_editor'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-file-code-o"></i></span>CSS Editor</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <?php if (segment(1) == 'database' && segment(2) != 'insert_saved_query' && !is_numeric(segment(3))): ?>
                                <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-database"></i> Database</a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-database"></i> Database</a>
                            <?php endif; ?>
                            <div class="dropdown-menu dropdown-menu-arrow">
                                <?php if ($user->user_role == "administrator"): ?>
                                <a href="<?php echo site_url('database'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-sitemap"></i></span>All Tables</a>
                                <?php endif; ?>
                                <a href="<?php echo site_url('query'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-hdd-o"></i></span>Saved Queries</a>
                                <?php if ($user->user_role == "administrator"): ?>
                                <a href="<?php echo site_url('database/sql'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-terminal"></i></span>SQL Query</a>
                                <a href="<?php echo site_url('database/archive'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-archive"></i></span>Backup/Restore</a>
                                <?php endif; ?>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <?php if (url_string() == "users" || url_string() == "users/insert" || url_string() == "users/profile"): ?>
                                <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-user"></i> Users</a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-user"></i> Users</a>
                            <?php endif; ?>
                            <div class="dropdown-menu dropdown-menu-arrow">
                                <?php if ($user->user_role == "administrator"): ?>
                                    <a href="<?php echo site_url('users'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-users"></i></span>All Users</a>
                                    <a href="<?php echo site_url('users/insert'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-user-plus"></i></span>Add New</a>
                                <?php endif; ?>
                                <a href="<?= site_url('users/profile'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-user"></i></span>My Profile</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <?php if (url_string() == 'settings'): ?>
                                <a href="<?php echo site_url('settings'); ?>" class="header-link active"><i class="fa fa-gears"></i> Settings</a>
                            <?php else: ?>
                                <a href="<?php echo site_url('settings'); ?>" class="header-link"><i class="fa fa-gears"></i> Settings</a>
                            <?php endif; ?>
                        </li>

                    </ul>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>