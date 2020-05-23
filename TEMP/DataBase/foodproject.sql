-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 28 Ara 2019, 17:41:00
-- Sunucu sürümü: 10.1.30-MariaDB
-- PHP Sürümü: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `foodproject`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `parentid` int(11) DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `category`
--

INSERT INTO `category` (`id`, `parentid`, `keywords`, `description`, `image`, `status`, `created_at`, `updated_at`, `title`) VALUES
(4, 0, 'dönerr', 'Kebap', NULL, 'True', NULL, NULL, 'Kebap'),
(5, 0, 'Burger', 'Burger', NULL, 'False', NULL, NULL, 'Burger'),
(6, 4, 'Döner', 'Döner', NULL, 'True', NULL, NULL, 'Döner'),
(7, 4, 'Adana', 'Adana', NULL, 'False', NULL, NULL, 'Adana');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `subject` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `foodid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `comment`
--

INSERT INTO `comment` (`id`, `subject`, `comment`, `status`, `ip`, `userid`, `created_at`, `updated_at`, `rate`, `foodid`) VALUES
(1, 'test', 'Comment', 'true', NULL, NULL, NULL, NULL, 5, NULL),
(2, 'Best Food', 'I like it', 'true', NULL, 31, NULL, NULL, 2, 3),
(3, 'Best Food', 'I like it', 'true', NULL, 22, NULL, NULL, 2, 3),
(4, 'Test subject', NULL, 'true', '127.0.0.1', 22, NULL, NULL, 5, 3),
(5, 'Test subject', 'Test Comment', 'new', '127.0.0.1', 22, NULL, NULL, 5, 3),
(6, 'Very Good', 'Çok lezzetli', 'new', '127.0.0.1', 22, NULL, NULL, 5, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `food`
--

CREATE TABLE `food` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `food`
--

INSERT INTO `food` (`id`, `category_id`, `title`, `keywords`, `description`, `image`, `detail`, `status`, `created_at`, `updated_at`, `details`, `userid`) VALUES
(1, 6, 'Döner', 'döner', 'döner', '20d754ce83f32d2b91f4df24e1bbf223.jpeg', NULL, 'true', NULL, NULL, NULL, NULL),
(2, 5, 'burger', 'burger', 'burger', '819836e36a7a4fa6f091e9323797bc63.jpeg', NULL, 'true', NULL, NULL, NULL, NULL),
(3, 7, 'Adana', 'adana', 'Adana', '768ad48cd2fe2ad84b8be7054d137295.jpeg', NULL, 'false', NULL, NULL, NULL, NULL),
(5, 4, 'Adana', 'adana', 'Adana', '18dff855313ec8982644ad69b4eee7df.jpeg', NULL, 'true', NULL, NULL, NULL, NULL),
(6, 6, 'İskender', 'İskender', 'İskender', '2f32c060f9615965e7e653c80293ee0f.jpeg', NULL, 'true', NULL, NULL, NULL, 22),
(7, 6, 'İskender', 'İskender', 'İskender', '1595de263ec1a9b5ace543298d48c56b.jpeg', NULL, 'true', NULL, NULL, NULL, 22),
(8, 6, 'İskender', 'İskender', 'İskender', 'b3a875922a0a01902fdca52d2bdb08e3.jpeg', NULL, 'true', NULL, NULL, NULL, 31);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `food_id` int(11) DEFAULT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `image`
--

INSERT INTO `image` (`id`, `food_id`, `title`, `image`) VALUES
(3, 3, 'adana', 'b22db175843f245b3c89cd2cc11d95cc.jpeg'),
(4, 1, 'döner', '0be7205821990a60265adbf88bef0649.jpeg'),
(7, 1, 'döner', '271321d98fe9b25051e919a220da7118.jpeg'),
(8, 6, 'İskender', '66e790db3756465cf489613130b3e0f9.jpeg'),
(9, 8, 'döner', 'ab780086b75fdbc947425c639beddcdb.jpeg'),
(10, 8, 'döner', '8a5a25b686208f94ba97ee334015619c.jpeg'),
(11, 7, 'döner', '7a1157933aeb63dfac98e066aebff1d1.jpeg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `messages`
--

INSERT INTO `messages` (`id`, `name`, `subject`, `message`, `status`, `ip`, `note`, `created_at`, `updated_at`, `email`) VALUES
(1, 'karabük', 'test subject', 'seasdasdasdasd', 'Read', '127.0.0.1', '', NULL, NULL, 'bayrakozan4@gmail.com'),
(2, 'karabük', 'test subject', 'seasdasdasdasd', 'new', '127.0.0.1', NULL, NULL, NULL, 'bayrakozan4@gmail.com'),
(3, 'Ozan', 'test subject', 'merhabalarrrrrr', 'Read', '127.0.0.1', NULL, NULL, NULL, 'bayrakozan4@gmail.com'),
(4, 'ozan', 'ozan', 'ozan', 'Read', '127.0.0.1', '', NULL, NULL, 'ozan'),
(5, 'ozan', 'OZAN BAYRAK', 'Merhaba', 'new', '127.0.0.1', NULL, NULL, NULL, 'bayrakozan4@gmail.com'),
(6, 'ozan', 'OZAN BAYRAK', 'Merhaba', 'new', '127.0.0.1', NULL, NULL, NULL, 'bayrakozan4@gmail.com'),
(7, 'ozan', 'OZAN BAYRAK', 'Merhaba', 'new', '127.0.0.1', NULL, NULL, NULL, 'bayrakozan4@gmail.com'),
(8, 'ozan', 'OZAN BAYRAK', 'Merhaba', 'new', '127.0.0.1', NULL, NULL, NULL, 'bayrakozan4@gmail.com'),
(9, 'ozan', 'OZAN BAYRAK', 'Merhaba', 'new', '127.0.0.1', NULL, NULL, NULL, 'bayrakozan4@gmail.com');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20191129215718', '2019-11-29 21:58:27'),
('20191129220826', '2019-11-29 22:08:45'),
('20191129221204', '2019-11-29 22:12:44'),
('20191129221708', '2019-11-29 22:17:28'),
('20191129222008', '2019-11-29 22:20:32'),
('20191129222322', '2019-11-29 22:23:31'),
('20191129222627', '2019-11-29 22:26:34'),
('20191129222832', '2019-11-29 22:28:41'),
('20191129223103', '2019-11-29 22:31:12'),
('20191129223213', '2019-11-29 22:32:23'),
('20191129223339', '2019-11-29 22:33:47'),
('20191130154115', '2019-11-30 15:41:43'),
('20191202170211', '2019-12-02 17:04:13'),
('20191205182227', '2019-12-05 18:23:20'),
('20191206145809', '2019-12-06 14:58:36'),
('20191207173247', '2019-12-07 17:33:26'),
('20191208144914', '2019-12-08 14:50:30'),
('20191214153811', '2019-12-14 15:38:47'),
('20191215161513', '2019-12-15 16:15:41'),
('20191215163153', '2019-12-15 16:32:18'),
('20191215233333', '2019-12-15 23:34:01'),
('20191215235726', '2019-12-15 23:57:45'),
('20191224211946', '2019-12-24 21:20:09'),
('20191224234538', '2019-12-24 23:46:08'),
('20191225003928', '2019-12-25 00:39:49'),
('20191225005414', '2019-12-25 00:54:42');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foodid` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `orders`
--

