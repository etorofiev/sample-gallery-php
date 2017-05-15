CREATE DATABASE IF NOT EXISTS sample_gallery_php DEFAULT CHARSET='utf8' DEFAULT COLLATE='utf8_general_ci';
USE sample_gallery_php;
--GRANT ALL ON sample_gallery_php TO 'sample'@'localhost' IDENTIFIED BY 'secret'; -- For MySQL < 5.7.6
CREATE USER IF NOT EXISTS 'sample'@'localhost' IDENTIFIED BY 'secret';
GRANT ALL ON sample_gallery_php.* TO 'sample'@'localhost';

CREATE TABLE IF NOT EXISTS images (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  path VARCHAR(2000) NOT NULL,
  thumbnail VARCHAR(2000) DEFAULT NULL,
  description VARCHAR(2000),
  mime VARCHAR(30),
  created_at DATETIME NOT NULL,
  updated_at DATETIME DEFAULT NULL,
  INDEX image_name_index (name),
  FULLTEXT INDEX image_description_index (description)
) ENGINE=InnoDB;

INSERT INTO images (name, path, thumbnail, description, mime, created_at, updated_at)
VALUES
  ('Sample 1', '/images/sample1.jpg', '/images/thumbs/sample1_thumb.jpg', 'A sample image', 'image/jpeg', '2017-01-01 12:00:00', NULL),
  ('Sample balls', '/images/sample_balls.jpg', '/images/thumbs/sample_balls_thumb.jpg', 'A sample image of some balls', 'image/jpeg', '2017-01-01 12:00:01', NULL),
  ('Sample coffee', '/images/sample_coffee.jpg', '/images/thumbs/sample_coffee_thumb.jpg', 'A sample image of a cup of coffee', 'image/jpeg', '2017-01-01 12:00:02', NULL),
  ('Sample nature', '/images/sample_nature.jpg', '/images/thumbs/sample_nature_thumb.jpg', 'A sample image of some animals in the wild', 'image/jpeg', '2017-01-01 12:00:03', NULL),
  ('Sample pipes', '/images/sample_pipes.jpg', '/images/thumbs/sample_pipes_thumb.jpg', 'A sample image of a few pipes', 'image/jpeg', '2017-01-01 12:00:04', NULL)
;