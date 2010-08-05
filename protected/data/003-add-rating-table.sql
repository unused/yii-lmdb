CREATE TABLE `movie_rating` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` smallint NOT NULL,
  `user_id` int(10) NOT NULL,
  `movie_id` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