INSERT INTO `orders` (`id`, `title`, `foodid`, `description`, `image`, `price`, `status`) VALUES
(5, 'Adana Kebap', 6, 'Adana Kebap', 'dc7a12f0727a4232326c21c8d1f7279a.jpeg', 20, 'true');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `foodid` int(11) DEFAULT NULL,
  `ordersid` int(11) DEFAULT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `ip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `messages` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `order_details`
--

INSERT INTO `order_details` (`id`, `userid`, `foodid`, `ordersid`, `name`, `surname`, `email`, `phone`, `amount`, `total`, `ip`, `note`, `messages`, `status`, `created_at`, `updated_at`, `adress`) VALUES
(1, 22, 6, 5, 'OZAN', 'BAY', 'ozi@gmail.com', '656656565656', 2, 40, '127.0.0.1', NULL, NULL, 'new', NULL, NULL, NULL),
(2, 22, 6, 5, 'ozan bayrak', 'BAY', 'bayrakozan4@gmail.com', '05466170069', 2, 40, '127.0.0.1', NULL, NULL, 'new', NULL, NULL, NULL),
(3, 22, 6, 5, 'OZAN', 'BAY', 'ozi@gmail.com', '232323', 3, 60, '127.0.0.1', NULL, 'asdasdasd', 'new', NULL, NULL, NULL),
(4, 22, 6, 5, 'OZAN', 'BAY', 'ozi@gmail.com', '3434434', 1, 20, '127.0.0.1', 'sadasd', 'sadasd', 'new', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtpserver` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtpemail` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtppassword` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtpport` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aboutus` longtext COLLATE utf8mb4_unicode_ci,
  `contact` longtext COLLATE utf8mb4_unicode_ci,
  `reference` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `setting`
