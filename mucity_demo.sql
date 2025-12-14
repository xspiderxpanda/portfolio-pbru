-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2025 at 02:34 PM
-- Server version: 10.6.21-MariaDB-log
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mucity_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `ann`
--

CREATE TABLE `ann` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `img` text NOT NULL,
  `link` text NOT NULL,
  `admin` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ann`
--

INSERT INTO `ann` (`id`, `name`, `detail`, `img`, `link`, `admin`, `date`) VALUES
(1, 'ทดสอบ 1', 'This a long quotations For 50 years, WWF has been protecting the future of nature. The world\'s leading conservation organization, WWF works in 100 countries and is supported by 1.2 million members in the United States and close to 5 million globally.\r\ncan nested some short quote', 'https://itpbru.mucity.online/uploads/1754660838_520736121_1178391920994487_4614652123576630591_n.jpg', '', 'admin', '2025-08-23 22:06:09'),
(2, 'ทดสอบ 2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://itpbru.mucity.online/uploads/1754660838_520736121_1178391920994487_4614652123576630591_n.jpg', 'https://mublue.shop', 'xzpritex', '2025-08-19 23:31:55'),
(3, 'คณะเทคโนโลยีสารสนเทศ จัดกิจกรรมอบรมเชิงปฏิบัติการการเกษตรแม่นยำด้วยไอโอที (IoT)', 'เกษตรกรผู้ปลูกข้าวจากหมู่บ้านโป่งสลอด เข้ารับการอบรมเชิงปฏิบัติการการเกษตรแม่นยำด้วยไอโอทีสำหรับเกษตรกร\r\nคณะเทคโนโลยีสารสนเทศ จัดกิจกรรมอบรมเชิงปฏิบัติการการเกษตรแม่นยำด้วยไอโอที (IoT) สำหรับเกษตรกรชุมชนหนองกะปุ เมื่อวันก่อนนี้ ณ ห้องปฏิบัติการ 26406 คณะเทคโนโลยีสารสนเทศ มหาวิทยาลัยราชภัฏเพชรบุรี เพื่อถ่ายทอดความรู้กับชุมชนในการประยุกต์ใช้เทคโนโลยีอินเตอร์เน็ตในทุกสรรพสิ่งมาใช้ในการทำนา เพื่อสร้างเพิ่มประสิทธิภาพในการทำนาของเกษตรกรและเสริมสร้างความเข้มแข็งของกลุ่ม โดยมีเกษตรกรผู้ปลูกข้าวจากหมู่บ้านโป่งสลอด ซึ่งเป็นพื้นที่บริการวิชาการของคณะเทคโนโลยีสารสนเทศ อาจารย์ บุคลากร นักศึกษาและผู้ที่สนใจเข้าร่วมการอบรม ภายใต้โครงการกิจกรรมยกระดับชุมชนหนองกะปุสู่ศูนย์พันธุ์ข้าวชุมชนท้องถิ่นด้วยกระบวนการทางด้านเทคโนโลยีเพื่อการค้าเชิงพาณิชย์\r\nการอบรมครั้งนี้ได้รับเกียรติจากวิทยากรผู้มีประสบการณ์ทางด้านเทคโนโลยีอินเตอร์เน็ตในทุกสรรพสิ่ง ได้แก่ คุณประสิทธิ์ ป้องสูน และทีมงาน อาจารย์กรกรต เจริญผล รองคณบดีคณะเทคโนโลยีสารสนเทศ มหาวิทยาลัยราชภัฏเพชรบุรี และอาจารย์ศิริพร อ่วมศิริ ผู้ช่วยคณบดีคณะเทคโนโลยีสารสนเทศ มหาวิทยาลัยราชภัฏเพชรบุรี\r\n#เพชรบุรีนิวส์ #ข่าวเพชรบุรี #PhetchaburiNews #เกษตรกร #อบรมเชิงปฏิบัติการ\r\n📢 ติดตามข่าวสารออนไลน์ในจังหวัดเพชรบุรี เพิ่มเติมได้ที่นี่! 📢\r\n* Facebook เพชรบุรีนิวส์ : https://www.facebook.com/profile.php?id=61571852526860\r\n* Youtube เพชรบุรีนิวส์ : www.youtube.com/@PhetchaburiNews', 'https://scontent.fkdt3-1.fna.fbcdn.net/v/t39.30808-6/530508740_122135826848728417_548589807914294807_n.jpg?stp=dst-jpg_s1080x2048_tt6&_nc_cat=103&ccb=1-7&_nc_sid=127cfc&_nc_ohc=ewowYxFq4ukQ7kNvwGl8Ghc&_nc_oc=Adn1ZZF4kpUJpnTkgDxeXnXZqR-RAoMYZ1e5Wq54P4_UUUfB6AZndprFT4-wJxqFIOUSNcZRe85N8gZ3qUI_rpKi&_nc_zt=23&_nc_ht=scontent.fkdt3-1.fna&_nc_gid=bvlh7d6_0R_Qz0oUyBZTmA&oh=00_AfXnVGvGRdCmRIpH442NcY5apU00hcMlBOtAYJ1cF37avQ&oe=68A95090', '', 'admin', '2025-08-23 21:58:21'),
(4, 'คณะเทคโนโลยีสารสนเทศ จัดกิจกรรม IT Ambassador & LGBT 2025 ประจำปีการศึกษา 2568', '📌คณะเทคโนโลยีสารสนเทศ จัดกิจกรรม IT Ambassador & LGBT 2025 ประจำปีการศึกษา 2568 \r\n        สโมสรนักศึกษาคณะเทคโนโลยีสารสนเทศจัดกิจกรรม IT Ambassador & LGBT 2025 ประจำปีการศึกษา 2568 ภายใต้พันธกิจมุ่งมั่นผลิตบัณฑิตที่มีคุณลักษณะตามอัตลักษณ์และเอกลักษณ์ของคณะและมหาวิทยาลัย โดยจัดขึ้นเมื่อวันก่อนนี้ ณ ห้องประชุมนิทัศน์เพียกขุนทด คณะเทคโนโลยีสารสนเทศมหาวิทยาลัยราชภัฎเพชรบุรี \r\n        สำหรับวัตถุประสงค์เพื่อให้นักศึกษาปีที่หนึ่งได้มีความกล้าแสดงออก เก่ง ดี มีสุข สรรหานักศึกษาที่มีจิตอาสาช่วยเหลือและบำเพ็ญประโยชน์ต่อสังคม มีความเป็นผู้นำพร้อมเป็นตัวแทนในการทำกิจกรรม เสริมสร้างให้นักศึกษามีความกล้าแสดงออกด้านศิลปะและวัฒนธรรม มีบุคลิกที่ดีและพร้อมที่จะเป็นตัวแทนที่จะเผยแพร่และประชาสัมพันธ์กิจกรรมของคณะเทคโนโลยีสาระสนเทศและมหาวิทยาลัยราชภัฎเพชรบุรี \r\n        ผลการแข่งขัน  IT Ambassador (ดาวคณะ) ได้แก่ นางสาวนุชจิรา ปานประเสริฐ สาขาวิชาคอมพิวเตอร์ IT Ambassador (เดือนคณะ) ได้แก่ นายฉัตรชัย ส้มภา วิทยาการคอมพิวเตอร์ แขนงวิทยาการซอฟต์แวร์ และยังได้รับรางวัล IT Popular Vote (ขวัญใจมหาชน) ด้วย\r\n#กลุ่มงานสื่อสารองค์กรมหาวิทยาลัยราชภัฏเพชรบุรี\r\n#คณะเทคโนโลยีสารสนเทศมหาวิทยาลัยราชภัฏเพชรบุรี\r\n#ราชภัฏเพชรบุรีกับการผลิตบัณฑิต\r\n#100ปีราชภัฏเพชรบุรี \r\n...................................................\r\n🌎ติดตามความเคลื่อนไหวของมหาวิทยาลัยราชภัฏเพชรบุรีได้ที่👇👇\r\n    🔸Website: www.pbru.ac.th\r\n    🔸Facebook: มหาวิทยาลัยราชภัฏเพชรบุรี งานสื่อสารองค์กร https://www.facebook.com/prpbru\r\n    🔸Youtube: (Pbru Channel) https://www.youtube.com/@PBRUChannel\r\n    🔸TikTok: (pbruofficial) https://www.tiktok.com/@pbruofficial?_t=8rsFgH6g8fA&_r=1\r\n    🔸IG: (pbru_official) https://www.instagram.com/pbru_official?igsh=MWsweGN2YXc4em5oOA==\r\n    🔸Twitter: (pbruofficial) https://x.com/pbruofficial?s=21', 'https://scontent.fkdt3-1.fna.fbcdn.net/v/t39.30808-6/532721237_1175889237914526_2085609022082904268_n.jpg?stp=dst-jpg_p960x960_tt6&_nc_cat=109&ccb=1-7&_nc_sid=127cfc&_nc_ohc=jvxX3jvnWXgQ7kNvwG-kHpk&_nc_oc=AdkU86-V0urU7euK3Aubd_ESo1kM628bvm2xNMVo-M0-0gGCAy6RXZtFe6W06LoBxU1t4_jE7xIxSxV8Sxx6gU95&_nc_zt=23&_nc_ht=scontent.fkdt3-1.fna&_nc_gid=b6XVghbXeozblaMGnOmDDA&oh=00_AfUpCLPM6qRvOieI-orFHVO-LiRlXu6SPAiVflz0n7-b0w&oe=68A96451', '', 'admin', '2025-09-02 10:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `id` int(11) NOT NULL,
  `img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id`, `img`) VALUES
(1, 'https://itpbru.mucity.online/uploads/slides/slide_68af27fb27ccd1.69103010_DEK-IT-Webcover2-3000x1000.png'),
(2, 'https://mucity.online/img/bannerrecom.png');

-- --------------------------------------------------------

--
-- Table structure for table `discord`
--

CREATE TABLE `discord` (
  `client` varchar(255) NOT NULL,
  `secrets` varchar(255) NOT NULL,
  `of` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discord`
