-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;

CREATE TABLE `carts` (
  `member_id` int NOT NULL,
  `product_no` int NOT NULL,
  `product_des` varchar(255) DEFAULT NULL,
  `product_quantity` decimal(10,0) DEFAULT NULL,
  `place_order` tinyint(1) DEFAULT '1'
) ;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,1000,NULL,1,1),(3,1001,NULL,2,1),(5,1003,NULL,1,1),(5,1001,NULL,1,1),(5,1002,NULL,1,1),(5,1000,NULL,1,1),(5,1004,NULL,1,0);
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_type`
--

DROP TABLE IF EXISTS `member_type`;

CREATE TABLE `member_type` (
  `type` char(1) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`type`)
);

--
-- Dumping data for table `member_type`
--

LOCK TABLES `member_type` WRITE;
/*!40000 ALTER TABLE `member_type` DISABLE KEYS */;
INSERT INTO `member_type` VALUES ('A','Admin'),('B','Buyer'),('S','Saler/Buyer');
/*!40000 ALTER TABLE `member_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `street_no` varchar(255) DEFAULT '',
  `suite` varchar(255) DEFAULT '',
  `city` varchar(255) DEFAULT '',
  `state` varchar(255) DEFAULT '',
  `zipcode` varchar(255) DEFAULT '',
  `id_number` varchar(255) DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `member_type` char(1) DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `tax` (`tax`)
) ;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'Beatrix','Christina','2000-12-01','949-213-2222','83 Joelle Cr.','','Fullerton','CA','90631','','sell01@gmail.com','S',NULL),(2,'Coy','Chlodulf','2001-01-01','949-213-3333','16 Reynard Ave.','','Anaheim','CA','92803','','buy02@gmail.com','B',NULL),(3,'Xiadani','Gosia','2002-01-01','949-213-4444','21 Valorie Rd.','','Stanton','CA','92841','','buy01@gmail.com','B',NULL),(4,'Odharnait','Glynis','2002-01-01','714-111-1111','35 Dudley St.','','Stanton','CA','92841','','sell02@gmail.com','S',NULL),(5,'Vo','Uy','2000-01-05','714-111-1111','1038 Main St.','','Stanton','CA','92841','','admin@gmail.com','A',NULL);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_no` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL,
  `tax` decimal(10,0) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `card_no` varchar(16) DEFAULT NULL,
  `card_holder_name` varchar(255) DEFAULT NULL,
  `card_exp_month` int DEFAULT NULL,
  `card_exp_year` int DEFAULT NULL,
  `order_ship_name` varchar(255) DEFAULT NULL,
  `order_ship_street` varchar(50) DEFAULT NULL,
  `order_ship_city` varchar(50) DEFAULT NULL,
  `order_ship_state` varchar(2) DEFAULT NULL,
  `order_ship_zipcode` varchar(5) DEFAULT NULL,
  `ship_fee` decimal(10,0) DEFAULT NULL,
  `tracking_no` decimal(10,0) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`order_no`)
) ;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,5,'2024-04-30 09:14:26',10,10,10,'card here','',5,2024,'Uy Vo','1038 Main St.','Stanton','CA','92841',NULL,NULL,'In process'),(2,5,'2024-04-30 21:23:22',10,10,10,'card here','',5,2024,'Uy Vo','1038 Main St.','Stanton','CA','92841',NULL,NULL,'In process'),(3,5,'2024-04-30 21:23:38',10,10,10,'card here','',5,2024,'Uy Vo','1038 Main St.','Stanton','CA','92841',NULL,NULL,'In process'),(4,5,'2024-04-30 21:29:18',10,10,10,'2222111133334012','THUY DANG',4,2024,'Uy Vo','1038 Main St.','Stanton','CA','92841',NULL,NULL,'In process');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_detail`
--