--

INSERT INTO `setting` (`id`, `title`, `keywords`, `description`, `company`, `address`, `phone`, `fax`, `email`, `smtpserver`, `smtpemail`, `smtppassword`, `smtpport`, `facebook`, `instagram`, `twitter`, `aboutus`, `contact`, `reference`, `status`) VALUES
(1, 'Ozan Online Food', 'Online Food', 'Online Food', 'ozan ltd şti aş', NULL, NULL, NULL, 'oznbyrk4@gmail.com', 'gmail', 'bayrakozan4@gmail.com', 'ozan6969', '578', NULL, NULL, NULL, '<h1>About us</h1>\r\n\r\n<p>Slow Food is a global, grassroots organization, founded in 1989 to&nbsp;<strong>prevent the disappearance of local food cultures and traditions, counteract the rise of fast life and combat people&rsquo;s dwindling interest in the food they eat</strong>, where it comes from and how our food choices affect the world around us.</p>\r\n\r\n<p>Since its beginnings, Slow Food has grown into a global movement involving&nbsp;<strong>millions of people&nbsp;<a href=\"https://www.slowfood.com/about-us/where-we-are/\">in over 160 countries</a>,</strong>&nbsp;working to ensure everyone has access to&nbsp;<a href=\"https://www.slowfood.com/about-us/our-philosophy/\">good, clean and fair food.</a></p>\r\n\r\n<p>Slow Food believes food is tied to many other aspects of life, including culture, politics, agriculture and the environment. Through our food choices we can collectively influence how food is cultivated, produced and distributed, and change the world as a result.</p>', '<p>Şirket UnvanıYemek Sepeti Elektronik İletişim Perakende Gıda Lojistik A.Ş.</p>\r\n\r\n<p>Sorumlu Kişiler: Ozan Bayrak</p>\r\n\r\n<p>Ticaret Sicil No444563</p>\r\n\r\n<p>Merkezin Bulunduğu Yer: T&Uuml;RKİYE / KARAB&Uuml;K</p>\r\n\r\n<p>Telefon No : +90 212 359 18 00</p>\r\n\r\n<p>Denetim Mercii: KPMG Bağımsız Denetim ve Serbest Muhasebeci Mali M&uuml;şavirlik A.Ş.</p>\r\n\r\n<p>Servis Sağlayıcı:TELLCOM</p>\r\n\r\n<p>KEP Adresi :yemeksepeti@hs01.kep.tr</p>\r\n\r\n<p>Tescilli Marka adı: Yemeksepeti</p>\r\n\r\n<p>Mersis No :0947045746800015</p>', NULL, 'true');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `surname`, `image`, `updated`, `status`, `created_at`, `updated_at`) VALUES
(22, 'ozi@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$Umt2YUVFV0F4QjFybmMuag$ML0LlFFO3C4llC3wv1aVubgXo4AP85J8W3g7bKrg4n0', 'OZAN', 'BAY', '690288ccd8259db38f21580925d8cc0d.jpeg', NULL, 'true', NULL, NULL),
(31, 'ozan@gmail.com', '[]', '$argon2i$v=19$m=65536,t=4,p=1$VFJLS2UxaDFJSi9FT3lZWg$fJ6Qt5A8PvmPcb2UrQLSnn+0ri5iSI22dVevWGq1pBQ', 'OZAN', 'BAYRAK', '57ac9053ceb88cf847b3fb6e49714ada.jpeg', NULL, 'true', NULL, NULL),
(32, 'ozann@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$Q2tKT0FqbUw5T1hwM2Ftdg$iJ981yACsKgmynr+0gqDQ3fJuuHDoECv5tojvJF7L+U', 'OZAN', 'BAYRAK', NULL, NULL, 'true', NULL, NULL);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D43829F712469DE2` (`category_id`);

--
-- Tablo için indeksler `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C53D045FBA8E87C4` (`food_id`);

--
-- Tablo için indeksler `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `FK_D43829F712469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Tablo kısıtlamaları `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045FBA8E87C4` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