--

INSERT INTO `discord` (`client`, `secrets`, `of`) VALUES
('1327977990348603392', 'jqU_SQdDDbKpoDtGkaN2prX7F92munGp', '1');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password`
--

CREATE TABLE `forgot_password` (
  `id` int(11) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `ref_otp` varchar(255) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `forgot_password`
--

INSERT INTO `forgot_password` (`id`, `otp`, `ref_otp`, `uid`, `email`, `date`) VALUES
(7, '672-259', 'WBOLHQER', '4', 'xspider.panda@gmail.com', '2025-09-02 02:39:25'),
(8, '303-851', 'LZKIBCHN', '4', 'xspider.panda@gmail.com', '2025-09-02 02:42:55'),
(9, '612-764', 'FMTRIPSL', '4', 'xspider.panda@gmail.com', '2025-09-02 02:43:48'),
(10, '485-499', 'QHVMETYN', '4', 'xspider.panda@gmail.com', '2025-09-02 02:48:00'),
(11, '989-263', 'BZTISOYU', '4', 'xspider.panda@gmail.com', '2025-09-02 02:49:18'),
(12, '254-890', 'AETODRVM', '4', 'xspider.panda@gmail.com', '2025-09-02 02:50:51'),
(13, '747-697', 'VYCHLUGR', '4', 'xspider.panda@gmail.com', '2025-09-02 02:54:48'),
(14, '958-939', 'VXSNPFYJ', '4', 'xspider.panda@gmail.com', '2025-09-02 02:55:29'),
(15, '285-178', 'CWZYORUX', '4', 'xspider.panda@gmail.com', '2025-09-02 02:55:51'),
(16, '401-735', 'EVSGDCTW', '4', 'xspider.panda@gmail.com', '2025-09-02 03:32:16'),
(17, '403-755', 'NZOTAWYB', '5', 'nupluem0110@gmail.com', '2025-09-08 15:45:13');

-- --------------------------------------------------------

--
-- Table structure for table `idol`
--

CREATE TABLE `idol` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `img` text NOT NULL,
  `banner` text NOT NULL,
  `info` text NOT NULL,
  `major_id` int(11) NOT NULL,
  `dateofbirth` date NOT NULL,
  `u_admin` varchar(255) NOT NULL,
  `position` varchar(2) NOT NULL DEFAULT '0',
  `view` varchar(255) NOT NULL DEFAULT '0',
  `love` varchar(255) NOT NULL DEFAULT '0',
  `contact` varchar(255) NOT NULL,
  `dateupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `idol`
