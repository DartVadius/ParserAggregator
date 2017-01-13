-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 13 2017 г., 12:17
-- Версия сервера: 5.5.50
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `agregator`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Articles`
--

CREATE TABLE IF NOT EXISTS `Articles` (
  `article_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `article_create_datetime` datetime NOT NULL,
  `link_to_article` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `Article_JSON` text NOT NULL,
  `sourse` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Articles_To_Tags`
--

CREATE TABLE IF NOT EXISTS `Articles_To_Tags` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1483723120),
('adminAccess', '1', 1483723122),
('user', '2', 1483729762);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/admin/*', 2, NULL, NULL, NULL, 1483722578, 1483722578),
('/post/*', 2, NULL, NULL, NULL, 1483722589, 1483722589),
('/rbac/*', 2, NULL, NULL, NULL, 1483722585, 1483722585),
('/rbac/route/*', 2, NULL, NULL, NULL, 1483722660, 1483722660),
('admin', 1, 'главный администратор', NULL, NULL, 1483722796, 1483722796),
('adminAccess', 2, 'Общий доступ в админку', NULL, NULL, 1483722933, 1483722933),
('updateOwnPost', 2, 'возможность обновлять только свои посты', 'Author', NULL, 1483731766, 1483731849),
('updatePost', 2, 'возможность обновить пост', NULL, NULL, 1483731724, 1483731724),
('user', 1, 'просмотр статей', NULL, NULL, 1483729742, 1483729742);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', '/admin/*'),
('admin', '/post/*'),
('user', '/post/*'),
('admin', '/rbac/*'),
('admin', '/rbac/route/*'),
('updateOwnPost', 'updatePost');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('Author', 'O:25:"app\\components\\AuthorRule":3:{s:4:"name";s:6:"Author";s:9:"createdAt";i:1483731663;s:9:"updatedAt";i:1483731663;}', 1483731663, 1483731663);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` tinyint(1) unsigned NOT NULL,
  `category_name` varchar(125) NOT NULL,
  `synonyms` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `comment_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `comment_parrent_id` int(11) NOT NULL,
  `comment_create_datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Images`
--

CREATE TABLE IF NOT EXISTS `Images` (
  `image_id` int(11) NOT NULL,
  `link_to_image` varchar(255) NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1483721769),
('m140506_102106_rbac_init', 1483721803),
('m140602_111327_create_menu_table', 1483721785),
('m160312_050000_create_user', 1483721785);

-- --------------------------------------------------------

--
-- Структура таблицы `posts_rss`
--

CREATE TABLE IF NOT EXISTS `posts_rss` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` int(10) unsigned NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `date` varchar(125) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=352 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts_rss`
--

INSERT INTO `posts_rss` (`id`, `title`, `category`, `source`, `link`, `date`) VALUES
(1, 'Прокуратура получила подтверждение смерти Жилина и закрыла дела', 1, 'news.liga.net', 'http://news.liga.net/news/politics/14511515-prokuratura_poluchila_podtverzhdenie_smerti_zhilina_i_zakryla_dela.htm', 'Thu, 05 Jan 2017 23:28:25 +0200'),
(2, 'Война России против Украины: последние события в Донбассе', 1, 'news.liga.net', 'http://news.liga.net/news/politics/14434915-voyna_rossii_protiv_ukrainy_poslednie_sobytiya_v_donbasse.htm', 'Thu, 05 Jan 2017 23:00:25 +0200'),
(3, 'Канада отправила в Донбасс 11 тонн гуманитарной помощи', 1, 'news.liga.net', 'http://news.liga.net/news/politics/14511511-kanada_otpravila_v_donbass_11_tonn_gumanitarnoy_pomoshchi.htm', 'Thu, 05 Jan 2017 22:47:10 +0200'),
(4, 'Таможенники предотвратили вывоз в Польшу старинных изданий: видео', 1, 'news.liga.net', 'http://news.liga.net/video/culture/14511507-tamozhenniki_predotvratili_vyvoz_v_polshu_starinnykh_izdaniy_video.htm', 'Thu, 05 Jan 2017 22:19:02 +0200'),
(5, 'Еще в двух областях ограничили движение фур из-за непогоды', 1, 'news.liga.net', 'http://news.liga.net/news/society/14511502-eshche_v_dvukh_oblastyakh_ogranichili_dvizhenie_fur_iz_za_nepogody.htm', 'Thu, 05 Jan 2017 21:29:55 +0200'),
(6, 'Заявление глав разведструктур США: Россия - главная угроза', 1, 'news.liga.net', 'http://news.liga.net/news/world/14511499-zayavlenie_glav_razvedstruktur_ssha_rossiya_glavnaya_ugroza.htm', 'Thu, 05 Jan 2017 21:27:52 +0200'),
(7, 'В Харькове столкнулись семь авто, есть пострадавшие: фото', 1, 'news.liga.net', 'http://news.liga.net/news/incident/14511496-v_kharkove_stolknulis_sem_avto_est_postradavshie_foto.htm', 'Thu, 05 Jan 2017 20:41:34 +0200'),
(8, 'США внесли сына бин Ладена в черный список террористов', 1, 'news.liga.net', 'http://news.liga.net/news/world/14511492-ssha_vnesli_syna_bin_ladena_v_chernyy_spisok_terroristov.htm', 'Thu, 05 Jan 2017 20:35:28 +0200'),
(9, 'Декоративные петухи, день рождения гуру и стрит-арт: фото дня', 1, 'news.liga.net', 'http://news.liga.net/photo/world/14511482-dekorativnye_petukhi_den_rozhdeniya_guru_i_strit_art_foto_dnya.htm', 'Thu, 05 Jan 2017 20:22:00 +0200'),
(10, 'Взрыв в Турции: среди жертв и пострадавших украинцев нет - МИД', 1, 'news.liga.net', 'http://news.liga.net/news/incident/14511477-vzryv_v_turtsii_sredi_zhertv_i_postradavshikh_ukraintsev_net_mid.htm', 'Thu, 05 Jan 2017 19:55:55 +0200'),
(11, 'Разведка: Кибератаки на США санкционированы Кремлем', 1, 'news.liga.net', 'http://news.liga.net/news/world/14502092-razvedka_kiberataki_na_ssha_sanktsionirovany_kremlem.htm', 'Thu, 05 Jan 2017 19:43:14 +0200'),
(12, 'Израильский комик пристыдил свою собаку за храп во сне: видео', 1, 'news.liga.net', 'http://news.liga.net/video/society/14492636-izrailskiy_komik_pristydil_svoyu_sobaku_za_khrap_vo_sne_video.htm', 'Thu, 05 Jan 2017 19:28:00 +0200'),
(13, 'В ближайшее время будет увеличен штат полиции', 1, 'news.liga.net', 'http://news.liga.net/news/society/14502086-v_blizhayshee_vremya_budet_uvelichen_shtat_politsii.htm', 'Thu, 05 Jan 2017 19:15:11 +0200'),
(14, 'В Закарпатской области сошла еще одна лавина - ГСЧС', 1, 'news.liga.net', 'http://news.liga.net/news/incident/14492704-v_zakarpatskoy_oblasti_soshla_eshche_odna_lavina_gschs.htm', 'Thu, 05 Jan 2017 19:11:35 +0200'),
(15, 'В Донбассе за сутки 14 обстрелов, один военный ранен - штаб', 1, 'news.liga.net', 'http://news.liga.net/news/incident/14492696-v_donbasse_za_sutki_14_obstrelov_odin_voennyy_ranen_shtab.htm', 'Thu, 05 Jan 2017 18:45:01 +0200'),
(16, 'Теракт в Измире: губернатор обвиняет Рабочую партию Курдистана', 1, 'news.liga.net', 'http://news.liga.net/news/incident/14492694-terakt_v_izmire_gubernator_obvinyaet_rabochuyu_partiyu_kurdistana.htm', 'Thu, 05 Jan 2017 18:40:12 +0200'),
(17, 'Для британской армии создают боевую лазерную установку', 1, 'news.liga.net', 'http://news.liga.net/news/world/14492688-dlya_britanskoy_armii_sozdayut_boevuyu_lazernuyu_ustanovku.htm', 'Thu, 05 Jan 2017 18:16:23 +0200'),
(18, 'Госпереворот в Турции: двое военных получили пожизненный срок', 1, 'news.liga.net', 'http://news.liga.net/news/world/14492682-gosperevorot_v_turtsii_dvoe_voennykh_poluchili_pozhiznennyy_srok.htm', 'Thu, 05 Jan 2017 18:11:00 +0200'),
(19, 'Пропажа старинных изданий во Львове: открыто производство', 1, 'news.liga.net', 'http://news.liga.net/news/culture/14492676-propazha_starinnykh_izdaniy_vo_lvove_otkryto_proizvodstvo.htm', 'Thu, 05 Jan 2017 17:59:36 +0200'),
(20, 'МИД проверяет наличие украинцев среди пострадавших в Измире', 1, 'news.liga.net', 'http://news.liga.net/news/world/14492670-mid_proveryaet_nalichie_ukraintsev_sredi_postradavshikh_v_izmire.htm', 'Thu, 05 Jan 2017 17:56:11 +0200'),
(21, 'Цветной город изо льда и снега появился в Китае: фоторепортаж', 1, 'news.liga.net', 'http://news.liga.net/photo/world/14492652-tsvetnoy_gorod_izo_lda_i_snega_poyavilsya_v_kitae_fotoreportazh.htm', 'Thu, 05 Jan 2017 17:42:00 +0200'),
(22, 'Первая атака в Сирии после начала перемирия: есть жертвы', 1, 'news.liga.net', 'http://news.liga.net/news/world/14492655-pervaya_ataka_v_sirii_posle_nachala_peremiriya_est_zhertvy.htm', 'Thu, 05 Jan 2017 17:28:37 +0200'),
(23, 'ДТП с журналистом: экс-чиновнику УЗ вынесли новый приговор', 1, 'news.liga.net', 'http://news.liga.net/news/incident/14492647-dtp_s_zhurnalistom_eks_chinovniku_uz_vynesli_novyy_prigovor.htm', 'Thu, 05 Jan 2017 17:21:41 +0200'),
(24, 'В Минздраве рассказали, как не пострадать от холода', 1, 'news.liga.net', 'http://news.liga.net/news/society/14492624-v_minzdrave_rasskazali_kak_ne_postradat_ot_kholoda.htm', 'Thu, 05 Jan 2017 16:58:11 +0200'),
(25, 'Теракт в турецком Измире: 11 раненых, ликвидированы 2 нападавших', 1, 'news.liga.net', 'http://news.liga.net/news/world/14492621-terakt_v_turetskom_izmire_11_ranenykh_likvidirovany_2_napadavshikh.htm', 'Thu, 05 Jan 2017 16:57:52 +0200'),
(26, 'Генштаб: Неслуживших выпускников военных кафедр призовут в ВСУ', 1, 'news.liga.net', 'http://news.liga.net/news/politics/14492617-genshtab_nesluzhivshikh_vypusknikov_voennykh_kafedr_prizovut_v_vsu.htm', 'Thu, 05 Jan 2017 16:53:03 +0200'),
(27, 'Лубкивский: Риторика Ле Пен изменится на посту президента', 1, 'news.liga.net', 'http://news.liga.net/news/politics/14492601-lubkivskiy_ritorika_le_pen_izmenitsya_na_postu_prezidenta.htm', 'Thu, 05 Jan 2017 16:19:12 +0200'),
(28, 'В турецком Измире у здания суда взорвалась заминированная машина', 1, 'news.liga.net', 'http://news.liga.net/news/world/14492590-v_turetskom_izmire_u_zdaniya_suda_vzorvalas_zaminirovannaya_mashina.htm', 'Thu, 05 Jan 2017 16:02:25 +0200'),
(29, 'В Киеве в результате стрельбы ранен иностранец - полиция', 1, 'news.liga.net', 'http://news.liga.net/news/capital/14492594-v_kieve_v_rezultate_strelby_ranen_inostranets_politsiya.htm', 'Thu, 05 Jan 2017 15:59:35 +0200'),
(30, 'Прокуратура Киева не разрешила застройку земли у Батыевой горы', 1, 'news.liga.net', 'http://news.liga.net/news/capital/14492586-prokuratura_kieva_ne_razreshila_zastroyku_zemli_u_batyevoy_gory.htm', 'Thu, 05 Jan 2017 15:57:00 +0200'),
(31, 'Баптистская церковь горела ночью в Черкассах, - ГСЧС. ФОТО', 1, 'censor.net.ua', 'http://censor.net.ua/photo_news/422296/baptistskaya_tserkov_gorela_nochyu_v_cherkassah_gschs_foto', 'Thu, 05 Jan 2017 23:31:41 +0200'),
(32, 'Путин решил вмешаться в выборы из-за бездействия США после агрессии РФ в Украине, - Маккейн', 1, 'censor.net.ua', 'http://censor.net.ua/news/422295/putin_reshil_vmeshatsya_v_vybory_izza_bezdeyistviya_ssha_posle_agressii_rf_v_ukraine_makkeyin', 'Thu, 05 Jan 2017 23:25:51 +0200'),
(33, 'Угнанный в Испании автомобиль выявлен при прохождении погранконтроля в Одесской области. ФОТО', 1, 'censor.net.ua', 'http://censor.net.ua/photo_news/422294/ugnannyyi_v_ispanii_avtomobil_vyyavlen_pri_prohojdenii_pogrankontrolya_v_odesskoyi_oblasti_foto', 'Thu, 05 Jan 2017 22:58:05 +0200'),
(34, 'В Минобороны разъяснили Закон относительно усовершенствования порядка прохождения военной службы. ВИДЕО', 1, 'censor.net.ua', 'http://censor.net.ua/video_news/422293/v_minoborony_razyasnili_zakon_otnositelno_usovershenstvovaniya_poryadka_prohojdeniya_voennoyi_slujby', 'Thu, 05 Jan 2017 22:55:47 +0200'),
(35, 'На сессии ПАСЕ в январе Украина потребует от России освободить незаконно удерживаемых украинцев, - Арьев', 1, 'censor.net.ua', 'http://censor.net.ua/news/422292/na_sessii_pase_v_yanvare_ukraina_potrebuet_ot_rossii_osvobodit_nezakonno_uderjivaemyh_ukraintsev_arev', 'Thu, 05 Jan 2017 22:25:33 +0200'),
(36, 'Украинский биатлонист Кильчицкий продает на аукционе лыжи, чтобы помочь армии', 1, 'censor.net.ua', 'http://censor.net.ua/news/422291/ukrainskiyi_biatlonist_kilchitskiyi_prodaet_na_auktsione_lyji_chtoby_pomoch_armii', 'Thu, 05 Jan 2017 22:17:37 +0200'),
(37, '"Фантом" задержал в Луганской области партию продуктов, которую планировали по реке доставить на оккупированную территорию. ФОТОрепортаж', 1, 'censor.net.ua', 'http://censor.net.ua/photo_news/422290/fantom_zaderjal_v_luganskoyi_oblasti_partiyu_produktov_kotoruyu_planirovali_po_reke_dostavit_na_okkupirovannuyu', 'Thu, 05 Jan 2017 22:07:34 +0200'),
(38, 'Минюст планирует открывать в тюрьмах магазины и выдать заключенным зарплатные банковские карты', 1, 'censor.net.ua', 'http://censor.net.ua/news/422289/minyust_planiruet_otkryvat_v_tyurmah_magaziny_i_vydat_zaklyuchennym_zarplatnye_bankovskie_karty', 'Thu, 05 Jan 2017 21:51:34 +0200'),
(39, 'Институт сердца не может самостоятельно открывать филиалы в регионах, - Минздрав', 1, 'censor.net.ua', 'http://censor.net.ua/news/422288/institut_serdtsa_ne_mojet_samostoyatelno_otkryvat_filialy_v_regionah_minzdrav', 'Thu, 05 Jan 2017 21:29:09 +0200'),
(40, 'НАБУ завершило досудебное расследование по делу о махинация при тендерных закупках для "Укрзализныци", - Холодницкий', 1, 'censor.net.ua', 'http://censor.net.ua/news/422287/nabu_zavershilo_dosudebnoe_rassledovanie_po_delu_o_mahinatsiya_pri_tendernyh_zakupkah_dlya_ukrzaliznytsi', 'Thu, 05 Jan 2017 21:28:12 +0200'),
(41, 'Чубаров о статье Пинчука: Он пытается привлечь внимание Трампа, поскольку рассчитывал на победу Клинтон. ВИДЕО', 1, 'censor.net.ua', 'http://censor.net.ua/video_news/422286/chubarov_o_state_pinchuka_on_pytaetsya_privlech_vnimanie_trampa_poskolku_rasschityval_na_pobedu_klinton', 'Thu, 05 Jan 2017 21:05:41 +0200'),
(42, 'В связи с ухудшением погодных условий 6 января ограничивается движение грузовых автомобилей в Одесской и Николаевской областях', 1, 'censor.net.ua', 'http://censor.net.ua/news/422285/v_svyazi_s_uhudsheniem_pogodnyh_usloviyi_6_yanvarya_ogranichivaetsya_dvijenie_gruzovyh_avtomobileyi', 'Thu, 05 Jan 2017 21:00:01 +0200'),
(43, 'Теракт в Турции: двое погибших, более 10 человек ранены, украинцы не пострадали. ФОТО', 1, 'censor.net.ua', 'http://censor.net.ua/photo_news/422283/terakt_v_turtsii_dvoe_pogibshih_bolee_10_chelovek_raneny_ukraintsy_ne_postradali_foto', 'Thu, 05 Jan 2017 20:10:59 +0200'),
(44, 'Кибератака во время президентских выборов была санкционирована высшим руководством России, - глава разведки США Клэппер', 1, 'censor.net.ua', 'http://censor.net.ua/news/422282/kiberataka_vo_vremya_prezidentskih_vyborov_byla_sanktsionirovana_vysshim_rukovodstvom_rossii_glava_razvedki', 'Thu, 05 Jan 2017 19:51:08 +0200'),
(45, 'Должен быть проведен аудит международных закупок лекарств в 2015-16 гг, - Розенко', 1, 'censor.net.ua', 'http://censor.net.ua/news/422281/doljen_byt_proveden_audit_mejdunarodnyh_zakupok_lekarstv_v_201516_gg_rozenko', 'Thu, 05 Jan 2017 19:20:14 +0200'),
(46, 'Таможенники Львовщины предотвратили вывоз в Польшу 68 старинных книг. ВИДЕО', 1, 'censor.net.ua', 'http://censor.net.ua/video_news/422280/tamojenniki_lvovschiny_predotvratili_vyvoz_v_polshu_68_starinnyh_knig_video', 'Thu, 05 Jan 2017 19:01:28 +0200'),
(47, 'Дополнительный набор в полицию начнется в конце января, - МВД', 1, 'censor.net.ua', 'http://censor.net.ua/news/422279/dopolnitelnyyi_nabor_v_politsiyu_nachnetsya_v_kontse_yanvarya_mvd', 'Thu, 05 Jan 2017 18:43:53 +0200'),
(48, 'Конгресс украинцев Канады прислал 11 тонн гуманитарной помощи для Донбасса, - МИД', 1, 'censor.net.ua', 'http://censor.net.ua/news/422278/kongress_ukraintsev_kanady_prislal_11_tonn_gumanitarnoyi_pomoschi_dlya_donbassa_mid', 'Thu, 05 Jan 2017 18:37:39 +0200'),
(49, 'Начат процесс ликвидации "Всеукраинской службы "Украинское телевидение и радиовещание"', 1, 'censor.net.ua', 'http://censor.net.ua/news/422277/nachat_protsess_likvidatsii_vseukrainskoyi_slujby_ukrainskoe_televidenie_i_radioveschanie', 'Thu, 05 Jan 2017 18:32:04 +0200'),
(50, 'С начала суток зафиксировано 14 обстрелов позиций ВСУ, один военнослужащий ранен, - пресс-центр штаба АТО', 1, 'censor.net.ua', 'http://censor.net.ua/news/422276/s_nachala_sutok_zafiksirovano_14_obstrelov_pozitsiyi_vsu_odin_voennoslujaschiyi_ranen_presstsentr_shtaba', 'Thu, 05 Jan 2017 18:19:01 +0200'),
(51, 'Нацсовет заявил о выдаче "1+1" лицензии на эфирное вещание: "Ждем подтверждения, что бенефициарные собственники не изменились"', 1, 'censor.net.ua', 'http://censor.net.ua/news/422275/natssovet_zayavil_o_vydache_11_litsenzii_na_efirnoe_veschanie_jdem_podtverjdeniya_chto_benefitsiarnye', 'Thu, 05 Jan 2017 18:18:33 +0200'),
(52, '"Украина должна иметь свою позицию по завершению войны и деоккупации", - Сыроид о заявлениях Пинчука и Елисеева', 1, 'censor.net.ua', 'http://censor.net.ua/news/422274/ukraina_doljna_imet_svoyu_pozitsiyu_po_zaversheniyu_voyiny_i_deokkupatsii_syroid_o_zayavleniyah_pinchuka', 'Thu, 05 Jan 2017 18:10:12 +0200'),
(53, 'Радиационный фон вокруг четвертого энергоблока ЧАЭС после установки Арки упал в два раза', 1, 'censor.net.ua', 'http://censor.net.ua/news/422273/radiatsionnyyi_fon_vokrug_chetvertogo_energobloka_chaes_posle_ustanovki_arki_upal_v_dva_raza', 'Thu, 05 Jan 2017 18:00:48 +0200'),
(54, 'Полиция открыла дело по факту пропажи старинных книг из Львовской галереи искусств', 1, 'censor.net.ua', 'http://censor.net.ua/news/422272/politsiya_otkryla_delo_po_faktu_propaji_starinnyh_knig_iz_lvovskoyi_galerei_iskusstv', 'Thu, 05 Jan 2017 17:59:02 +0200'),
(55, 'Тодуров – Минздраву: "80% тендеров точно не проведены"', 1, 'censor.net.ua', 'http://censor.net.ua/news/422271/todurov_minzdravu_80_tenderov_tochno_ne_provedeny', 'Thu, 05 Jan 2017 17:54:05 +0200'),
(56, 'Трамп выбрал кандидата на пост директора национальной разведки США', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/06/trump_intelligence/', 'Fri, 06 Jan 2017 00:24:00 +0300'),
(57, 'США поддержали проведение переговоров по Сирии в Астане', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/kerry_astana/', 'Thu, 05 Jan 2017 23:19:00 +0300'),
(58, 'Участникам акции в Петербурге пригрозили судом за блокировку платной дороги', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/piter/', 'Thu, 05 Jan 2017 22:49:00 +0300'),
(59, 'Керри констатировал успех перезагрузки отношений США и России', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/kerry_/', 'Thu, 05 Jan 2017 21:36:00 +0300'),
(60, 'Отец предполагаемого убийцы журналиста в Ингушетии признался в преступлении', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/father_love/', 'Thu, 05 Jan 2017 21:00:00 +0300'),
(61, 'Россиянка Иванова завоевала серебро на ЧЕ по санному спорту', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/ivanovasilver/', 'Thu, 05 Jan 2017 20:57:10 +0300'),
(62, 'Обама рассказал о заложенном им новом фундаменте для США', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/fundament/', 'Thu, 05 Jan 2017 20:23:00 +0300'),
(63, 'Разведка США обвинила Кремль в причастности к хакерским атакам', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/cyber_threat/', 'Thu, 05 Jan 2017 19:34:00 +0300'),
(64, 'Президент «Баварии» решил штрафовать легионеров за незнание немецкого языка', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/strafheness/', 'Thu, 05 Jan 2017 19:22:00 +0300'),
(65, 'Коля Лукашенко сыграл льва Алекса из «Мадагаскара»', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/levkolya/', 'Thu, 05 Jan 2017 19:09:00 +0300'),
(66, 'Художница сделала фильм из песка про Доктора Лизу', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/film/', 'Thu, 05 Jan 2017 18:57:00 +0300'),
(67, 'Сын тайваньского чиновника позвал полсотни стриптизерш на похороны отца', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/fun_eral/', 'Thu, 05 Jan 2017 18:37:00 +0300'),
(68, 'У здания суда в Измире взорвался автомобиль', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/izmir_attack/', 'Thu, 05 Jan 2017 18:35:00 +0300'),
(69, 'Иностранцев заподозрили в сексуальных домогательствах к австрийкам в Новый год', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/innsbruck/', 'Thu, 05 Jan 2017 18:30:00 +0300'),
(70, 'Украине предрекли превращение в логистическое захолустье', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/zaholustye/', 'Thu, 05 Jan 2017 18:09:00 +0300'),
(71, 'Медведев ступил на лед и пожалел об отсутствии коньков', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/skates/', 'Thu, 05 Jan 2017 17:47:00 +0300'),
(72, 'Россияне остались без медалей в спринте на этапе КМ по биатлону', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/russianbiathlonworldcup/', 'Thu, 05 Jan 2017 17:41:00 +0300'),
(73, 'При теракте в сирийском городе Джебла погибли девять человек', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/jablah_attack/', 'Thu, 05 Jan 2017 17:38:00 +0300'),
(74, 'Авиакомпания опровергла сближение пассажирского лайнера и самолета НАТО', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/avrora/', 'Thu, 05 Jan 2017 17:23:00 +0300'),
(75, 'У Порошенко ответили на идею уступить России по Крыму и Донбассу', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/otvetpinchuku/', 'Thu, 05 Jan 2017 16:50:00 +0300'),
(76, 'В США ковбой заарканил сбежавшего бычка с капота полицейской машины', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/real_mccoy/', 'Thu, 05 Jan 2017 16:45:00 +0300'),
(77, 'После пропажи рыболовецкого судна в Финском заливе возбудили уголовное дело', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/sudno/', 'Thu, 05 Jan 2017 16:35:00 +0300'),
(78, 'Курс доллара впервые за полтора года упал ниже 60 рублей', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/ruble_up/', 'Thu, 05 Jan 2017 16:17:00 +0300'),
(79, 'Боец Мирзаев опознал одного из нападавших', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/mirzaev/', 'Thu, 05 Jan 2017 16:06:00 +0300'),
(80, 'Москалькова рассказала о местонахождении Дадина', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/dadin/', 'Thu, 05 Jan 2017 16:01:00 +0300'),
(81, 'Львовские музейщики лишились книг на 10 миллионов долларов', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/propazha/', 'Thu, 05 Jan 2017 15:32:00 +0300'),
(82, 'Охранник Букингемского дворца едва не выстрелил в Елизавету II', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/thequeen/', 'Thu, 05 Jan 2017 15:30:00 +0300'),
(83, 'Храпящий спаниель удивился собственному храпу', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/dog_snoring/', 'Thu, 05 Jan 2017 15:25:00 +0300'),
(84, 'В Японии продали второго по стоимости тунца с начала XXI века', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/super_fish/', 'Thu, 05 Jan 2017 15:17:00 +0300'),
(85, 'Рецидивист Паровоз зарубил четырех человек топором на Урале', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/killer/', 'Thu, 05 Jan 2017 15:04:00 +0300'),
(86, 'Милонов решил законодательно защитить национальную гордость России', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/zashitnik/', 'Thu, 05 Jan 2017 14:56:00 +0300'),
(87, 'Власти Крыма пригласили окунуться в атмосферу «Викинга»', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/viking/', 'Thu, 05 Jan 2017 14:55:00 +0300'),
(88, 'В Минске заявили об отсутствии согласия Москвы по тарифам на транзит нефти', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/tarif/', 'Thu, 05 Jan 2017 14:37:00 +0300'),
(89, 'В словацкого мотогонщика на ралли «Дакар-2017» ударила молния', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/slovakmotogon/', 'Thu, 05 Jan 2017 14:03:00 +0300'),
(90, 'Порошенко отказался от украинского ланча в Давосе из-за статьи в WSJ', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/poroshenko/', 'Thu, 05 Jan 2017 13:58:00 +0300'),
(91, 'Два водителя скорой помощи погибли в ДТП на Ярославском шоссе', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/twodead/', 'Thu, 05 Jan 2017 13:52:00 +0300'),
(92, 'В Госдуме посоветовали Украине прекратить истерить из-за Черноморского флота', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/dontcryforme/', 'Thu, 05 Jan 2017 13:32:00 +0300'),
(93, 'Ферги снялась в клипе в футболке с Пушкиным', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/fergie_pushkin/', 'Thu, 05 Jan 2017 13:24:00 +0300'),
(94, 'Турция усомнилась в необходимости присутствия сил коалиции на авиабазе Инджирлик', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/no_us_planes/', 'Thu, 05 Jan 2017 13:18:00 +0300'),
(95, 'Посадка Ту-154 с отказавшим двигателем в Якутии попала на видео', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/tu/', 'Thu, 05 Jan 2017 13:15:00 +0300'),
(96, 'Газета и соцсети сделали Обаму стамбульским террористом', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/obama/', 'Thu, 05 Jan 2017 12:54:00 +0300'),
(97, 'Под Оренбургом загорелась нефтяная скважина', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/skvazhina/', 'Thu, 05 Jan 2017 12:43:00 +0300'),
(98, '«Анжи» возглавил «женский» тренер', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/grigoriyan/', 'Thu, 05 Jan 2017 12:39:00 +0300'),
(99, 'В Нигерии ликвидировали трех юных террористок-смертниц', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/suicide_haram/', 'Thu, 05 Jan 2017 12:31:00 +0300'),
(100, 'Полицейских в Пыть-Яхе заподозрили в пытках задержанных', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/police/', 'Thu, 05 Jan 2017 12:26:00 +0300'),
(101, 'Башкирский школьник погиб при попытке устроить огненное шоу', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/child/', 'Thu, 05 Jan 2017 11:44:00 +0300'),
(102, 'Фильм о допинге в России с участием Родченкова покажут на кинофестивале Sundance', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/rodchenkovthriller/', 'Thu, 05 Jan 2017 11:40:34 +0300'),
(103, 'Американский бомбардировщик В-52 потерял двигатель в полете', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/ibelieveicanfly/', 'Thu, 05 Jan 2017 11:31:29 +0300'),
(104, 'Тренер молодежной сборной России по хоккею прокомментировал поражение от США', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/proigralirussia/', 'Thu, 05 Jan 2017 11:03:33 +0300'),
(105, 'Бухгалтер посольства Казахстана в Минске украл 700 тысяч долларов', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/accountant/', 'Thu, 05 Jan 2017 10:58:00 +0300'),
(106, 'Самолет НАТО опасно сблизился с российским лайнером в районе Курил', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/nato/', 'Thu, 05 Jan 2017 10:55:00 +0300'),
(107, 'Появилось видео лучших моментов полуфинала молодежного ЧМ по хоккею Россия — США', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/russiausavideo/', 'Thu, 05 Jan 2017 10:44:00 +0300'),
(108, 'Строители Крымского моста завершили половину свайных работ', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/most/', 'Thu, 05 Jan 2017 10:18:00 +0300'),
(109, 'Трамп взял в Белый дом трижды уволенную участницу своего телешоу', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/manigault/', 'Thu, 05 Jan 2017 09:56:00 +0300'),
(110, 'Китай вложит в возобновляемые источники энергии 360 миллиардов долларов', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/china/', 'Thu, 05 Jan 2017 08:52:39 +0300'),
(111, 'Закрытый на сутки из-за ЧП с A321 аэропорт Калининграда возобновил работу', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/open/', 'Thu, 05 Jan 2017 08:19:43 +0300'),
(112, 'В ДТП с участием двух автобусов на Алтае пострадали 29 человек', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/altay_dtp/', 'Thu, 05 Jan 2017 07:56:00 +0300'),
(113, 'Сенатор упрекнул Трампа в нежелании видеть угрозы со стороны России', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/graham/', 'Thu, 05 Jan 2017 07:37:00 +0300'),
(114, 'Ученые локализовали источник «инопланетного» сигнала', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/frb1211023/', 'Thu, 05 Jan 2017 07:03:00 +0300'),
(115, 'Директор ЦРУ понадеялся на улучшение отношений с Россией', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/ostapa_poneslo/', 'Thu, 05 Jan 2017 06:04:00 +0300'),
(116, 'СМИ узнали о планах Трампа реформировать американскую разведку', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/trump_odni/', 'Thu, 05 Jan 2017 05:33:53 +0300'),
(117, 'На Украине признали риск прекращения транзита российского газа', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/naftobezgaz/', 'Thu, 05 Jan 2017 04:53:28 +0300'),
(118, 'Взломавший почту Клинтон хакер назвал истерией обвинения России в кибератаках', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/guccifer/', 'Thu, 05 Jan 2017 04:31:23 +0300'),
(119, 'Белоруссия поднимет тарифы на транзит нефти', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/neft/', 'Thu, 05 Jan 2017 04:03:00 +0300'),
(120, 'Умер основатель ансамбля «Поющие гитары» Анатолий Васильев', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/gytary/', 'Thu, 05 Jan 2017 03:34:33 +0300'),
(121, 'Псаки приняла участие в мастер-классе для будущего пресс-секретаря Белого дома', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/psaki_spicer/', 'Thu, 05 Jan 2017 03:12:00 +0300'),
(122, 'Бывшего премьер-министра Косово арестовали во Франции по запросу Сербии', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/kosovo/', 'Thu, 05 Jan 2017 02:29:00 +0300'),
(123, 'Пресс-секретарь Ле Пен прокомментировал реакцию Украины на ее слова о Крыме', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/ukrfr/', 'Thu, 05 Jan 2017 01:58:52 +0300'),
(124, 'Сборная России проиграла команде США в полуфинале молодежного ЧМ по хоккею', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/icehoccei/', 'Thu, 05 Jan 2017 01:54:00 +0300'),
(125, 'Военные эвакуировали выкатившийся за пределы ВПП в Калининграде A321', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/a321/', 'Thu, 05 Jan 2017 01:28:00 +0300'),
(126, 'В Москве объявлено штормовое предупреждение', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/05/storm/', 'Thu, 05 Jan 2017 00:35:00 +0300'),
(127, 'Продюсеры «Викинга» объяснили главный посыл картины', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/viking/', 'Thu, 05 Jan 2017 00:19:00 +0300'),
(128, 'Белый дом затруднился предоставить доказательства участия России в кибератаках', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/earnest/', 'Wed, 04 Jan 2017 23:36:08 +0300'),
(129, 'Украина анонсировала новые ракетные стрельбы вблизи Крыма', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/prashya_i_katapulta/', 'Wed, 04 Jan 2017 23:04:00 +0300'),
(130, 'Тягачи Балтфлота приступили к эвакуации А-321 в Калининграде', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/evacuation/', 'Wed, 04 Jan 2017 22:38:00 +0300'),
(131, 'При стрельбе у ресторана в Стамбуле пострадали два человека', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/istanbulrestaurant/', 'Wed, 04 Jan 2017 22:22:00 +0300'),
(132, 'Пенс назвал первое решение Трампа на посту президента США', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/obamanocare/', 'Wed, 04 Jan 2017 21:51:00 +0300'),
(133, 'Американский авианосец отправится в западную часть Тихого океана', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/vinson/', 'Wed, 04 Jan 2017 21:36:00 +0300'),
(134, 'Российский бадминтонист установил мировой рекорд по скорости полета волана', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/ivanov1/', 'Wed, 04 Jan 2017 21:06:17 +0300'),
(135, 'Китайская авианосная группа провела учения в Южно-Китайском море', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/liaoning/', 'Wed, 04 Jan 2017 20:52:00 +0300'),
(136, 'Бекхэм повздорил с бывшим руководителем команды «Формулы-1» на вечеринке', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/becks/', 'Wed, 04 Jan 2017 20:35:28 +0300'),
(137, 'Додон сообщил о готовности к компромиссам с Приднестровьем', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/nicetomeetyou/', 'Wed, 04 Jan 2017 20:27:00 +0300'),
(138, 'У подмосковной пенсионерки изъяли килограмм героина', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/heroine/', 'Wed, 04 Jan 2017 20:13:34 +0300'),
(139, 'Colab предложил спортсменам не мыть голову', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/dryshamp/', 'Wed, 04 Jan 2017 19:55:00 +0300'),
(140, 'Более 100 человек пострадали при сходе поезда с рельсов в США', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/usatrain/', 'Wed, 04 Jan 2017 19:51:00 +0300'),
(141, 'В соцсетях кота Ларри заподозрили в поддержке Brexit', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/larrybrexit/', 'Wed, 04 Jan 2017 19:50:00 +0300'),
(142, 'Умер первый командир отряда пилотов космического корабля «Буран»', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/volk/', 'Wed, 04 Jan 2017 19:22:00 +0300'),
(143, 'Из-за выкатившегося в Калининграде за пределы ВПП самолета возбудили дело', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/kaliningrad/', 'Wed, 04 Jan 2017 18:46:00 +0300'),
(144, 'Трансгендерный отчим Ким Кардашьян запустил линию косметики', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/jennercosmetics/', 'Wed, 04 Jan 2017 18:35:00 +0300'),
(145, 'Боец Чеченов рассказал о состоянии бойца Мирзаева после нападения', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/rasul/', 'Wed, 04 Jan 2017 18:22:00 +0300'),
(146, 'Меланию Трамп сравнили с женой Гитлера в Instagram Dolce & Gabbana', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/trampdolgabb/', 'Wed, 04 Jan 2017 18:15:00 +0300'),
(147, 'Психологи предложили ввести курс сексологии для младших школьников', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/prosveschenie/', 'Wed, 04 Jan 2017 18:08:00 +0300'),
(148, 'К эвакуации А-321 в Калининграде попробуют привлечь технику Балтфлота', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/balticfleet/', 'Wed, 04 Jan 2017 18:02:00 +0300'),
(149, 'Малышка из семьи республиканца увернулась от поцелуя вице-президента США', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/biden/', 'Wed, 04 Jan 2017 17:49:00 +0300'),
(150, 'Финского депутата оштрафуют на 1160 евро за разжигание межнациональной розни', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/strafe/', 'Wed, 04 Jan 2017 17:45:00 +0300'),
(151, 'Россияне оказались среди подозреваемых по делу о теракте в Стамбуле', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/suspects/', 'Wed, 04 Jan 2017 17:45:00 +0300'),
(152, 'Открытие калининградского аэропорта перенесли еще на два часа', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/closed/', 'Wed, 04 Jan 2017 16:55:00 +0300'),
(153, 'Участник съемок «Титаника» опроверг новую версию гибели судна', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/vsebylonetak/', 'Wed, 04 Jan 2017 16:45:00 +0300'),
(154, 'Марин Ле Пен призвала отказаться от евро ради экю', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/ecu/', 'Wed, 04 Jan 2017 16:37:00 +0300'),
(155, 'Фаррелл Уильямс снялся в рекламе женских сумок Chanel', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/williamsbag/', 'Wed, 04 Jan 2017 16:34:00 +0300'),
(156, 'Устюгов одержал четвертую победу подряд на «Тур де Ски»', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/ustyg/', 'Wed, 04 Jan 2017 16:31:00 +0300'),
(157, 'Добившего палестинца израильского солдата признали виновным в убийстве', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/azaria/', 'Wed, 04 Jan 2017 15:50:00 +0300'),
(158, 'Зверев обыграл Федерера на турнире в Австралии', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/zverev/', 'Wed, 04 Jan 2017 15:42:00 +0300'),
(159, 'В аэропорту Калининграда не нашли техники для эвакуации выехавшего за ВПП борта', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/notech/', 'Wed, 04 Jan 2017 15:35:00 +0300'),
(160, 'Путин поручил повысить эффективность капремонта', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/kapremont/', 'Wed, 04 Jan 2017 15:35:00 +0300'),
(161, 'Водитель снес остановку в Витебске и оголился перед гаишниками', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/vitebsk/', 'Wed, 04 Jan 2017 15:15:00 +0300'),
(162, 'В Минобороны России ответили главе ЦРУ на слова о выжженной земле', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/konashenkov/', 'Wed, 04 Jan 2017 15:12:00 +0300'),
(163, 'Россиянам вернут «Кремлевского мишку»', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/bear/', 'Wed, 04 Jan 2017 15:00:00 +0300'),
(164, 'В Китае мужчина с ножом напал на детский сад', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/china_maniak/', 'Wed, 04 Jan 2017 14:52:00 +0300'),
(165, 'Бывший глава ВФЛА назвал унизительным выступление россиян под нейтральным флагом', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/balah/', 'Wed, 04 Jan 2017 14:36:00 +0300'),
(166, 'Французские многоцелевые подлодки в 2016 году провели в море 1000 суток', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/longway/', 'Wed, 04 Jan 2017 14:33:00 +0300'),
(167, 'Сборы «Викинга» составили около 700 миллионов рублей', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/kinosbor/', 'Wed, 04 Jan 2017 14:15:00 +0300'),
(168, 'ExxonMobil назначила Тиллерсону пенсию в 180 миллионов долларов', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/gde_nakopitelnaya_chast/', 'Wed, 04 Jan 2017 13:55:00 +0300'),
(169, 'Открытие калининградского аэропорта отложили до 15 часов по Москве', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/wheel/', 'Wed, 04 Jan 2017 13:41:00 +0300'),
(170, 'Еврокомиссар наставила лайков порноснимкам из-за хакеров', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/pornohack/', 'Wed, 04 Jan 2017 13:40:00 +0300'),
(171, 'Сестры Уильямс покинули турнир в Окленде после второго круга', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/sserena/', 'Wed, 04 Jan 2017 13:32:00 +0300'),
(172, 'Активист сообщил о задержании в Москве участников пикетов в поддержку Дадина', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/zaderzhaniemsk/', 'Wed, 04 Jan 2017 13:14:00 +0300'),
(173, 'В Петербурге поймали мужчину с пулеметом «Максим»', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/strangewalker/', 'Wed, 04 Jan 2017 13:12:00 +0300'),
(174, 'СБУ попросила МИД запретить Марин Ле Пен въезд из-за Крыма', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/nonlepen/', 'Wed, 04 Jan 2017 13:11:00 +0300'),
(175, 'Определена дата начала переговоров сирийского правительства и оппозиции в Астане', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/cavusoglu/', 'Wed, 04 Jan 2017 12:57:00 +0300'),
(176, 'Директор ЦРУ обвинил Россию в применении тактики выжженной земли в Сирии', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/brennan/', 'Wed, 04 Jan 2017 12:54:00 +0300'),
(177, 'WikiLeaks даст 20 тысяч долларов за сведения о документах в Белом доме', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/20thousandsdeadoralive/', 'Wed, 04 Jan 2017 12:46:00 +0300'),
(178, 'Названа самая безопасная авиакомпания 2016 года', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/aviasafety/', 'Wed, 04 Jan 2017 12:13:00 +0300'),
(179, 'В Турции анонсировали визит российской делегации для обсуждения Сирии', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/syria_talks/', 'Wed, 04 Jan 2017 12:10:00 +0300'),
(180, 'Четверо болельщиков «Челси» получили условные сроки за расизм', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/fansmetr/', 'Wed, 04 Jan 2017 12:03:00 +0300'),
(181, 'Работу авиации «Адмирала Кузнецова» показали на видео', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/krasota/', 'Wed, 04 Jan 2017 11:57:00 +0300'),
(182, 'Жителям ОАЭ запретили держать дома диких зверей', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/no_wild_animals_pls/', 'Wed, 04 Jan 2017 11:20:00 +0300'),
(183, 'Человечеству оставили 100 дней на случай зомби-апокалипсиса', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/imafraid/', 'Wed, 04 Jan 2017 10:59:00 +0300'),
(184, 'В результате пожара в китайском доме престарелых погибли семь человек', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/fire_china/', 'Wed, 04 Jan 2017 10:37:00 +0300'),
(185, 'Пихлер призвал отстранить россиян от зимней Олимпиады 2018 года', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/pikhpikh/', 'Wed, 04 Jan 2017 09:35:00 +0300'),
(186, 'Аэропорт Калининграда закрыт из-за инцидента с пассажирским самолетом', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/hrabrovo_zakryt/', 'Wed, 04 Jan 2017 08:43:00 +0300'),
(187, 'Электричка насмерть сбила мужчину в Подмосковье', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/sbila_nasmert_electrichka_podm/', 'Wed, 04 Jan 2017 08:14:00 +0300'),
(188, 'Журналист заявил об истинной причине крушения «Титаника»', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/istinnaya_gibel_titanika/', 'Wed, 04 Jan 2017 07:35:00 +0300'),
(189, 'Очевидцы сняли на видео выкатившийся за ВПП пассажирский авиалайнер', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/video_samolet_kaliningrad/', 'Wed, 04 Jan 2017 07:01:00 +0300'),
(190, 'Трампа озадачил перенос брифинга спецслужб по кибератакам на США', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/doklad_specsluzhb/', 'Wed, 04 Jan 2017 06:36:00 +0300'),
(191, '150 заключенных сбежали после вооруженного нападения на филиппинскую тюрьму', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/napadenie_turma_philippiny/', 'Wed, 04 Jan 2017 05:55:00 +0300'),
(192, 'СМИ узнали о планах четы Клинтон присутствовать на инаугурации Трампа', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/clintomy_budut_u_trumpa/', 'Wed, 04 Jan 2017 05:23:00 +0300'),
(193, 'Следователи начали проверку после ЧП с авиалайнером A321 в Калининграде', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/proverka_airbus_kaliningrad/', 'Wed, 04 Jan 2017 04:29:00 +0300'),
(194, 'Трамп объявил дату своей первой большой пресс-конференции', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/trump_press_conf/', 'Wed, 04 Jan 2017 03:57:00 +0300'),
(195, 'Серийного убийцу Чарльза Мэнсона госпитализировали из тюрьмы', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/mensona_uvezli_iz_turimy/', 'Wed, 04 Jan 2017 03:34:00 +0300'),
(196, '50-летняя Джанет Джексон родила первенца', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/janet_jeckson_rodila_perventsa/', 'Wed, 04 Jan 2017 02:35:00 +0300'),
(197, 'В Сенат подали проект резолюции об отмене Obamacare', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/resolution_otmena_obama_care/', 'Wed, 04 Jan 2017 02:11:00 +0300'),
(198, 'Пассажирский самолет выкатился за полосу при посадке в Калининграде', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/04/a321_vykatilsya_kaliningrad/', 'Wed, 04 Jan 2017 01:17:00 +0300'),
(199, 'Белый дом назвал причину отказа от введения санкций против Путина', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/net_sankciy_protiv_putina/', 'Wed, 04 Jan 2017 00:05:00 +0300'),
(200, 'В посольстве США подтвердили получение 35 приглашений в Кремль на елку', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/pos_usa_poluchili_bilety_na_elku/', 'Tue, 03 Jan 2017 23:26:00 +0300'),
(201, 'IAAF отказалась предоставить России информацию о фигурантах доклада Макларена', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/iaafc/', 'Tue, 03 Jan 2017 23:06:00 +0300'),
(202, 'Glencore объявил о закрытии сделки по акциям «Роснефти»', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/glancore_zakryl_sdelku/', 'Tue, 03 Jan 2017 22:57:00 +0300'),
(203, 'Газета сообщила о проникновении в Европу главаря ИГ с 400 боевиками', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/400_boevikov_ig_i_glavar/', 'Tue, 03 Jan 2017 22:11:00 +0300'),
(204, 'В IAAF отреагировали на предложение аннулировать все легкоатлетические рекорды', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/deski/', 'Tue, 03 Jan 2017 21:52:28 +0300'),
(205, 'Трое сотрудников минсоцразвития Саратовской области погибли в ДТП', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/troe_monsocrazv_so_pogibli/', 'Tue, 03 Jan 2017 21:35:00 +0300'),
(206, 'Ford передумал инвестировать 1,6 миллиарда долларов в мексиканский завод', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/ford/', 'Tue, 03 Jan 2017 20:51:00 +0300'),
(207, 'Российский лыжник Устюгов одержал победу в скиатлоне на «Тур де Ски»', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/skipass/', 'Tue, 03 Jan 2017 20:25:00 +0300'),
(208, 'Литва отказалась выдать России бывшего главу антитеррористического центра Грузии', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/zurab/', 'Tue, 03 Jan 2017 20:14:00 +0300'),
(209, 'Посол Великобритании при ЕС досрочно подал в отставку', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/before_brexit/', 'Tue, 03 Jan 2017 19:36:00 +0300'),
(210, 'Литва подтвердила размещение военного спецназа США', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/usa/', 'Tue, 03 Jan 2017 19:16:00 +0300'),
(211, 'Промоутер Стиверна рассказал о потерях из-за отмененного боя с Поветкиным', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/doni/', 'Tue, 03 Jan 2017 19:00:00 +0300'),
(212, 'В СБУ пообещали наказать Ле Пен за слова о крымском референдуме', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/tkachuk/', 'Tue, 03 Jan 2017 18:48:17 +0300'),
(213, 'Россия и Турция зафиксировали нарушения перемирия в Сирии', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/narusheniya/', 'Tue, 03 Jan 2017 18:19:00 +0300'),
(214, 'Додон лишил бывшего президента Румынии молдавского гражданства', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/dodon/', 'Tue, 03 Jan 2017 18:06:00 +0300'),
(215, 'На Украине двух братьев-израильтян заподозрили в осквернении распятия', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/israel_ukraine/', 'Tue, 03 Jan 2017 17:52:00 +0300'),
(216, 'Глава международной лыжной федерации выступил против отстранения россиян', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/skifed/', 'Tue, 03 Jan 2017 17:38:00 +0300'),
(217, 'Украина запретила первый в 2017 году российский сериал', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/factor/', 'Tue, 03 Jan 2017 17:28:00 +0300'),
(218, 'Трамп потребовал от General Motors платить пошлины за машины мексиканской сборки', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/trump/', 'Tue, 03 Jan 2017 17:10:00 +0300'),
(219, 'Из живота вьетнамца извлекли забытые 18 лет назад ножницы', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/lost_scissors/', 'Tue, 03 Jan 2017 17:00:05 +0300'),
(220, 'Украинский министр призвал перевезти в Киев прах Бандеры и Петлюры', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/ashestoashes/', 'Tue, 03 Jan 2017 16:37:14 +0300'),
(221, '«Майн Кампф» стала бестселлером в Германии', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/mein_kampf/', 'Tue, 03 Jan 2017 16:21:12 +0300'),
(222, 'Мировые рекорды в легкой атлетике предложили обнулить', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/iaaf/', 'Tue, 03 Jan 2017 16:03:00 +0300'),
(223, 'Заподозренный в причастности к стамбульскому теракту дал интервью', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/mashrapovsaid/', 'Tue, 03 Jan 2017 15:57:10 +0300'),
(224, 'Бунт произошел в лагере беженцев в итальянском городе Кона', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/camp_riot/', 'Tue, 03 Jan 2017 15:52:03 +0300'),
(225, 'Украинцам запретили платить наличными больше 50 тысяч гривен', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/beznal/', 'Tue, 03 Jan 2017 15:49:10 +0300'),
(226, 'На Украине собрались производить винтовку M16', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/m16/', 'Tue, 03 Jan 2017 15:28:31 +0300'),
(227, 'Во Львове спалили музей УПА', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/dotla/', 'Tue, 03 Jan 2017 15:21:00 +0300'),
(228, 'Опубликовано видео окутывающего Пекин смога', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/smog/', 'Tue, 03 Jan 2017 15:13:00 +0300'),
(229, 'Марокканку задержали за попытку провезти в Испанию габонца в чемодане', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/luggage/', 'Tue, 03 Jan 2017 15:00:09 +0300'),
(230, 'Отличившихся в боях солдат ВСУ забыли в холодном ангаре на Новый год', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/nagrada/', 'Tue, 03 Jan 2017 14:43:00 +0300'),
(231, 'Бишкек отреагировал на сообщения о киргизском следе в стамбульском теракте', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/bishkek/', 'Tue, 03 Jan 2017 14:37:22 +0300'),
(232, 'Марин Ле Пен сочла законным крымский референдум', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/not_an_annexation/', 'Tue, 03 Jan 2017 14:35:39 +0300'),
(233, 'Федерация бобслея России обнародовала фамилии отстраненных скелетонистов', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/skele/', 'Tue, 03 Jan 2017 14:25:18 +0300'),
(234, 'Сборы «Викинга» в прокате приблизились к 500 миллионам рублей', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/viking/', 'Tue, 03 Jan 2017 14:02:00 +0300'),
(235, 'Путин дал время на проверку закона об иноагентах до весны', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/nko/', 'Tue, 03 Jan 2017 13:52:42 +0300'),
(236, 'В Швейцарии мужчина открыл огонь по полицейским', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/shooting_in_switzerland/', 'Tue, 03 Jan 2017 13:51:00 +0300'),
(237, 'Правительство по поручению Путина поборется с криминализацией подростков', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/teenagers/', 'Tue, 03 Jan 2017 13:35:00 +0300'),
(238, 'СМИ назвали сроки окончания похода «Адмирала Кузнецова» в Средиземное море', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/kuznets/', 'Tue, 03 Jan 2017 13:31:00 +0300'),
(239, 'Исполнителем теракта в стамбульском ночном клубе оказался гражданин Киргизии', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/mashrapov/', 'Tue, 03 Jan 2017 13:01:00 +0300'),
(240, 'Пьяная женщина зарезала родственницу на юго-востоке Москвы', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/murder/', 'Tue, 03 Jan 2017 12:51:00 +0300'),
(241, 'Самолет экстренно сел в Екатеринбурге из-за отказавшего двигателя', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/eburg/', 'Tue, 03 Jan 2017 12:45:00 +0300'),
(242, 'Аршавина признали лучшим футболистом Казахстана', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/shavo/', 'Tue, 03 Jan 2017 12:38:00 +0300'),
(243, 'Рубль начал 2017 год с роста к доллару и евро', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/dollar/', 'Tue, 03 Jan 2017 12:36:00 +0300'),
(244, 'Дутерте рассказал о связях родственников с «Исламским государством»', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/bad_relatives/', 'Tue, 03 Jan 2017 12:30:15 +0300'),
(245, 'Захарова поделилась секретом своих платьев', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/fashion_mid/', 'Tue, 03 Jan 2017 12:11:00 +0300'),
(246, 'Тулеев пожаловался Медведеву на беспредел с подорожанием бензина', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/kuzbass/', 'Tue, 03 Jan 2017 12:03:01 +0300'),
(247, 'В Белоруссии открыли новое нефтяное месторождение', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/new_oil/', 'Tue, 03 Jan 2017 11:46:18 +0300'),
(248, 'Близнецы в США родились в разные годы', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/twins/', 'Tue, 03 Jan 2017 11:22:00 +0300'),
(249, 'Появился видеообзор разгромной победы россиян над датчанами на МЧМ по хоккею', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/bideo/', 'Tue, 03 Jan 2017 11:04:00 +0300'),
(250, 'Иорданский миллиардер стал одной из жертв стамбульского теракта', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/jordan_billioner/', 'Tue, 03 Jan 2017 10:45:00 +0300'),
(251, 'Ассанж раскрыл причину нападок администрации Обамы на Россию', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/assange/', 'Tue, 03 Jan 2017 10:41:00 +0300'),
(252, 'Нефть подорожала до 57 долларов на первых торгах года', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/oil/', 'Tue, 03 Jan 2017 09:59:00 +0300'),
(253, 'В Москве призвали не упрощать возможное влияние Трампа на ЕС', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/tchizhov/', 'Tue, 03 Jan 2017 09:45:00 +0300'),
(254, 'Смертники атаковали два полицейских участка в Самарре', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/samarra/', 'Tue, 03 Jan 2017 09:30:49 +0300'),
(255, 'Газета выяснила зарплаты руководителей госпредприятий Китая', 1, 'lenta.ru', 'https://lenta.ru/news/2017/01/03/dohod_gospred_kitaya/', 'Tue, 03 Jan 2017 08:49:00 +0300'),
(256, 'Нацполиция дала советы водителям из-за насувающихся метелей ', 1, 'www.pravda.com.ua', 'http://www.pravda.com.ua/rus/news/2017/01/5/7131746/', 'Thu, 05 Jan 2017 23:19:13 +0200'),
(257, 'Курс биткойна рухнул, показав максимальное падение за 2 года', 1, 'www.pravda.com.ua', 'http://www.epravda.com.ua/rus/news/2017/01/5/616842/', 'Thu, 05 Jan 2017 22:21:21 +0200'),
(258, 'Прокуратура закрыла дела против лидера "Оплота" Жилина', 1, 'www.pravda.com.ua', 'http://www.pravda.com.ua/rus/news/2017/01/5/7131744/', 'Thu, 05 Jan 2017 21:55:12 +0200'),
(259, 'Трамп собирается реформировать ООН - СМИ', 1, 'www.pravda.com.ua', 'http://www.eurointegration.com.ua/rus/news/2017/01/5/7059807/', 'Thu, 05 Jan 2017 21:19:13 +0200'),
(260, 'Разведка США: за кибератаками стоит Россия', 1, 'www.pravda.com.ua', 'http://www.pravda.com.ua/rus/news/2017/01/5/7131742/', 'Thu, 05 Jan 2017 20:41:56 +0200'),
(261, 'Международные резервы НБУ за 2016 год выросли до $15,5 миллиарда ', 1, 'www.pravda.com.ua', 'http://www.epravda.com.ua/rus/news/2017/01/5/616837/', 'Thu, 05 Jan 2017 20:39:35 +0200'),
(262, 'В результате взрыва в Измире украинцы не пострадали', 1, 'www.pravda.com.ua', 'http://www.pravda.com.ua/rus/news/2017/01/5/7131740/', 'Thu, 05 Jan 2017 20:14:49 +0200'),
(263, 'МOЗ: никто запросы кардиохирурга Тодурова не блокировал', 1, 'www.pravda.com.ua', 'http://life.pravda.com.ua/health/2017/01/5/222036/', 'Thu, 05 Jan 2017 19:47:40 +0200'),
(264, 'В Турции двух военных приговорили к пожизненному ', 1, 'www.pravda.com.ua', 'http://www.eurointegration.com.ua/rus/news/2017/01/5/7059804/', 'Thu, 05 Jan 2017 19:16:57 +0200'),
(265, 'Детективы завершили расследование "дела болтов и гаек" – САП', 1, 'www.pravda.com.ua', 'http://www.pravda.com.ua/rus/news/2017/01/5/7131737/', 'Thu, 05 Jan 2017 18:58:44 +0200'),
(266, 'Боевики 14 раз обстреляли позиции ВСУ', 1, 'www.pravda.com.ua', 'http://www.pravda.com.ua/rus/news/2017/01/5/7131736/', 'Thu, 05 Jan 2017 18:36:03 +0200'),
(267, 'Остатки по субсидиям составили 12 миллиардов – Розенко', 1, 'www.pravda.com.ua', 'http://www.epravda.com.ua/rus/news/2017/01/5/616832/', 'Thu, 05 Jan 2017 18:04:40 +0200');
INSERT INTO `posts_rss` (`id`, `title`, `category`, `source`, `link`, `date`) VALUES
(268, 'У Порошенко еще думают, ехать ли в Давос и к Пинчуку', 1, 'www.pravda.com.ua', 'http://www.pravda.com.ua/rus/news/2017/01/5/7131733/', 'Thu, 05 Jan 2017 17:38:12 +0200'),
(269, 'Нацсовет пожаловался на давление со стороны "1+1" и показал лицензию', 1, 'www.pravda.com.ua', 'http://www.pravda.com.ua/rus/news/2017/01/5/7131732/', 'Thu, 05 Jan 2017 17:31:11 +0200'),
(270, 'Нацполиция закрыла производство по Бахматюку и "ВиЭйБи Банку"', 1, 'www.pravda.com.ua', 'http://www.epravda.com.ua/rus/news/2017/01/5/616826/', 'Thu, 05 Jan 2017 17:16:10 +0200'),
(271, 'СБУ перекрыла канал незаконной миграции "под крышей" ФСБ', 1, 'www.pravda.com.ua', 'http://www.pravda.com.ua/rus/news/2017/01/5/7131728/', 'Thu, 05 Jan 2017 16:49:12 +0200'),
(272, 'Ограничения расчетов наличными не затронет интересы украинцев – Кубив', 1, 'www.pravda.com.ua', 'http://www.epravda.com.ua/rus/news/2017/01/5/616818/', 'Thu, 05 Jan 2017 16:40:10 +0200'),
(273, 'Как Беларусь создала IT-кластер и почему это пока не удалось Украине', 1, 'www.pravda.com.ua', 'http://www.epravda.com.ua/rus/columns/2017/01/5/615525/', 'Thu, 05 Jan 2017 16:25:10 +0200'),
(274, 'Взрыв возле суда в Измире: полиция уничтожила двух террористов', 1, 'www.pravda.com.ua', 'http://www.eurointegration.com.ua/rus/news/2017/01/5/7059801/', 'Thu, 05 Jan 2017 16:19:23 +0200'),
(275, 'Антикоррупционеры: НАЗК должно исследовать имущество 375 оффшоров', 1, 'www.pravda.com.ua', 'http://www.pravda.com.ua/rus/news/2017/01/5/7131723/', 'Thu, 05 Jan 2017 16:09:25 +0200'),
(276, 'Украинцев, закончивших военные кафедры в вузах, заберут в армию', 1, 'fakty.ua', 'http://fakty.ua/228446-ukraincev-zakonchivshih-voennye-kafedry-v-vuzah-zaberut-v-armiyu', 'Thu, 05 Jan 2017 22:56:00 +0200'),
(277, 'В прифронтовом Новолуганском возле гаражей обнаружили пакет с минами и тротилом (фото)', 1, 'fakty.ua', 'http://fakty.ua/228445-v-prifrontovom-novoluganskom-vozle-garazhej-obnaruzhili-paket-s-minami-i-trotilom-foto', 'Thu, 05 Jan 2017 21:53:13 +0200'),
(278, 'В Запорожской области изъята партия контрабандных сигарет на сумму более 1 млн грн', 1, 'fakty.ua', 'http://fakty.ua/228444-v-zaporozhskoj-oblasti-izyata-partiya-kontrabandnyh-sigaret-na-summu-bolee-1-mln-grn', 'Thu, 05 Jan 2017 21:01:09 +0200'),
(279, 'CES 2017: представлен телевизор без динамиков - звук источает поверхность самого экрана', 1, 'fakty.ua', 'http://fakty.ua/228443-ces-2017-predstavlen-televizor-bez-dinamikov---zvuk-istochaet-poverhnost-samogo-ekrana', 'Thu, 05 Jan 2017 19:57:00 +0200'),
(280, 'В Кабмине объяснили, почему доллар стоит 27 грн, а не 18,5 грн', 1, 'fakty.ua', 'http://fakty.ua/228442-v-kabmine-obyasnili-pochemu-dollar-stoit-27-grn-a-ne-18-5-grn', 'Thu, 05 Jan 2017 19:53:28 +0200'),
(281, 'Телеканал «1+1» таки получил лицензию', 1, 'fakty.ua', 'http://fakty.ua/228441-telekanal-1-1-taki-poluchil-licenziyu', 'Thu, 05 Jan 2017 19:05:00 +0200'),
(282, 'Директор Национальной разведки США: "Россия - полноценный участник киберпространства, представляющий главную угрозу для правительства Соединенных Штатов"', 1, 'fakty.ua', 'http://fakty.ua/228440-rossiya---eto-polnocennyj-uchastnik-kiberprostranstva-kotoryj-predstavlyaet-soboj-glavnuyu-ugrozu-dlya-pravitelstva-ssha', 'Thu, 05 Jan 2017 18:49:00 +0200'),
(283, 'Бывшему чиновнику «Укрзалізниці», совершившему резонансное ДТП, ужесточили наказание', 1, 'fakty.ua', 'http://fakty.ua/228439-byvshemu-chinovniku-ukrzal-znic-sovershivshemu-rezonansnoe-dtp-nemnogo-uzhestochili-nakazanie', 'Thu, 05 Jan 2017 18:28:00 +0200'),
(284, 'CES 2017: самоуправляемые автомобили от BMW, Toyota и Hyundai (видео)', 1, 'fakty.ua', 'http://fakty.ua/228438-ces-2017-samoupravlyaemye-avtomobili-ot-bmw-toyota-i-hyundai-video', 'Thu, 05 Jan 2017 18:22:00 +0200'),
(285, 'Американский военный врач передал ценное оборудование Львовскому военному госпиталю', 1, 'fakty.ua', 'http://fakty.ua/228437-amerikanskij-voennyj-vrach-peredal-cennoe-oborudovanie-lvovskomu-voennomu-gospitalyu', 'Thu, 05 Jan 2017 18:03:29 +0200'),
(286, 'В аэропорту Дакки задержан контрабандист, пытавшийся провезти 12 килограммовых слитков золота в... заднем проходе!', 1, 'fakty.ua', 'http://fakty.ua/228436-v-aeroportu-dakki-zaderzhan-kontrabandist-pytavshijsya-provezti-12-kilogrammovyh-slitkov-zolota-v-zadnem-prohode', 'Thu, 05 Jan 2017 17:55:00 +0200'),
(287, 'После отмены моратория всю украинскую землю скупят через три месяца - Гройсман', 1, 'fakty.ua', 'http://fakty.ua/228435-posle-otmeny-moratoriya-vsyu-ukrainskuyu-zemlyu-skupyat-cherez-tri-mesyaca---grojsman', 'Thu, 05 Jan 2017 17:44:10 +0200'),
(288, 'В Турции совершен очередной теракт: ранены не менее 10 человек', 1, 'fakty.ua', 'http://fakty.ua/228434-v-turcii-sovershen-ocherednoj-terakt---raneny-ne-menee-10-chelovek', 'Thu, 05 Jan 2017 17:36:00 +0200'),
(289, 'В пригороде Одессы СБУ обнаружила тайник с боеприпасами (фото)', 1, 'fakty.ua', 'http://fakty.ua/228433-v-prigorode-odessy-sbu-obnaruzhila-tajnik-s-boepripasami-foto', 'Thu, 05 Jan 2017 16:46:33 +0200'),
(290, 'Украина сэкономила 400 млн долларов, отказавшись покупать у россиян газ', 1, 'fakty.ua', 'http://fakty.ua/228432-ukraina-sekonomila-400-mln-dollarov-otkazavshis-pokupat-u-rossiyan-gaz', 'Thu, 05 Jan 2017 16:12:51 +0200'),
(291, 'В Лондоне лошадь попыталась зайти... в автобус (фото)', 1, 'fakty.ua', 'http://fakty.ua/228431-v-londone-loshad-popytalas-zajti-v-avtobus-foto', 'Thu, 05 Jan 2017 15:49:00 +0200'),
(292, 'Террористы заявили о новых условиях обмена пленными', 1, 'fakty.ua', 'http://fakty.ua/228430-terroristy-zayavili-o-novyh-usloviyah-obmena-plennymi', 'Thu, 05 Jan 2017 15:13:22 +0200'),
(293, 'На Сумщине задержали россиянина, который при поддержке ФСБ переправлял нелегалов через украинскую границу', 1, 'fakty.ua', 'http://fakty.ua/228429-na-sumcshine-zaderzhali-rossiyanina-kotoryj-pri-podderzhke-fsb-perepravlyal-nelegalov-cherez-ukrainskuyu-granicu', 'Thu, 05 Jan 2017 14:10:07 +0200'),
(294, 'В «ДНР» на передовую для «перевоспитания» начали отправлять «проштрафившихся» силовиков ', 1, 'fakty.ua', 'http://fakty.ua/228428-v-dnr-na-peredovuyu-dlya-perevospitaniya-nachali-otpravlyat-proshtrafivshihsya-silovikov', 'Thu, 05 Jan 2017 14:07:49 +0200'),
(295, 'Элина Свитолина обыграла первую ракетку мира и вышла в полуфинал турнира в Брисбене', 1, 'fakty.ua', 'http://fakty.ua/228427-elina-svitolina-obygrala-pervuyu-raketku-mira-i-vyshla-v-polufinal-turnira-v-brisbene', 'Thu, 05 Jan 2017 14:00:11 +0200'),
(296, 'CES 2017: представлен смартфон с рекордной оперативной памятью - объемом 8 ГБ (видео)', 1, 'fakty.ua', 'http://fakty.ua/228426-ces-2017---predstavlen-smartfon-s-rekordnoj-operativnoj-pamyatyu-obemom-8gb-video', 'Thu, 05 Jan 2017 13:08:00 +0200'),
(297, 'За сутки в зоне АТО ранен один украинский военный', 1, 'fakty.ua', 'http://fakty.ua/228424-za-sutki-v-zone-ato-ranen-odin-ukrainskij-voennyj', 'Thu, 05 Jan 2017 12:57:31 +0200'),
(298, 'CES 2017: представлена система беспроводной зарядки смартфонов и планшетов (видео)', 1, 'fakty.ua', 'http://fakty.ua/228425-ces-2017---predstavlena-sistema-besprovodnoj-zaryadki-smartfonov-i-planshetov-video', 'Thu, 05 Jan 2017 12:50:00 +0200'),
(299, 'Во Львовской галерее искусств заявили о пропаже уникальных старинных книг', 1, 'fakty.ua', 'http://fakty.ua/228422-vo-lvovskoj-galeree-iskusstv-obnaruzhili-propazhu-unikalnyh-starinnyh-knig', 'Thu, 05 Jan 2017 12:31:00 +0200'),
(300, 'Чтобы хорошо работать, рекомендуется отправляться в путешествие хотя бы раз в год', 1, 'fakty.ua', 'http://fakty.ua/228423-chtoby-ne-stradat-depressiej-i-horosho-rabotat-rekomenduetsya-otpravlyatsya-v-puteshestvie-hotya-by-raz-v-god', 'Thu, 05 Jan 2017 12:30:00 +0200'),
(301, 'Накопление алюминия в организме может приводить к болезни Альцгеймера', 1, 'fakty.ua', 'http://fakty.ua/228421-nakoplenie-alyuminiya-v-organizme-mozhet-privodit-k-bolezni-alcgejmera', 'Thu, 05 Jan 2017 12:15:00 +0200'),
(302, 'На взятке в 7 тысяч гривен «погорел» инспектор дорожной полиции Львовщины (фото)', 1, 'fakty.ua', 'http://fakty.ua/228419-na-vzyatke-v-7-tysyach-griven-pogorel-inspektor-dorozhnoj-policii-lvovcshiny-foto', 'Thu, 05 Jan 2017 11:43:00 +0200'),
(303, 'Полицейских могут обязать следить за порядком еще и на парковках', 1, 'fakty.ua', 'http://fakty.ua/228418-policejskih-mogut-obyazat-sledit-za-poryadkom-ecshe-i-na-parkovkah', 'Thu, 05 Jan 2017 11:40:00 +0200'),
(304, 'CES 2017: представлен самый быстрый электромобиль в мире (фото, видео)', 1, 'fakty.ua', 'http://fakty.ua/228420-ces-2017---predstavlen-samyj-bystryj-elektromobil-v-mire-foto-video', 'Thu, 05 Jan 2017 11:36:00 +0200'),
(305, 'Во Львове начали круглосуточно работать пункты обогрева', 1, 'fakty.ua', 'http://fakty.ua/228417-vo-lvove-nachali-kruglosutochno-rabotat-punkty-obogreva', 'Thu, 05 Jan 2017 11:23:11 +0200'),
(306, 'Как общаться с родственниками, если они вам не нравятся', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/05/relatives/', 'Thu, 05 Jan 2017 19:35:34 +0000'),
(307, 'Лучшие мобильные игры 2016 года по версии Лайфхакера', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/05/top2016-mobile-games/', 'Thu, 05 Jan 2017 17:35:57 +0000'),
(308, 'BACtrack Skyn — умный браслет, который подскажет, когда хватит пить', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/05/bactrack-skyn/', 'Thu, 05 Jan 2017 17:00:38 +0000'),
(309, 'Эффективный способ определить, чего вы хотите на самом деле', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/05/effectual-reasoning/', 'Thu, 05 Jan 2017 15:15:50 +0000'),
(310, 'Новые смартфоны от LG: улучшенная камера и сканер отпечатков пальцев', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/05/new-lg-smartphones/', 'Thu, 05 Jan 2017 13:00:37 +0000'),
(311, '50 полезных мелочей с AliExpress дешевле 50 рублей', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/05/50-rubles-things/', 'Thu, 05 Jan 2017 12:35:21 +0000'),
(312, 'RunIQ — новые фитнес-часы от New Balance и Intel', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/05/runiq/', 'Thu, 05 Jan 2017 11:45:55 +0000'),
(313, 'Лучшие рецепты 2016 года по версии Лайфхакера', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/05/top2016-luchshie-recepty/', 'Thu, 05 Jan 2017 10:15:35 +0000'),
(314, 'Компания Garmin представила женскую версию смарт-часов Fenix ​​5', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/05/garmin-fenix-5/', 'Thu, 05 Jan 2017 08:50:10 +0000'),
(315, 'Компания Motiv представила фитнес-трекер в виде кольца', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/05/motiv-ring/', 'Thu, 05 Jan 2017 08:10:14 +0000'),
(316, '10 зарубежных проектов и образовательных программ, заслуживающих внимания в 2017 году', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/05/10-zarubezhnyx-proektov-2017/', 'Thu, 05 Jan 2017 06:35:11 +0000'),
(317, '10 новых сериалов, которые вы успеете посмотреть за каникулы', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/04/film-weekend-64/', 'Wed, 04 Jan 2017 19:35:35 +0000'),
(318, 'Лучшие статьи по саморазвитию 2016 года по версии Лайфхакера', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/04/top2016-be-better/', 'Wed, 04 Jan 2017 17:35:19 +0000'),
(319, 'День ничегонеделания — отличный способ оправиться после праздников', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/04/do-nothing-day/', 'Wed, 04 Jan 2017 15:15:44 +0000'),
(320, '5 самых вкусных и полезных десертов для этой зимы', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/04/5-desserts-for-winter/', 'Wed, 04 Jan 2017 12:35:28 +0000'),
(322, 'Простой способ скачать музыку из «ВКонтакте»', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/08/skachat-muzyku-iz-vkontakte/', 'Sun, 08 Jan 2017 14:23:41 +0000'),
(323, 'Как снять квартиру в любом городе мира через Airbnb', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/08/airbnb-2/', 'Sun, 08 Jan 2017 12:35:33 +0000'),
(324, 'Nokia возвращается с новым смартфоном на Android', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/08/nokia-6/', 'Sun, 08 Jan 2017 10:35:02 +0000'),
(325, 'Лучшие iOS-приложения 2016 года по версии Лайфхакера', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/08/top2016-ios-apps/', 'Sun, 08 Jan 2017 10:15:36 +0000'),
(326, '10 простых упражнений, которые можно выполнять лёжа', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/08/exercises-you-can-do-lying-down/', 'Sun, 08 Jan 2017 06:35:16 +0000'),
(327, '7 суровых уроков, которые мы получаем в течение жизни', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/07/7-brutal-life-lessons/', 'Sat, 07 Jan 2017 19:35:35 +0000'),
(328, 'Как успевать больше в новом году', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/07/kak-uspevat-bolshe-v-novom-godu/', 'Sat, 07 Jan 2017 17:35:14 +0000'),
(329, 'Лучшие видео 2016 года по версии Лайфхакера', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/07/top2016-video/', 'Sat, 07 Jan 2017 15:15:50 +0000'),
(330, 'Polaroid Pop — яркая камера с функцией моментальной печати', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/07/polaroid-pop/', 'Sat, 07 Jan 2017 14:16:47 +0000'),
(331, '7 завтраков, которые настроят на здоровое питание после праздников', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/07/7-breakfast-recipes/', 'Sat, 07 Jan 2017 12:35:50 +0000'),
(332, '5 функций Chrome для Android, о которых стоит знать всем пользователям', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/07/google-chrome-android/', 'Sat, 07 Jan 2017 10:15:29 +0000'),
(333, 'Лучшие тренировки 2016 года по версии Лайфхакера', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/07/top2016-workouts/', 'Sat, 07 Jan 2017 06:35:16 +0000'),
(334, 'Как перестать стесняться всех и вся: 10 эффективных методов', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/06/kak-perestat-stesnyatsya/', 'Fri, 06 Jan 2017 19:35:28 +0000'),
(335, 'Misfit Vapor — самые необычные смарт-часы на CES 2017', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/06/misfit-vapor/', 'Fri, 06 Jan 2017 17:45:09 +0000'),
(336, 'ТЕСТ: Сможете ли вы угадать новогодний фильм всего по одному кадру?', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/06/new-year-film-quiz/', 'Fri, 06 Jan 2017 17:35:28 +0000'),
(337, '3 научных эксперимента, которые заставят вас изменить отношение к себе', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/3-experiments-for-changing-self-view/', 'Mon, 09 Jan 2017 18:50:54 +0000'),
(338, 'Как перестать покупать вещи, которые нам не нужны', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/the-diderot-effect/', 'Mon, 09 Jan 2017 18:05:59 +0000'),
(339, 'Обновление AirMail для iOS: новые жесты, интеграция с Workflow и Bear', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/airmail-ios-update/', 'Mon, 09 Jan 2017 17:20:39 +0000'),
(340, '7 YouTube-каналов о боевых искусствах, единоборствах и самообороне', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/edinoborstva-video/', 'Mon, 09 Jan 2017 16:50:09 +0000'),
(341, '174 бесплатные книги по программированию, дизайну и бизнесу', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/free-oreilly-ebooks/', 'Mon, 09 Jan 2017 15:50:39 +0000'),
(342, 'Универсальная разминка для любой тренировки', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/universalnaya-razminka/', 'Mon, 09 Jan 2017 14:50:29 +0000'),
(343, 'Как завести машину, если сел аккумулятор', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/sel-akkumulyator/', 'Mon, 09 Jan 2017 13:55:28 +0000'),
(344, 'Перчатки, в которых можно всю зиму не выпускать смартфон из рук', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/touchscreen-winter-gloves/', 'Mon, 09 Jan 2017 12:30:06 +0000'),
(345, 'Как понять, что вас обманывают по СМС', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/moshennichestvo-po-sms/', 'Mon, 09 Jan 2017 11:30:31 +0000'),
(346, 'Скидки на приложения и игры в Google Play 9 января', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/google-play-9-january/', 'Mon, 09 Jan 2017 10:30:11 +0000'),
(347, 'Бесплатные приложения и скидки в App Store 9 января', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/app-store-9-january-2017/', 'Mon, 09 Jan 2017 09:30:17 +0000'),
(348, '7 советов тем, кто хочет работать продуктивнее', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/7-productivity-tips/', 'Mon, 09 Jan 2017 08:00:22 +0000'),
(349, '15 возможностей Pocket, о которых вы могли не знать', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/15-pocket-tips/', 'Mon, 09 Jan 2017 06:50:23 +0000'),
(350, 'Как правильно поставить цель и достичь её: инструкция с примерами', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/goals/', 'Mon, 09 Jan 2017 05:50:59 +0000'),
(351, 'Touché добавляет тачбар нового MacBook Pro на любой Mac', 1, 'lifehacker.ru', 'https://lifehacker.ru/2017/01/09/touche-touchbar-for-any-mac/', 'Mon, 09 Jan 2017 04:50:29 +0000');

-- --------------------------------------------------------

--
-- Структура таблицы `RSS`
--

CREATE TABLE IF NOT EXISTS `RSS` (
  `rss_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `sourse` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Sites`
--

CREATE TABLE IF NOT EXISTS `Sites` (
  `site_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `method_of_parsing` enum('PhpQuery','cURL') NOT NULL,
  `parsing_settings` text NOT NULL,
  `make_parsing` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Tags`
--

CREATE TABLE IF NOT EXISTS `Tags` (
  `tag_id` int(11) NOT NULL,
  `tag` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'TGt-r5oEWQFs-y9drMmaGhZ2RWl9VlST', '$2y$13$AWzxlF9DNzeD6ie8pG4Z4e451YT4Kp8sHFQO0aBTo3a7AoSDAMPAO', NULL, 'admin@example.com', 10, 1483723086, 1483723086),
(2, 'user', '5TyyN12dRlsFZgQWYq5seiWmpOCnBxI0', '$2y$13$/1pcXjgtenX.r5dGKK1gNeoJCrbcR3GyuPSMt6FNw.YQgKXhqPMs6', NULL, 'user@example.com', 10, 1483729680, 1483729680);

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_create_date` date NOT NULL,
  `user_last_login_datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Users_to_tags`
