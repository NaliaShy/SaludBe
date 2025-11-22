-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: saludbe
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `carrusel`
--

DROP TABLE IF EXISTS `carrusel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrusel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `imagen_nombre` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrusel`
--

LOCK TABLES `carrusel` WRITE;
/*!40000 ALTER TABLE `carrusel` DISABLE KEYS */;
INSERT INTO `carrusel` VALUES (1,'691f0b193df54_coaes9.png','activo','2025-11-20 07:35:37'),(2,'691f0c31bb3dd_download.jpg','activo','2025-11-20 07:40:17'),(4,'691f1259eb3bb_download.jpg','activo','2025-11-20 08:06:33'),(5,'691f129320ece_1186130.jpg','activo','2025-11-20 08:07:31'),(6,'691f3e19c355c_download.jpg','activo','2025-11-20 11:13:13');
/*!40000 ALTER TABLE `carrusel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chatbot`
--

DROP TABLE IF EXISTS `chatbot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chatbot` (
  `Cha_id` int NOT NULL,
  `Cha_mensaje_usuarios` text NOT NULL,
  `Cha_respuesta_rapida` text NOT NULL,
  `Cha_fecha` datetime NOT NULL,
  `lin_id` int NOT NULL,
  PRIMARY KEY (`Cha_id`),
  KEY `FK_CHATBOT_LINK` (`lin_id`),
  CONSTRAINT `FK_CHATBOT_LINK` FOREIGN KEY (`lin_id`) REFERENCES `linkemergencia` (`lin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatbot`
--

LOCK TABLES `chatbot` WRITE;
/*!40000 ALTER TABLE `chatbot` DISABLE KEYS */;
/*!40000 ALTER TABLE `chatbot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cita`
--

DROP TABLE IF EXISTS `cita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cita` (
  `IdCita` int NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Estado` varchar(50) DEFAULT NULL,
  `Motivo` varchar(300) DEFAULT NULL,
  `Id_Usuario` int NOT NULL,
  `Id_psicologo` int DEFAULT NULL,
  PRIMARY KEY (`IdCita`),
  KEY `Id_Usuario` (`Id_Usuario`),
  KEY `Id_psicologo_idx` (`Id_psicologo`),
  CONSTRAINT `Id_psicologo` FOREIGN KEY (`Id_psicologo`) REFERENCES `usuarios` (`Us_id`),
  CONSTRAINT `Id_Usuario` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Us_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita`
--

LOCK TABLES `cita` WRITE;
/*!40000 ALTER TABLE `cita` DISABLE KEYS */;
INSERT INTO `cita` VALUES (1,'2025-11-01','12:00:00','activa','sospechas',2,1),(2,'2025-12-15','18:00:00','activa','suicidio',7,1),(3,'2025-12-15','10:30:00','Pendiente','Consulta médica prueba',7,1),(4,'2025-12-15','10:30:00','Pendiente','Consulta médica prueba',7,1),(5,'2025-12-16','14:00:00','Confirmada','Revisión general',7,1),(6,'2025-12-18','09:00:00','Pendiente','Vacunación',7,1),(9,'2025-11-15','14:10:32','Pendiente','Motivo: idk',9,9),(10,'2025-11-22','14:12:12','Pendiente','Motivo: Depresion',10,9),(11,'2025-11-15','14:19:37','Pendiente','Motivo: p',10,9),(12,'2025-11-03','14:19:58','Pendiente','Motivo: q',10,9),(13,'2025-11-15','14:37:51','Pendiente','Motivo: prueba',10,9),(14,'2025-11-20','14:38:45','Pendiente','Motivo: hola',10,9),(15,'2025-11-21','08:28:07','Pendiente','Motivo: Hola ',2,9),(16,'2025-11-21','08:30:31','Pendiente','Motivo: hola',2,9),(17,'2025-11-28','11:06:30','Pendiente','Motivo: Hola',2,9);
/*!40000 ALTER TABLE `cita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuracion` (
  `Con_id` int NOT NULL,
  `Con_tema` varchar(100) NOT NULL,
  `Con_notificaciones_activas` tinyint(1) NOT NULL,
  `Us_id` int NOT NULL,
  PRIMARY KEY (`Con_id`),
  KEY `FK_CONFIGURACION_USUARIO` (`Us_id`),
  CONSTRAINT `FK_CONFIGURACION_USUARIO` FOREIGN KEY (`Us_id`) REFERENCES `usuarios` (`Us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `frase_motivacional`
--

DROP TABLE IF EXISTS `frase_motivacional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `frase_motivacional` (
  `Fs_id` int NOT NULL,
  `Fs_contenido` text NOT NULL,
  `Fs_fecha_creacion` date DEFAULT NULL,
  `Us_id` int DEFAULT NULL,
  PRIMARY KEY (`Fs_id`),
  KEY `FOREING KEYS` (`Us_id`),
  CONSTRAINT `FOREING KEYS` FOREIGN KEY (`Us_id`) REFERENCES `usuarios` (`Us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frase_motivacional`
--

LOCK TABLES `frase_motivacional` WRITE;
/*!40000 ALTER TABLE `frase_motivacional` DISABLE KEYS */;
/*!40000 ALTER TABLE `frase_motivacional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linkemergencia`
--

DROP TABLE IF EXISTS `linkemergencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `linkemergencia` (
  `lin_id` int NOT NULL AUTO_INCREMENT,
  `PalabraClave` varchar(100) NOT NULL,
  `UrlAyuda` varchar(255) NOT NULL,
  PRIMARY KEY (`lin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linkemergencia`
--

LOCK TABLES `linkemergencia` WRITE;
/*!40000 ALTER TABLE `linkemergencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `linkemergencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensaje`
--

DROP TABLE IF EXISTS `mensaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mensaje` (
  `Men_id` int NOT NULL AUTO_INCREMENT,
  `Men_contenido` text NOT NULL,
  `Men_fecha_envio` datetime NOT NULL,
  `Us_id` int NOT NULL,
  `destinatario_id` int DEFAULT NULL,
  PRIMARY KEY (`Men_id`),
  KEY `FK_MENSAJE_USUARIOS` (`Us_id`),
  CONSTRAINT `FK_MENSAJE_USUARIOS` FOREIGN KEY (`Us_id`) REFERENCES `usuarios` (`Us_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensaje`
--

LOCK TABLES `mensaje` WRITE;
/*!40000 ALTER TABLE `mensaje` DISABLE KEYS */;
INSERT INTO `mensaje` VALUES (7,'Hola','2025-11-06 19:32:55',2,NULL),(8,'porfin','2025-11-06 19:34:12',2,NULL),(9,'hola','2025-11-06 19:41:32',2,NULL),(10,'hola','2025-11-06 19:44:36',2,NULL),(11,'hola','2025-11-06 20:11:45',8,NULL),(12,'hola','2025-11-06 20:17:05',8,NULL),(13,'hola','2025-11-06 20:34:57',8,5),(14,'hola','2025-11-06 20:35:26',8,2),(15,'hola','2025-11-06 20:35:58',2,8),(16,'hola','2025-11-06 20:41:57',2,3),(17,'Muchas gracias','2025-11-06 21:03:38',2,8),(18,'gracias','2025-11-06 21:07:21',2,8),(19,'.','2025-11-06 21:07:27',2,8),(20,'Hola','2025-11-13 14:11:44',10,9),(21,'Hola','2025-11-13 14:44:02',10,9),(22,'Hola','2025-11-19 07:52:23',2,9),(23,'hola','2025-11-20 08:30:46',2,1);
/*!40000 ALTER TABLE `mensaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificacion`
--

DROP TABLE IF EXISTS `notificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificacion` (
  `No_id` int NOT NULL AUTO_INCREMENT,
  `No_mensaje` varchar(300) DEFAULT NULL,
  `No_fecha_envio` date DEFAULT NULL,
  `No_leido` tinyint(1) DEFAULT '0',
  `Us_id` int DEFAULT NULL,
  PRIMARY KEY (`No_id`),
  KEY `fk_notificacion_usuario` (`Us_id`),
  CONSTRAINT `fk_notificacion_usuario` FOREIGN KEY (`Us_id`) REFERENCES `usuarios` (`Us_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificacion`
--

LOCK TABLES `notificacion` WRITE;
/*!40000 ALTER TABLE `notificacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `notificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporte`
--

DROP TABLE IF EXISTS `reporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reporte` (
  `id_reporte` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','en proceso','resuelto') DEFAULT 'pendiente',
  PRIMARY KEY (`id_reporte`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `reporte_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`Us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte`
--

LOCK TABLES `reporte` WRITE;
/*!40000 ALTER TABLE `reporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resultado_test`
--

DROP TABLE IF EXISTS `resultado_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resultado_test` (
  `Re_id` int NOT NULL,
  `Re_resultado` varchar(100) NOT NULL,
  `Re_fecha` date NOT NULL,
  `Tes_id` int NOT NULL,
  `Us_id` int NOT NULL,
  PRIMARY KEY (`Re_id`),
  KEY `FK_Resultados_usuarios` (`Us_id`),
  KEY `FK_Resultados_test` (`Tes_id`),
  CONSTRAINT `FK_Resultados_test` FOREIGN KEY (`Tes_id`) REFERENCES `test` (`Tes_id`),
  CONSTRAINT `FK_Resultados_usuarios` FOREIGN KEY (`Us_id`) REFERENCES `usuarios` (`Us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resultado_test`
--

LOCK TABLES `resultado_test` WRITE;
/*!40000 ALTER TABLE `resultado_test` DISABLE KEYS */;
/*!40000 ALTER TABLE `resultado_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol_usuario`
--

DROP TABLE IF EXISTS `rol_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol_usuario` (
  `Rol_id` int NOT NULL AUTO_INCREMENT,
  `Rol_nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`Rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol_usuario`
--

LOCK TABLES `rol_usuario` WRITE;
/*!40000 ALTER TABLE `rol_usuario` DISABLE KEYS */;
INSERT INTO `rol_usuario` VALUES (1,'Aprendiz'),(2,'Psicologo'),(3,'Administrador');
/*!40000 ALTER TABLE `rol_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguimiento`
--

DROP TABLE IF EXISTS `seguimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seguimiento` (
  `id_seguimiento` int NOT NULL AUTO_INCREMENT,
  `id_cita` int NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `estado_seg` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_seguimiento`),
  KEY `id_cita` (`id_cita`),
  CONSTRAINT `seguimiento_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`IdCita`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguimiento`
--

LOCK TABLES `seguimiento` WRITE;
/*!40000 ALTER TABLE `seguimiento` DISABLE KEYS */;
INSERT INTO `seguimiento` VALUES (1,15,'idk','2025-11-22 07:20:54','2025-11-22 08:10:34',1);
/*!40000 ALTER TABLE `seguimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test` (
  `Tes_id` int NOT NULL,
  `Tes_titulo` varchar(150) NOT NULL,
  `Tes_descripcion` text,
  `Tes_fecha_creacion` date NOT NULL,
  `Us_id` int DEFAULT NULL,
  PRIMARY KEY (`Tes_id`),
  KEY `FK_test_usuarios` (`Us_id`),
  CONSTRAINT `FK_test_usuarios` FOREIGN KEY (`Us_id`) REFERENCES `usuarios` (`Us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuarios`
--

DROP TABLE IF EXISTS `tipo_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_usuarios` (
  `Ti_id` int NOT NULL,
  `Ti_rol` varchar(50) NOT NULL,
  PRIMARY KEY (`Ti_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuarios`
--

LOCK TABLES `tipo_usuarios` WRITE;
/*!40000 ALTER TABLE `tipo_usuarios` DISABLE KEYS */;
INSERT INTO `tipo_usuarios` VALUES (1,'Cédula de ciudadanía'),(2,'Tarjeta de identidad'),(3,'Cédula de extranjería'),(4,'Pasaporte');
/*!40000 ALTER TABLE `tipo_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `Us_id` int NOT NULL AUTO_INCREMENT,
  `Us_nombre` varchar(50) NOT NULL,
  `Us_apellios` varchar(50) NOT NULL,
  `Us_telefono` varchar(20) DEFAULT NULL,
  `Us_correo` varchar(80) NOT NULL,
  `Us_contraseña` varchar(255) NOT NULL,
  `Us_estado` varchar(20) DEFAULT NULL,
  `Us_fecha_registro` date DEFAULT NULL,
  `Ti_id` int DEFAULT NULL,
  `Us_documento` int NOT NULL,
  `Rol_id` int DEFAULT NULL,
  PRIMARY KEY (`Us_id`),
  KEY `FOREIGN KEYS` (`Ti_id`),
  KEY `Rol_id_idx` (`Rol_id`),
  CONSTRAINT `FOREIGN KEYS` FOREIGN KEY (`Ti_id`) REFERENCES `tipo_usuarios` (`Ti_id`),
  CONSTRAINT `Rol_id` FOREIGN KEY (`Rol_id`) REFERENCES `rol_usuario` (`Rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'nora','nora','123','n@gmail.com','$2y$10$IB/HB8OlNi9F/PfFkcnCKOHmg2.uvxDVxDcvFqKUIE3Vh4pAXbGKW','activo',NULL,1,123456,2),(2,'Natalia','Lizarazo Silva','3053853187','nat@gmail.com','$2y$10$IB/HB8OlNi9F/PfFkcnCKOHmg2.uvxDVxDcvFqKUIE3Vh4pAXbGKW','activo',NULL,2,0,1),(3,'nat','sde','124356','shadg@gmail.com','$2y$10$/mRkIWAGuNMxKhK2tLjSjelBmD9ASDlz3L24WZdzuSRseSrlgbqGO','activo',NULL,2,123456,1),(4,'sfe','adf','12345','123@gmail.com','$2y$10$9TbDDi/JvKmtWcig5yEixe8yVt86suiSufwv43PQT4F2nnoGvsLT2','activo',NULL,2,12345678,1),(5,'Natalia','Lizarazo Silva','3053853187','nat1@gmail.com','$2y$10$plyZUV66KqvQbBGH99ZfCuW/lvbcTYn7Q2hlJg4IFrzbngfw/IKYa','activo',NULL,2,1043677265,1),(6,'edgar','edgar','1234567','edgar@gmail.com','$2y$10$7sXP/VYju41YEgjZjAmEfu07VQbrj5raAkcs.BELyQbKLzeGSQblK','activo',NULL,2,12345678,1),(7,'rdfgt','sersfd','12345678','d@gmail.com','$2y$10$4BJzdPU85KiWRkyaXjxAYOTyUU6Al4rXw4c0qtrzwCTCHXgCccdx2','activo',NULL,1,12345678,1),(9,'Tatiana','Cueto','1234567','T@gmail.com','$2y$10$IB/HB8OlNi9F/PfFkcnCKOHmg2.uvxDVxDcvFqKUIE3Vh4pAXbGKW','activo',NULL,1,123456789,2),(10,'sadafd','asf','123456','1@gmail.com','$2y$10$u/ZJvgM8lwC4SedknF8KOezxYKqknIZ9T7U40OebYeaethq3lNDh2','activo',NULL,3,12354678,1),(11,'awsd','sfd','852','2@gmail.com','$2y$10$Mq6CMOYrzLhdfsQCHwP4e.zHHsCCYnj0gbU8eAYv/rKQMflQi6mTi','activo',NULL,2,12354,1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-22  8:32:26
