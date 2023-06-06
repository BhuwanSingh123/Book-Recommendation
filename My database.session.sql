DROP DATABASE IF EXISTS shop_db;
CREATE DATABASE shop_db;
USE shop_db;
CREATE TABLE `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
);
INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`)
VALUES (
    3,
    'Bhuwan',
    'bhuwansingh279@gmail.com',
    '4bda6a1acf63d79fffc155df4656c76a',
    'user'
  ),
  (
    4,
    'bhuwan',
    'bhuwansingh913@gmail.com',
    '3792c1792d74142aed6899ee1cfc414c',
    'admin'
  ),
  (
    5,
    'bhuwan',
    'bhuwansingh913@gmail.com',
    '4bda6a1acf63d79fffc155df4656c76a',
    'admin'
  ),
  (
    6,
    'ram',
    'ram@gmail.com',
    '4641999a7679fcaef2df0e26d11e3c72',
    'admin'
  ),
  (
    7,
    'Chandan Shakya',
    'notch0andan@gmail.com',
    'b18f2dfcfc1c94c17e43419b7e8f788b',
    'user'
  ),
  (
    8,
    'Kabir Deula',
    'kabir@gmail.com',
    'c1621fbecc04b7b7911b982fe585c8d8',
    'user'
  );
CREATE TABLE `products` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `products` (`id`, `name`, `price`, `image`)
VALUES (1, 'The Book Of Names', 400, 'book1.jpg'),
  (2, 'Harry Potter', 500, 'book2.jpg'),
  (3, 'The Unspoken Name', 500, 'images.jpg'),
  (4, 'THE LIARS DICTNORY', 1000, 'd.jpg'),
  (5, 'A Boy Called BAT', 550, 'imag.jpg'),
  (6, 'The Silver Serpent', 500, 'g.jpg'),
  (7, 'The Hunger Games', 700, '2767052.jpg');

CREATE TABLE `cart` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`item_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);
CREATE TABLE `message` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);
CREATE TABLE `orders` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);
INSERT INTO `orders` (
    `id`,
    `user_id`,
    `name`,
    `number`,
    `email`,
    `method`,
    `address`,
    `total_products`,
    `total_price`,
    `placed_on`,
    `payment_status`
  )
VALUES (
    10,
    3,
    'rijan',
    '982324445',
    'bhuwansingh199@gmail.com',
    'cash on delivery',
    'flat no. , kool, ,  - ',
    ', Harry Potter (1) ',
    500,
    '12-May-2023',
    'completed'
  ),
  (
    11,
    3,
    'fdsfsd',
    '98232323',
    'sdsd@gmail.com',
    'cash on delivery',
    'flat no. , dsd, ,  - ',
    ', Harry Potter (1) ',
    500,
    '12-May-2023',
    'completed'
  ),
  (
    12,
    3,
    'kool',
    '982322223',
    'bhuwans@gmail.com',
    'cash on delivery',
    'khsud',
    ', Harry Potter (1) ',
    500,
    '12-May-2023',
    'completed'
  ),
  (
    13,
    3,
    'chandan',
    '999',
    'chandan@gmail.com',
    'paytm',
    'Dallu',
    ', The Book Of Names (1) ',
    400,
    '06-Jun-2023',
    'completed'
  ),
  (
    14,
    3,
    'chandan',
    '9843177805',
    'chandan123@gmail.com',
    'khalti',
    'dallu',
    ', The Book Of Names (1) ',
    400,
    '06-Jun-2023',
    'completed'
  ),
  (
    15,
    6,
    'Chandan Shakya',
    '9843177805',
    'notch0andan@gmail.com',
    'cash on delivery',
    'Dallu, Kathmandu',
    ', The Book Of Names (1) ',
    400,
    '06-Jun-2023',
    'completed'
  ),
  (
    16,
    7,
    'Chandan Shakya',
    '9843177805',
    'notch0andan@gmail.com',
    'cash on delivery',
    'Dallu, Kathmandu',
    ', The Book Of Names (1) , Harry Potter (1) , The Unspoken Name (1) ',
    1400,
    '06-Jun-2023',
    'completed'
  ),
  (
    17,
    8,
    'Kabir Deula',
    '9843177805',
    'kabir@gmail.com',
    'cash on delivery',
    'Dhalko',
    ', The Book Of Names (1) , Harry Potter (1) , The Unspoken Name (1) , THE LIAR''S DICTNORY (1) , A Boy Called BAT (1) , The Silver Serpent (1) ',
    3450,
    '06-Jun-2023',
    'completed'
  ),
  (
    18,
    8,
    'Kabir Deula',
    '9843177805',
    'kabir@gmail.com',
    'cash on delivery',
    'Dhalko',
    ', Harry Potter (1) ',
    500,
    '06-Jun-2023',
    'completed'
  );
CREATE TABLE `user_rating` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `item_id` int(100) NOT NULL,
  `rating` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`item_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
);
INSERT INTO `user_rating` (`id`, `user_id`, `item_id`, `rating`)
VALUES (1, 7, 1, 4),
  (2, 7, 2, 3),
  (3, 7, 3, 2),
  (4, 8, 1, 3),
  (5, 8, 2, 4),
  (6, 8, 3, 3),
  (7, 8, 4, 3),
  (8, 8, 5, 3),
  (9, 8, 6, 3);