DROP TABLE IF EXISTS `orders_detail`;
CREATE TABLE `orders_detail` (
  `order_no` int NOT NULL,
  `product_no` int NOT NULL,
  `product_des` varchar(255) DEFAULT NULL,
  `product_quantity` decimal(10,0) DEFAULT NULL,
  `product_price` decimal(10,0) DEFAULT NULL,
  `ship_date` datetime DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `return_fee` decimal(10,0) DEFAULT NULL,
  `product_status` varchar(10) DEFAULT NULL,
  `status_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`order_no`,`product_no`)
);

--
-- Dumping data for table `orders_detail`
--

LOCK TABLES `orders_detail` WRITE;
/*!40000 ALTER TABLE `orders_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `member_id` int NOT NULL,
  `card_holder_name` varchar(255) DEFAULT NULL,
  `card_no` varchar(20) NOT NULL,
  `card_exp_month` int DEFAULT NULL,
  `card_exp_year` int DEFAULT NULL,
  `card_cvv` varchar(20) DEFAULT NULL,
  `card_default` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`card_no`)
);

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (5,'VO THANH UY','1111222233334321',4,2031,'111',1),(5,'THUY DANG','2222111133334012',4,2024,'111',0);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `product_no` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `product_des` varchar(255) DEFAULT NULL,
  `product_artist` varchar(255) DEFAULT NULL,
  `product_size_height` decimal(10,0) DEFAULT NULL,
  `product_size_width` decimal(10,0) DEFAULT NULL,
  `product_material` varchar(255) DEFAULT NULL,
  `product_quantity` int DEFAULT NULL,
  `product_status` varchar(10) DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `product_price` double DEFAULT '0',
  `product_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `product_delivery` int DEFAULT '0',
  `ship_code` varchar(10) DEFAULT NULL,
  `return_code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`product_no`)
);

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1000,'Hang Gai Street',NULL,'GIAP VAN TUAN',120,200,'Oil on canvas',NULL,'Active',1,'Hang-Gai-Street-Vietnamese-Oil-Painting-by-Artist-Giap-Van-Tuan.jpeg',1250,'Hang Gai Street in Ha Noi',14,'SHIP0','RETURN60'),(1001,'Street in Autumn',NULL,'GIAP VAN TUAN',80,120,'Oil on canvas',NULL,'Active',1,'Street-in-Autumn-Vietnamese-Oil-Painting-by-Artist-Giap-Van-Tuan.jpeg',1200,'',14,'SHIP0','RETURN30'),(1002,'Autumn Sunlight on Street',NULL,'GIAP VAN TUAN',90,100,'Oil on Canvas',NULL,'Active',1,'Autumn-Sunlight-on-Street-Vietnamese-Oil-Painting-by-Artist-Lam-Duc-Manh.jpeg',1350,'',14,'SHIP25','RETURN60'),(1003,'Autumn’s Lotus',NULL,'DO KHAI',100,120,'Lacquer on wood',NULL,'Active',1,'Autumns-Lotus-Vietnamese-Lacquer-Painting-by-Artist-Do-Khai.jpeg',5000,'',21,'SHIP0','RETURN60'),(1004,'Day of Summer VIII',NULL,'CHAU AI VAN',80,120,'Lacquer on wood',NULL,'Active',1,'Day-of-Summer-VIII-Vietnamese-Lacquer-Painting-by-Artist-Chau-Ai-Van.jpeg',2500,'',21,'SHIP0','RETURN30'),(1005,'Kid, Kitty &amp; Wool Roll',NULL,'CHAU AI VAN',40,60,'Lacquer on wood',NULL,'Active',1,'Kid-Kitty-Wool-Roll-Vietnamese-Lacquer-Painting-by-Artist-Chau-Ai-Van.jpeg',2200,'',21,'SHIP0','RETURN30'),(1006,'Golden Season II',NULL,'DANG DINH NGO',42,55,'Oil on Canvas',NULL,'Active',1,'Golden-Season-II-Vietnamese-Oil-Painting-by-Artist-Dang-Dinh-Ngo-1.jpeg',1000,'',21,'SHIP0','RETURN60'),(1007,'Lady Lotus III',NULL,'NGO BA CONG',200,120,'Lacquer on wood',NULL,'Active',1,'Lady-Lotus-III-Vietnamese-Lacquer-Paintings-by-Artist-Ngo-Ba-Cong.jpeg',2000,'testing',21,'SHIP0','RETURN30'),(1008,'Late Sunlight',NULL,'LE KHANH HIEU',75,120,'Lacquer on wood',NULL,'Active',1,'Late-Sunlight-Vietnamese-Lacquer-Painting-by-Artist-Le-Khanh-Hieu.jpeg',1500,'testing Late Sunlight',21,'SHIP0','RETURN30'),(1009,'Pond of Noble Lotuses II',NULL,'NGUYEN XUAN VIET',80,120,'Lacquer on wood',NULL,'Active',5,'Pond-of-Noble-Lotuses-II-Vietnamese-Lacquer-Painting-By-artist-Nguyen-Xuan-Viet.jpeg',1000,'Lotuses is a flower of symbol in Vietnam',21,'SHIP50','RETURN60'),(1010,'Pond of Noble Lotuses',NULL,'NGUYEN XUAN VIET',125,122,'Lacquer on wood',NULL,'Active',5,'Pond-of-Noble-Lotuses-Vietnamese-lacquer-painting-by-artist-Nguyen-Xuan-Viet-1.jpg',1200,'Lotuses is a flower of symbol in Vietnam',21,'SHIP50','RETURN60');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_policy`
--

DROP TABLE IF EXISTS `sale_policy`;
CREATE TABLE `sale_policy` (
  `policy_no` int NOT NULL AUTO_INCREMENT,
  `policy_type` varchar(10) DEFAULT NULL,
  `policy_code` varchar(10) DEFAULT NULL,
  `policy_value` int DEFAULT NULL,
  `policy_description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`policy_no`)
);

--
-- Dumping data for table `sale_policy`
--

LOCK TABLES `sale_policy` WRITE;
/*!40000 ALTER TABLE `sale_policy` DISABLE KEYS */;
INSERT INTO `sale_policy` VALUES (1,'shipping','SHIP0',0,'Free shipping'),(2,'shipping','SHIP25',25,'FREE delivery on qualifying orders over $25'),(3,'return','RETURN30',30,'Free return in 30 days'),(4,'return','RETURN60',60,'Free return in 60 days'),(5,'shipping','SHIP50',50,'FREE delivery on qualifying orders over $50'),(6,'shipping','SHIP100',200,'FREE delivery on qualifying orders over $100'),(7,'return','RETURN90',90,'Free return in 90 days');
/*!40000 ALTER TABLE `sale_policy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL,
  `status` char(1) DEFAULT 'A',
  PRIMARY KEY (`email`),
  UNIQUE KEY `email` (`email`)
);

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('admin@gmail.com','5ba7e50b29036a55cbf15e2281480c21','A','A'),('buy01@gmail.com','5ba7e50b29036a55cbf15e2281480c21','B','A'),('buy02@gmail.com','5ba7e50b29036a55cbf15e2281480c21','B','A'),('sell01@gmail.com','5ba7e50b29036a55cbf15e2281480c21','S','A'),('sell02@gmail.com','5ba7e50b29036a55cbf15e2281480c21','S','A');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
