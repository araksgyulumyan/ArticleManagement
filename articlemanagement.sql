CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `user_infos` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `user_id` int(11) NOT NULL,
 PRIMARY KEY (`id`),
 FOREIGN KEY (user_id) REFERENCES users(id),
 UNIQUE (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `articles` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `user_id` int(11) NOT NULL,
 `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`),
 FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;