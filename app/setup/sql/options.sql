/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET SQL_NOTES=0 */;
DROP TABLE IF EXISTS options;
CREATE TABLE `options` (
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
INSERT INTO options(name,value) VALUES('get_qid','BTL Craft'),('enable_reg','0'),('enable_sign_in','0'),('nontbot_host','http://127.0.0.1:5001'),('site_url','http://127.0.0.1'),('enable_sign_in','0');