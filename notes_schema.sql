-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2014 at 11:27 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `brightpod`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `project_id` int(10) NOT NULL,
  `task_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `channel` varchar(100) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `user_name`, `project_id`, `task_id`, `name`, `description`, `channel`, `created_on`, `updated_on`) VALUES
(7, 2, 'guest', 1, 1, 'demo note on math demo', 'toastr<span>&nbsp;is a Javascript library for non-blocking notifications. jQuery is required. The goal is to create a simple core library that can be customized and extended version.<br><br>extended demo is here<br><br></span><div><li>Demo can be found at&nbsp;<a href="http://codeseven.github.io/toastr/demo.html" target="" rel="">http://codeseven.github.io/toastr/demo.html</a></li><li><a href="http://plnkr.co/edit/6W9URNyyp2ItO4aUWzBB?p=preview" target="" rel="">Demo using FontAwesome icons with toastr</a></li></div>', 'demo_note', '2014-12-11 17:18:23', '2014-12-19 17:43:47'),
(17, 3, 'deep', 1, 1, 'API Management Platform ', '<h2>The foundation of your API program</h2><span><a href="http://www.3scale.net/wp-content/uploads/2012/06/What-is-an-API-1.0.pdf" target="_blank" rel="" title="Link: http://www.3scale.net/wp-content/uploads/2012/06/What-is-an-API-1.0.pdf">API (or Application Programming Interface)</a>&nbsp;is a concept that has been around for several years: exposing application functionality programmatically to other applications and developers. To fully leverage this interaction, you need an API management solution.</span><span>APIs can have a transformative impact on many businesses and their use is becoming central to corporate strategy (cf. article “<a href="http://www.3scale.net/2013/09/why-your-api-is-your-strategy/" target="_blank" rel="">Why your API IS your strategy</a>“). With an API platform and strategy, organizations can:</span><ul><li>Enable mobile strategies</li><li>Develop a customer or partner ecosystem</li><li>Multiply content, data and technology&nbsp;&nbsp;reach</li><li>Create new business models</li><li>Foster internal innovation</li></ul>', 'API_Management_Platform', '2014-12-14 10:25:05', '2014-12-16 14:19:03'),
(19, 4, 'abc', 1, 1, 'just a demo note', 'just a demo description by deepjyoti. Thats it&nbsp;<br><br>', 'just_a_demo_note', '2014-12-14 18:53:43', '2014-12-15 18:34:18');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
