/*
SQLyog Community v8.3 
MySQL - 5.5.5-10.2.10-MariaDB : Database - tecnolo1_univhoras
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`horario` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `tecnolo1_univhoras`;

/*Table structure for table `curriculo` */

DROP TABLE IF EXISTS `curriculo`;

CREATE TABLE `curriculo` (
  `curso` int(11) NOT NULL,
  `iddisc` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `serie` int(11) NOT NULL,
  PRIMARY KEY (`curso`,`iddisc`,`serie`),
  KEY `FALTA_DISCIPLINA` (`iddisc`),
  CONSTRAINT `FALTA_DISCIPLINA` FOREIGN KEY (`iddisc`) REFERENCES `disciplina` (`iddisc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `curriculo` */


/*Table structure for table `curso` */

DROP TABLE IF EXISTS `curso`;

CREATE TABLE `curso` (
  `idcurso` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `idprof` int(11) NOT NULL,
  `combinacao` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idcurso`),
  KEY `idprof` (`idprof`),
  CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`idprof`) REFERENCES `professor` (`idprof`)
) ENGINE=InnoDB AUTO_INCREMENT=311 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `curso` */


/*Table structure for table `disciplina` */

DROP TABLE IF EXISTS `disciplina`;

CREATE TABLE `disciplina` (
  `iddisc` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `nome_disc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `aulas_pagas` int(11) DEFAULT NULL,
  `fusao` int(11) NOT NULL,
  PRIMARY KEY (`iddisc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `disciplina` */


/*Table structure for table `horario` */

DROP TABLE IF EXISTS `horario`;

CREATE TABLE `horario` (
  `idhorario` int(11) NOT NULL AUTO_INCREMENT,
  `idturma` int(11) NOT NULL,
  `dia` int(11) NOT NULL,
  `hora` int(11) NOT NULL,
  PRIMARY KEY (`idhorario`),
  UNIQUE KEY `idturma` (`idturma`,`dia`,`hora`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `horario` */


/*Table structure for table `mont_turma` */

DROP TABLE IF EXISTS `mont_turma`;

CREATE TABLE `mont_turma` (
  `idmont` int(11) NOT NULL,
  `idturma` int(11) NOT NULL,
  PRIMARY KEY (`idmont`,`idturma`),
  KEY `turma` (`idturma`),
  CONSTRAINT `montante` FOREIGN KEY (`idmont`) REFERENCES `montante` (`idmont`),
  CONSTRAINT `turma` FOREIGN KEY (`idturma`) REFERENCES `turma` (`idturma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `mont_turma` */


/*Table structure for table `montante` */

DROP TABLE IF EXISTS `montante`;

CREATE TABLE `montante` (
  `idmont` int(11) NOT NULL AUTO_INCREMENT,
  `idcurso` int(11) NOT NULL,
  `serie` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `turno` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idmont`),
  KEY `curso_montante` (`idcurso`),
  CONSTRAINT `curso_montante` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `montante` */


/*Table structure for table `prof_curso` */

DROP TABLE IF EXISTS `prof_curso`;

CREATE TABLE `prof_curso` (
  `curso` int(11) NOT NULL,
  `idprof` int(11) NOT NULL,
  PRIMARY KEY (`curso`,`idprof`),
  KEY `prof` (`idprof`),
  CONSTRAINT `curso` FOREIGN KEY (`curso`) REFERENCES `curso` (`idcurso`),
  CONSTRAINT `prof` FOREIGN KEY (`idprof`) REFERENCES `professor` (`idprof`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `prof_curso` */


/*Table structure for table `professor` */

DROP TABLE IF EXISTS `professor`;

CREATE TABLE `professor` (
  `idprof` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `matricula` int(11) NOT NULL,
  `codpessoa` int(11) NOT NULL,
  `senha` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gestor` int(11) NOT NULL,
  `diretor` int(11) NOT NULL,
  `ch` int(11) DEFAULT NULL,
  PRIMARY KEY (`idprof`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `professor` */


/*Table structure for table `sala` */

DROP TABLE IF EXISTS `sala`;

CREATE TABLE `sala` (
  `idsala` int(11) NOT NULL AUTO_INCREMENT,
  `bloco` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `sala` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `capacidade` int(11) NOT NULL,
  PRIMARY KEY (`idsala`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sala` */


/*Table structure for table `turma` */

DROP TABLE IF EXISTS `turma`;

CREATE TABLE `turma` (
  `idturma` int(11) NOT NULL AUTO_INCREMENT,
  `iddisc` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `idprof` int(11) NOT NULL,
  `turma` int(11) NOT NULL,
  `turno` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `sala` int(11) DEFAULT NULL,
  PRIMARY KEY (`idturma`),
  KEY `turmadisc` (`iddisc`),
  KEY `prodturma` (`idprof`),
  CONSTRAINT `prodturma` FOREIGN KEY (`idprof`) REFERENCES `professor` (`idprof`),
  CONSTRAINT `turmadisc` FOREIGN KEY (`iddisc`) REFERENCES `disciplina` (`iddisc`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `turma` */


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
