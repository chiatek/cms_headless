DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS post_category;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS posts;

create table category (
	id int(11) unsigned not null auto_increment primary key,
	name varchar(100) not null,
	slug varchar(100) not null,
	parent varchar(100),
	description varchar(250),

	UNIQUE (name),
	UNIQUE (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table posts (
	id int(11) unsigned not null auto_increment primary key,
	title varchar(100) not null,
	slug varchar(100) not null,
	author varchar(100) not null,
	created datetime not null,
	modified datetime not null,
	status varchar(25),
	description varchar(500),
	body text,
	image varchar(100),
	featured tinyint(1),
	meta_caption varchar(100),
	meta_description varchar(250),
	meta_keywords varchar(100),
	user_id int(11) unsigned not null

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table post_category (
	pc_id int(11) unsigned not null auto_increment primary key,
	post_id int(11) unsigned not null,
	category_id int(11) unsigned not null,

	foreign key (post_id) references posts(id),
	foreign key (category_id) references category(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table comments (
	id int(11) unsigned not null auto_increment primary key,
	post_id int(11) unsigned not null,
	date datetime not null,
	name varchar(100) not null,
	email varchar(100),
	website varchar(100),
    status enum('pending','approved','spam') not null,
	comment text not null,

	foreign key (post_id) references posts(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;