--

INSERT INTO `idol` (`id`, `name`, `nickname`, `img`, `banner`, `info`, `major_id`, `dateofbirth`, `u_admin`, `position`, `view`, `love`, `contact`, `dateupdate`) VALUES
(1, 'Napasorn Poonsawat', 'สไปร์ท', 'https://i.ibb.co/08NDxgk/520051490-2623479761354383-7123878301723327504-n.jpg', 'https://mucity.online/img/bannertopupnew.png', '############################################################################\r\nแสดงรายละเอียด\r\nข้อมูลที่อยากเขียนต่างๆในช่องนี้\r\nฯลฯ\r\n#######################', 0, '2003-02-10', '1', '4', '406', '5', '#', '2025-09-02 10:26:41'),
(2, 'Witsupakit Bunwanich', 'Wit', 'https://i.ibb.co/s9wxXB3p/488865991-2113675682483843-7789307433493141642-n.jpg', 'https://mucity.online/img/bannertopupnew.png', '###', 1, '2003-11-15', '2', '4', '11', '1', '#', '2025-09-08 19:07:05'),
(3, 'Nattida Pumjarern', 'Gade', 'https://i.ibb.co/jv9Jrdf8/525124851-1955650638503138-7856997030155304135-n.jpg', 'https://mucity.online/img/bannertopupnew.png', '##', 1, '2003-11-15', '3', '4', '7', '1', '#', '2025-09-08 19:14:40'),
(4, 'Supachaok Toowichen', 'Pond', 'https://i.ibb.co/Myd6C9cD/484859819-9289695627814516-8874140966825118702-n.jpg', 'https://mucity.online/img/bannertopupnew.png', '##', 6, '2003-06-23', '3,4,5', '4', '3', '0', 'https://www.facebook.com/P.PonKung', '2025-09-30 01:04:17'),
(5, 'Suphamongkol khunmee', 'Phoom', 'https://i.ibb.co/hRFpg7Sj/69b8abaf-09fb-42e8-822f-9b26b9c9df87.jpg', 'https://mucity.online/img/bannertopupnew.png', '#', 1, '2002-10-03', '3', '4', '2', '0', 'https://www.facebook.com/phoom.suphamongkol', '2025-09-08 19:19:59'),
(6, 'Ratsadaphon Ketkaew', 'Pluem', 'https://scontent.fbkk12-4.fna.fbcdn.net/v/t39.30808-6/550813174_1747219679314292_1538321379227223658_n.jpg?_nc_cat=103&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=DOpDZebZBnwQ7kNvwHaJe30&_nc_oc=AdltxeeCzjKj1CvBwpZjLgCW6QutvU_3bin62bGqYmkOEZv3zK7HrCikvRKSIrY1A6BYf3Ig2_G0SpVyKM9I3RPe&_nc_zt=23&_nc_ht=scontent.fbkk12-4.fna&_nc_gid=_Tckh1IB6ex2a1V7_eNTMw&oh=00_AfZf2BvRuCcj67MWU-fERnSTCD8DCZEGSs67ZhxFGvmgyA&oe=68E0AB2D', 'https://scontent.fbkk12-3.fna.fbcdn.net/v/t39.30808-6/503559581_4061144347459271_5133859893102427387_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=833d8c&_nc_ohc=_KjuwWLmPjgQ7kNvwEmZM6E&_nc_oc=Adnk-808szYUqIIg7K1hSoADGRzEwTXsj4joI4D2KNf98epekfAPfgunzc3RwRfateKjZLhui5UDUfFlKenqPRVU&_nc_zt=23&_nc_ht=scontent.fbkk12-3.fna&_nc_gid=59-c_bjgU5_jXWmTWojl1w&oh=00_AfbU_ZHMSzPmbyHPN7ZCbsYt0i4bbD-QLA0yv72mt3fYZg&oe=68E0AD33', 'รหัสนักศึกษา : 654274105 \nกำลังศึกษาอยู่ : ระดับชั้นปริญญาตรี คณะเทคโนโลยีสารสนเทศ สาขาวิชา คอมพิวเตอร์ประยุกต์ \nแขนงวิชาเทคโนโลยีเว็บและมัลติมีเดีย  (วท.บ.)', 6, '2003-10-01', '5', '4', '8', '3', 'https://www.facebook.com/ratsadaphon.ketkaew/', '2025-09-30 09:58:57'),
(7, 'Janistar Phomphadungcheep', 'Janis', 'https://i.ibb.co/qM84RKBr/471192602-4082518068736335-6373859489478620081-n.jpg', 'https://mucity.online/img/bannertopupnew.png', '#', 1, '1995-03-18', '1', '4', '12', '9', 'https://www.facebook.com/Janistarr', '2025-09-29 21:33:31'),
(8, 'sasdๅ/-ๅ/-ๅ/', 'asdasdaa-ๅ/-', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Amazon_Prime_logo_%282022%29.svg/1600px-Amazon_Prime_logo_%282022%29.svg.png', 'https://mucity.online/img/mubluelogo.png', '515as1dasdadsad\nasdASDASD\nFSADF\nDSAF\nSAD\nFASD\nFADS\nF\nASDF\nADS\nFSDFGDSGHIHUDFSGGDFSG\nDFAIGHYDFSUGHKLSDFG\nSDFJOGHJSDKFHG225125sdf23ds0f', 1, '2003-02-10', '1,4', '0', '1', '0', '1234657125', '2025-09-29 21:55:52'),
(9, 'Kitchaphong Plaipraserth', 'love', 'https://img5.pic.in.th/file/secure-sv1/545430743_1770426296940539_689175677295069738_n.jpg', '', '', 6, '2004-10-09', '5', '0', '6', '0', 'https://web.facebook.com/xi.leif.263156', '2025-09-30 01:04:38');

-- --------------------------------------------------------

--
-- Table structure for table `idol_portfolio`
--

CREATE TABLE `idol_portfolio` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `img` text NOT NULL,
  `url` text NOT NULL,
  `github` varchar(255) DEFAULT NULL,
  `facebook` text DEFAULT NULL,
  `pdf` text DEFAULT NULL,
  `idol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `idol_portfolio`
--

INSERT INTO `idol_portfolio` (`id`, `title`, `detail`, `img`, `url`, `github`, `facebook`, `pdf`, `idol_id`) VALUES
(1, 'งานออกแบบเว็บไซต์และระบบ สินเชื่อไอคราว ผ่อนมือถือ สั่งซื้อสินค้า', 'ไปร์ทได้มีโอกาสรับงานออกแบบเว็บไซต์และระบบ สินเชื่อไอคราว ผ่อนมือถือ สั่งซื้อสินค้า ซึ่งมี Requirement ค่อนข้างเยอะและมีดีเทลรวมไปถึงระบบ Security ในการใช้งานเว็บไซต์รวมไปถึงข้อมูลของผู้ใช้งานด้วย ทำให้โจทย์ของงานนี้ค่อนข้างยาก ซึ่งใช้ระยะเวลาประมาณ 60 วัน ++ ไม่รวมหลังทดสอบระบบและแก้ไขระบบเพิ่มเติม\r\nหลักๆ เว็บไซต์จะเน้นการขายสินค้าแบบผ่อนสินค้า ทำให้มีการคำนวณค่างวดในตารางค่อนข้างซับซ้อนและใช้คณิตศาสตร์เยอะ ซึ่งต้องห้ามพลาดเด็ดขาดในเรื่องตัวเลข \r\nรวมไปถึงการทำ API ระบบ LOGIN ด้วย Google,Line,Facebook  ระบบ Google Maps API ที่ใช้การเช็คระยะและคำนวณระยะห่างจากสาขาที่ใกล้เคียง Location ของผู้ใช้งานบนเว็บไซต์ด้วย และระบบเช็คสลิปโดยผู้ให้บริการเช็คสลิปอย่าง SlipOK ในการตรวจสอบการชำระค่าบริการสินค้า +ค่าจัดส่งพัสดุ', 'https://i.ibb.co/DHkPPv9Q/2568-09-08-18-52-36.png', 'https://sadasdad.com', 'xxx', '', '', 1),
(2, 'เขมสุรา', 'สวัสดี เรา เขมสุรา !', 'https://i.ibb.co/sJvhPJpr/545500791-4328066144181525-2550959273135799226-n.jpg', '#', '-', NULL, NULL, 7),
(4, 'โปรเจค IOT', 'ผมได้มีโอกาสเขียน Python บนเครื่อง ESP32 WIFI เพื่อทดลองใช้งานระบบเครื่องสายพานนับสินค้า', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Amazon_Prime_logo_%282022%29.svg/1600px-Amazon_Prime_logo_%282022%29.svg.png', '#', '', '', '', 4),
(6, 'รายงาน', 'การวิเคราะห์การใช้ห้องน้ำโดยใช้Model clustering เพื่อสำรวจความ พึงพอใจการใช้ห้องน้ำมหาวิทยาลัยราชภัฏเพชรบุรี', 'https://img5.pic.in.th/file/secure-sv1/Screenshot-2025-09-30-003735.png', '', '', '', '', 6),
(7, 'สื่อ', 'เหตุผลเชิงตรรกะกับการแก้ปัญหา', '', 'https://www.canva.com/design/DAGz5zMQrS0/6OWSb0TO0ZpIGTDtY_uOBw/edit?utm_content=DAGz5zMQrS0&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton', '', '', '', 9);

-- --------------------------------------------------------

--
-- Table structure for table `idol_portfolio_img`
--

CREATE TABLE `idol_portfolio_img` (
  `id` int(11) NOT NULL,
  `img` text NOT NULL,
  `port_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idol_portfolio_img`
--

INSERT INTO `idol_portfolio_img` (`id`, `img`, `port_id`) VALUES
(1, 'https://i.ibb.co/5gQqLDZW/2568-09-08-18-51-29.png', 1),
(2, 'https://i.ibb.co/DHkPPv9Q/2568-09-08-18-52-36.png', 1),
(3, 'https://i.ibb.co/sJvhPJpr/545500791-4328066144181525-2550959273135799226-n.jpg', 3),
(4, 'https://i.ibb.co/Rpz3ZBJT/545367609-4328066110848195-6812488004396017101-n.jpg', 3),
(5, 'https://i.ibb.co/p6b3kFWc/545190072-4328066150848191-3739327856784740830-n.jpg', 3),
(6, 'https://i.ibb.co/TD995dmx/545152904-4328066104181529-502134859323782224-n.jpg', 3),
(7, 'https://i.ibb.co/v9MWHD6/2568-09-08-19-42-59.png', 1),
(8, 'https://i.ibb.co/39GM6zTV/2568-09-08-19-42-52.png', 1),
(9, 'https://i.ibb.co/zV3kwK13/2568-09-08-19-41-28.png', 1),
(10, 'https://i.ibb.co/SDJzLPHt/2568-09-08-19-41-19.png', 1),
(11, 'https://i.ibb.co/S4xyQcs1/2568-09-08-19-41-13.png', 1),
(12, 'https://i.ibb.co/Q3qjdtJX/2568-09-08-19-40-47.png', 1),
(13, 'https://i.ibb.co/p6kZFCQH/2568-09-08-19-40-05.png', 1),
(14, 'https://i.ibb.co/WpvBbYWs/2568-09-08-19-39-52.png', 1),
(15, 'https://i.ibb.co/qY0sm047/2568-09-08-19-38-32.png', 1),
(16, 'https://i.ibb.co/N6nqYq3F/2568-09-08-19-38-11.png', 1),
(17, 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Amazon_Prime_logo_%282022%29.svg/1600px-Amazon_Prime_logo_%282022%29.svg.png', 4),
(18, 'https://img5.pic.in.th/file/secure-sv1/Screenshot-2025-09-30-003735.png', 6);

-- --------------------------------------------------------

--
-- Table structure for table `idol_views`
--

CREATE TABLE `idol_views` (
  `id` int(11) NOT NULL,
  `idol_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `last_view` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idol_views`
--

INSERT INTO `idol_views` (`id`, `idol_id`, `ip_address`, `last_view`) VALUES
(90, 7, '2001:fb1:a0:9946:d416:ef72:e4a0:146d', '2025-12-14 14:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `line`
--

CREATE TABLE `line` (
  `clientid` varchar(255) NOT NULL,
  `of` varchar(10) NOT NULL,
  `secretid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `line`
--

INSERT INTO `line` (`clientid`, `of`, `secretid`) VALUES
('2006545583', '1', 'e22da0f6e2dfe9b5cada6c9b85308e94');

-- --------------------------------------------------------

--
-- Table structure for table `logloveidol`
--

CREATE TABLE `logloveidol` (
  `id` int(11) NOT NULL,
  `idol_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `status_love` tinyint(1) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logloveidol`
--

INSERT INTO `logloveidol` (`id`, `idol_id`, `u_id`, `status_love`, `date`) VALUES
(1, 7, 1, 1, '2025-09-18 16:16:58'),
(2, 2, 1, 1, '2025-09-18 16:17:02'),
(3, 1, 1, 1, '2025-09-18 16:17:08'),
(4, 3, 1, 1, '2025-09-18 16:17:15'),
(5, 1, 4, 1, '2025-09-30 00:16:46'),
(6, 6, 5, 1, '2025-09-30 00:26:09'),
(7, 6, 4, 1, '2025-09-30 01:14:40'),
(8, 1, 5, 1, '2025-09-30 10:12:37');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`id`, `name`) VALUES
(1, 'แขนงวิทยาการข้อมูลและสารสนเทศ '),
(2, 'แขนงวิทยาการซอฟต์แวร์ (Software Engineering)'),
(3, 'แขนงดิจิทัลคอนเทนต์และเกม (Digital Content & Game)'),
(4, 'แขนงเทคโนโลยีเว็บและมัลติมีเดีย (Web and Multimedia Technology)'),
(5, 'แขนงเทคโนโลยีคอมพิวเตอร์สำนักงาน (Office Computer Technology)'),
(6, 'สาขาวิชาคอมพิวเตอร์ศึกษา (Computer Education)'),
(7, 'หลักสูตรเก่าอื่นๆ ฯลฯ');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `bg` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ann` varchar(500) NOT NULL,
  `main_color` varchar(255) NOT NULL,
  `sec_color` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `des` varchar(255) NOT NULL,
  `date` datetime(2) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `linetoken` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `bannerbank` varchar(255) NOT NULL,
  `themeshop` varchar(20) NOT NULL,
  `bgcolor` varchar(255) NOT NULL,
  `textcolor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `bg`, `name`, `ann`, `main_color`, `sec_color`, `contact`, `des`, `date`, `logo`, `linetoken`, `facebook`, `bannerbank`, `themeshop`, `bgcolor`, `textcolor`) VALUES
