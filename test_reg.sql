CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `user_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

INSERT INTO `users` (`id`, `login`, `password`, `name`, `avatar`, `user_hash`) VALUES
(16, 'test', 'fb469d7ef430b0baf0cab6c436e70375', 'Иван Васильевич', '', 'S00X8Z1MC7');
