DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `name` VARCHAR(45) NOT NULL,
  `phone` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL
);

INSERT INTO `users` VALUES ('Tyler', '(333) 333-3333', 'tyler@gmail.com');

INSERT INTO `users` VALUES ('Kevin', '(123) 456-7890', 'kevin@gmail.com');

INSERT INTO `users` VALUES ('Kim', '(000) 000-0000', 'jongun@gmail.com');

INSERT INTO `users` VALUES ('Justin', '(888) 888-8888', 'trudeau@gmail.com');