(1, 'logo.png', 'เว็บไซต์ รวบรวมผลงานนักศึกษาและศิษย์เก่า คณะเทคโนโลยีสารสนเทศ มหาวิทยาลัยราชภัฏเพชรบุรี', '', '#3b82f6', '#64748b', '', 'แพลตฟอร์มรวบรวมผลงาน โปรเจค แอป เว็บไซต์ ของนักศึกษาและศิษย์เก่า คณะเทคโนโลยีสารสนเทศ มหาวิทยาลัยราชภัฏเพชรบุรี สำรวจผลงานนวัตกรรมไอที ค้นพบผลงานสุดยอดจากนักพัฒนาเทคโนโลยีรุ่นใหม่ คณะเทคโนโลยีสารสนเทศ มหาวิทยาลัยราชภัฏเพชรบุรี รวบรวมโปรเจค แอพพลิเคชั่น เว', '0000-00-00 00:00:00.00', 'https://demo.mucity.online/img/itlogo.png', '', '', 'https://mucity.online/img/bannertopupnew.png', '0', 'sky-300', 'text-white');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT '0',
  `img` text NOT NULL,
  `social_id` varchar(255) NOT NULL,
  `u_type` varchar(255) NOT NULL,
  `ip` text NOT NULL,
  `statusonline` varchar(2) NOT NULL DEFAULT '0',
  `created_at` date NOT NULL,
  `failed_attempts` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `nickname`, `password`, `email`, `role`, `img`, `social_id`, `u_type`, `ip`, `statusonline`, `created_at`, `failed_attempts`) VALUES
