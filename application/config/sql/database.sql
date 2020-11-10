DROP TABLE IF EXISTS queries;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS notification_user;
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS users;

create table users (
	user_id int(11) unsigned not null auto_increment primary key,
	user_username varchar(20) not null,
	user_password varchar(128) not null,
	user_name varchar(50) not null,
	user_email varchar(100) not null,
	user_role enum('administrator','author','user') not null,
	user_status enum('active','banned','deleted') not null,
	user_activity datetime,
	user_company varchar(100),
	user_birthday date,
	user_country varchar(50),
	user_bio text,
	user_phone varchar(15),
	user_facebook varchar(200),
	user_instagram varchar(200),
	user_linkedin varchar(200),
	user_twitter varchar(200),
	user_youtube varchar(200),
	user_avatar varchar(200),
	user_theme varchar(25) not null,
	user_theme_header varchar(25) not null,
	user_theme_subheader varchar(25) not null,
	user_theme_footer varchar(25) not null,

	UNIQUE (user_username),
	UNIQUE (user_email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table settings (
	setting_id int(11) unsigned not null auto_increment primary key,
    setting_url varchar(100),
	setting_title varchar(100),
	setting_tagline varchar(100),
	setting_siteicon varchar(100),
	setting_database varchar(100),
    setting_api varchar(100),
    setting_root varchar(100),
    setting_css varchar(100),
    setting_media varchar(100),
	setting_saved_queries varchar(100),
	setting_datetime varchar(100) not null,
	setting_posts tinyint(1),
	setting_dashboard_posts_widget tinyint(1),
    setting_dashboard_GA_widget tinyint(1),
	setting_dashboard_posts tinyint(1),
	setting_dashboard_comments tinyint(1),
	setting_dashboard_GA_chart tinyint(1),
    setting_dashboard_GA_stats tinyint(1),
	setting_GA_trackingid varchar(200),
    setting_GA_key_location varchar(100),
	setting_GA_code text,
	user_id int(11) unsigned not null,

	foreign key (user_id) references users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table notifications (
	notification_id int(11) unsigned not null auto_increment primary key,
	notification_title varchar(50),
	notification_text varchar(500),
	notification_image varchar(100),
	notification_startdate date,
	notification_enddate date

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table notification_user (
	nu_id int(11) unsigned not null auto_increment primary key,
	notification_id int(11) unsigned not null,
	user_id int(11) unsigned not null,
	nu_dismiss tinyint(1) not null,

	foreign key (notification_id) references notifications(notification_id),
	foreign key (user_id) references users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table queries (
	id int(11) unsigned not null auto_increment primary key,
	name varchar(100) not null,
	table_name varchar(100) not null,
	referenced_table_name varchar(100),
	primary_key varchar(100),
	foreign_key varchar(100),
	select_stmt varchar(200),
	where_stmt varchar(200),
	orderby_stmt varchar(100),
	limit_stmt int(11),
	icon varchar(100),
	add_to_menu tinyint(1),
	add_to_dashboard tinyint(1),
	user_id int(11) unsigned not null,

	foreign key (user_id) references users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (user_id, user_username, user_password, user_name, user_email, user_role, user_status, user_activity, user_theme, user_theme_header, user_theme_subheader, user_theme_footer) VALUES
(1000, 'user', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', 'Admin User', 'user@user.com', 'administrator', 'active', '0001-01-01 00:00:00', 'default.css', 'bg-dark header-dark', 'bg-light header-light', 'bg-light header-light');

INSERT INTO settings (setting_id, setting_saved_queries, setting_datetime, setting_posts, setting_dashboard_posts_widget, setting_dashboard_GA_widget, setting_dashboard_posts, setting_dashboard_comments, setting_dashboard_GA_chart, setting_dashboard_GA_stats, user_id) VALUES
(1, 'Favorites', 'F Y h:i:s A', 0, 0, 0, 0, 0, 0, 0, 1000);