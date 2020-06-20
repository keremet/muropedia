CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `login` text COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `visible_name` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE singer (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `singer__member_id` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE author (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `author__member_id` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE song (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `singer_id`int(11),
  `author_id`int(11),
  `txt` text COLLATE utf8_unicode_ci NOT NULL,
  `translation_txt` text COLLATE utf8_unicode_ci,
  `member_id` int(11) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `song__singer_id` FOREIGN KEY (`singer_id`) REFERENCES `singer` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `song__author_id` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `song__member_id` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE song_hst(
  `song_id` int(11) ,
  `name` text COLLATE utf8_unicode_ci,
  `singer_id`int(11),
  `author_id`int(11),
  `txt` text COLLATE utf8_unicode_ci,
  `translation_txt` text,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  member_id int(11) ,
  CONSTRAINT `song_hst__song_id` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `song_hst__member_id` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