(1, 'U73ba223370102ae892a290342c91b438', 'muffdcc', '$2y$10$PPRemxUHTfr/wQ3kKUPw8.i/0zAN32jwJovqzLodFGAzin6SDXM1i', '', '2', 'https://profile.line-scdn.net/0h5IQ7bzj6amZ8TnSI7cAUWAweaQxfPzN0VCgkCU1ONlNEeSlkA3t1Ux4eNQVHLH85VSAhCU9HZ1NedkZSDFBYeyAWNwxJey1jWCxuWRQrbFUXP0tiMlNHUDoPQy4aOSRtOEZ3VjMTRgExfUtPUXMsHB4-NiwDYnNeVhkGMHl8BOUTTB0zUSkiBExKMF_D', 'U73ba223370102ae892a290342c91b438', 'line', '202.29.65.38', '1', '2025-01-12', 0),
(2, 'asdasdasd1', 'asdss', '$2y$10$yFdesIe4Z5XsnEaAnut0Z.16.Jy/gicJbLpYClqwI4RD7hKuR9lyS', 'NULL', '0', 'https://mublue.shop/img/mubluelogo.png', 'website', 'website', '::1', '0', '2025-01-12', 0),
(3, 'U1f93d65586796f08ebf20f6202e320f4', 'mu1a6cb', '$2y$10$I8uDrwu0h2/cYVniLnBzc.h5YvV/JmxL4VIVQaKR9kRntJ70Y2Nui', 'NULL', '2', 'https://profile.line-scdn.net/0hxfzuAKgQJ0lXDDZpqUFZNidcJCN0fX5bf2ppJmYMe3xvO2RLKDk4fDVceCpsbjIWfmJsJmQFKnxbH1AvSVrbfVA8enhrO2YdeWJpqA', 'U1f93d65586796f08ebf20f6202e320f4', 'line', '171.4.4.136', '0', '2025-01-13', 0),
(4, 'admin', 'Admin NAJA', '$2y$10$3HJCoWb/PqSkfLVz9TQdK.md3fmHV0Q5taRxxKc5K2x0hiGsPwraC', 'xspider.panda@gmail.com', '2', 'logo.png', 'website', 'website', '202.29.65.39', '0', '2025-01-13', 0),
(5, 'Nupluem', 'Pluem', '$2y$10$jhcKvF4z535sqEZ44CvRPexllQXyow0TPCXbUxwbZcRu7giLlJK5O', 'nupluem0110@gmail.com', '1', 'https://demo.mucity.online/img/itlogo.png', 'website', 'website', '202.29.65.39', '1', '2025-09-02', 0),
(6, 'ked_nattida', 'น้องเกดจ้า', '$2y$10$6YtYwL9pNJDjGYobIdifW.pYx9mOK9Tqlcnv4AxrktUtJKzNaDYVu', 'nattida.pum@mail.pbru.ac.th', '0', 'https://demo.mucity.online/img/itlogo.png', 'website', 'website', '2001:3c8:2105:e2:f1c8:14dc:ff25:2b0b', '1', '2025-09-02', 0),
(7, 'hasjgdkavdyfivk', 'cเ่ก้เา้สห่วฟงก้สเาอ', '$2y$10$DRPRbri5Yeo4l1OUtKS7yuBozUIo8co38C2bFpg9dT7Xvp91W0Qum', 'jhvcaghsjiudgvjhk@gmail.com', '0', 'https://demo.mucity.online/img/itlogo.png', 'website', 'website', '2001:44c8:6102:cbe3:15ec:b1e:a9ed:3d94', '1', '2025-09-02', 0),
(8, 'kitchaphong1150', 'luv', '$2y$10$X0AlsYkDvsNwXNC49xPwJuqwnMsod.eHdwRCpCRS4B0FZgYoIIJKi', 'kitchaphong1150@gmail.com', '0', 'https://demo.mucity.online/img/itlogo.png', 'website', 'website', '101.108.27.105', '1', '2025-09-08', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ann`
--
ALTER TABLE `ann`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discord`
--
ALTER TABLE `discord`
  ADD PRIMARY KEY (`of`);

--
-- Indexes for table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idol`
--
ALTER TABLE `idol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idol_portfolio`
--
ALTER TABLE `idol_portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idol_portfolio_img`
--
ALTER TABLE `idol_portfolio_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idol_views`
--
ALTER TABLE `idol_views`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idol_id` (`idol_id`,`ip_address`);

--
-- Indexes for table `line`
--
ALTER TABLE `line`
  ADD PRIMARY KEY (`of`);

--
-- Indexes for table `logloveidol`
--
ALTER TABLE `logloveidol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ann`
--
ALTER TABLE `ann`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `forgot_password`
--
ALTER TABLE `forgot_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `idol`
--
ALTER TABLE `idol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `idol_portfolio`
--
ALTER TABLE `idol_portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `idol_portfolio_img`
--
ALTER TABLE `idol_portfolio_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `idol_views`
--
ALTER TABLE `idol_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `logloveidol`
--
ALTER TABLE `logloveidol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `major`
--
ALTER TABLE `major`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