--

CREATE TABLE IF NOT EXISTS `Users_to_tags` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `count_tag` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Articles`
--
ALTER TABLE `Articles`
  ADD PRIMARY KEY (`article_id`),
  ADD UNIQUE KEY `link_to_article_UNIQUE` (`link_to_article`),
  ADD KEY `category_id_idx` (`category_id`);

--
-- Индексы таблицы `Articles_To_Tags`
--
ALTER TABLE `Articles_To_Tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id_idx` (`article_id`),
  ADD KEY `tag_id_idx` (`tag_id`);

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Индексы таблицы `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id_idx` (`user_id`),
  ADD KEY `article_id_idx` (`article_id`);

--
-- Индексы таблицы `Images`
--
ALTER TABLE `Images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `article_id_idx` (`article_id`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `posts_rss`
--
ALTER TABLE `posts_rss`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `link_UNIQUE` (`link`),
  ADD KEY `link` (`link`),
  ADD KEY `category` (`category`),
  ADD KEY `date` (`date`);

--
-- Индексы таблицы `RSS`
--
ALTER TABLE `RSS`
  ADD PRIMARY KEY (`rss_id`),
  ADD UNIQUE KEY `link_UNIQUE` (`link`),
  ADD KEY `category_id_idx` (`category_id`);

--
-- Индексы таблицы `Sites`
--
ALTER TABLE `Sites`
  ADD PRIMARY KEY (`site_id`);

--
-- Индексы таблицы `Tags`
--
ALTER TABLE `Tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_UNIQUE` (`tag`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Индексы таблицы `Users_to_tags`
--
ALTER TABLE `Users_to_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_idx` (`user_id`),
  ADD KEY `tag_id_idx` (`tag_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Articles`
--
ALTER TABLE `Articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Articles_To_Tags`
--
ALTER TABLE `Articles_To_Tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Comments`
--
ALTER TABLE `Comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Images`
--
ALTER TABLE `Images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `posts_rss`
--
ALTER TABLE `posts_rss`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=352;
--
-- AUTO_INCREMENT для таблицы `RSS`
--
ALTER TABLE `RSS`
  MODIFY `rss_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Sites`
--
ALTER TABLE `Sites`
  MODIFY `site_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Tags`
--
ALTER TABLE `Tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Users_to_tags`
--
ALTER TABLE `Users_to_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