create table item_ids(
  `order_id` int NOT NULL,
  `item_ids` int NOT NULL,
  FOREIGN Key (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (item_ids) REFERENCES products(id) ON DELETE CASCADE
);
INSERT INTO `item_ids` (`order_id`, `item_ids`)
VALUES (15, 1),
  (16, 1),
  (16, 2),
  (16, 3),
  (17, 1),
  (17, 2),
  (17, 3),
  (17, 4),
  (17, 5),
  (17, 6),
  (18, 2);
-- SET @sql = NULL;
-- SELECT
--   GROUP_CONCAT(DISTINCT
--     CONCAT(
--       'COALESCE(MAX(IFNULL(CASE WHEN u.id = ', id, ' THEN r.rating END, 0)), 0) AS `', name, '`'
--     )
--   ) INTO @sql
-- FROM users
-- WHERE user_type = 'user';
-- SET @sql = CONCAT('SELECT p.name AS Book, ', @sql, '
--                    FROM products p
--                    LEFT JOIN user_rating r ON p.id = r.item_id
--                    LEFT JOIN users u ON r.user_id = u.id
--                    WHERE u.user_type = "user"
--                    GROUP BY p.id');
-- PREPARE stmt FROM @sql;
-- EXECUTE stmt;
-- DEALLOCATE PREPARE stmt;



-- SET @sql = NULL;
-- SELECT GROUP_CONCAT(
--     DISTINCT CONCAT(
--       'COALESCE(MAX(IFNULL(CASE WHEN u.id = ',
--       id,
--       ' THEN r.rating END, 0)), 0) AS `',
--       name,
--       '`'
--     )
--   ) INTO @sql
-- FROM users
-- WHERE user_type = 'user';
-- SET @sql = CONCAT(
--     'CREATE VIEW product_ratings_view AS
-- SELECT p.name AS Book, ',
--     @sql,
--     '
-- FROM products p
-- LEFT JOIN user_rating r ON p.id = r.item_id
-- LEFT JOIN users u ON r.user_id = u.id
-- WHERE u.user_type = "user"
-- GROUP BY p.id'
--   );
-- PREPARE stmt
-- FROM @sql;
-- EXECUTE stmt;
-- DEALLOCATE PREPARE stmt;


SET @sql = NULL;
SELECT GROUP_CONCAT(
    DISTINCT CONCAT(
      'COALESCE(MAX(IFNULL(CASE WHEN u.id = ',
      id,
      ' THEN r.rating END, 0)), 0) AS `',
      name,
      '`'
    )
  ) INTO @sql
FROM users
WHERE user_type = 'user';
SET @sql = CONCAT(
    'CREATE OR REPLACE VIEW product_ratings_view_no_book_name AS
SELECT ',
    @sql,
    '
FROM products p
LEFT JOIN user_rating r ON p.id = r.item_id
LEFT JOIN users u ON r.user_id = u.id
WHERE u.user_type = \"user\"
GROUP BY p.id'
  );
PREPARE stmt
FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;