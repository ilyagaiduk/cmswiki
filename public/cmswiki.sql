-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 12 2025 г., 06:13
-- Версия сервера: 8.0.42-0ubuntu0.20.04.1
-- Версия PHP: 7.4.3-4ubuntu2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cmswikimy`
--

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2014_10_12_200000_add_two_factor_columns_to_users_table', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `moderate`
--

CREATE TABLE `moderate` (
  `id` int NOT NULL,
  `url` varchar(300) NOT NULL,
  `h1` varchar(300) NOT NULL,
  `text` text NOT NULL,
  `user` varchar(300) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE `page` (
  `id` int NOT NULL,
  `url` varchar(700) NOT NULL,
  `h1` varchar(300) NOT NULL,
  `text` text NOT NULL,
  `views` int DEFAULT NULL,
  `img` varchar(700) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`id`, `url`, `h1`, `text`, `views`, `img`, `date`) VALUES
(1, '/index', 'Наша первая статья на главной странице', '<a href=\"/index/new\">Пример новой страницы</a> \r\n<div class=\"container mt-4\">\r\n  <h2 class=\"mb-3\">Добро пожаловать в CMS Wiki!</h2>\r\n  <p class=\"lead\">\r\n    Это — <strong>первый текст главной страницы</strong>.  \r\n    Вы можете изменить или дополнить его через административную панель.\r\n  </p>\r\n\r\n  <hr>\r\n\r\n  <h2 class=\"mt-4\">Возможности редактора</h2>\r\n  <ul>\r\n    <li>Поддерживаются все стандартные <code>HTML</code>-теги: \r\n      <code>h1</code>, <code>p</code>, <code>a</code>, <code>ul</code>, <code>img</code> и другие.</li>\r\n    <li>Доступно оформление с помощью <strong>Bootstrap-классов</strong> — просто добавляйте, например:\r\n      <code>class=\"btn btn-primary\"</code> или <code>class=\"alert alert-info\"</code>.</li>\r\n    <li>Можно использовать таблицы, списки, цитаты, блоки кода и любые другие HTML-элементы.</li>\r\n  </ul>\r\n\r\n  <div class=\"alert alert-info mt-4\">\r\n    <strong>Совет:</strong> оформляйте материал с помощью заголовков, списков и ссылок — так страницы будут выглядеть аккуратно и структурировано.\r\n  </div>\r\n\r\n  <h2 class=\"mt-4\">Добавление изображений</h2>\r\n  <p>Чтобы вставить картинку в текст:</p>\r\n  <ol>\r\n    <li>Загрузите файл в папку <code>/public/img</code> вашего проекта.</li>\r\n    <li>Добавьте HTML-тег с путём к изображению. Например:</li>\r\n  </ol>\r\n\r\n  <pre><code>img src=\"/img/example.jpg\" alt=\"Описание изображения\" class=\"img-fluid rounded\"</code></pre>\r\n\r\n  <p class=\"mt-3\">\r\n    После сохранения изменений изображение появится прямо на странице.\r\n  </p>\r\n\r\n  <h2 class=\"mt-4\">Создание новых страниц</h2>\r\n  <p>\r\n    Чтобы создать новую страницу в CMS Wiki, достаточно разместить в тексте ссылку вида:<br>\r\n    <code>< ahref=\"/index/new\" >Новая страница< / a></code>\r\n  </p>\r\n  <p>\r\n    После перехода по этой ссылке система автоматически создаст страницу с указанным именем.  \r\n    Обратите внимание: уровень <strong>index</strong> является обязательным в структуре URL.\r\n  </p>\r\n\r\n  <hr>\r\n\r\n  <h2 class=\"mt-4\">Советы по оформлению</h2>\r\n  <ul>\r\n    <li>Используйте заголовки <code>h2</code> и <code>h3</code> для структуры текста.</li>\r\n    <li>Применяйте классы Bootstrap для красивого оформления без CSS.</li>\r\n    <li>Добавляйте изображения, видео и ссылки для более насыщенного контента.</li>\r\n  </ul>\r\n\r\n  <div class=\"alert alert-success mt-4\">\r\n    🎯 <strong>CMS Wiki</strong> — гибкая система управления контентом, созданная для тех, кто ценит простоту, контроль и чистый код.\r\n  </div>\r\n</div>', 0, '/uploads/1760092036.png', '2025-10-10 22:09:40'),
(18, '/index/new', 'Наша новая статья', '<p>Здесь должен быть лаконичный текст :)</p>\r\n<a href=\"/index/1\">Страница 1</a>', 0, '/uploads/1760087281.jpg', '2025-10-11 09:24:17'),
(19, '/index/1', 'Страница удалена', '<p>Страница больше не используется.</p>', 0, '/img/logo-wiki.webp', '2025-10-10 08:47:53'),
(20, '/index/second_page', 'Страница удалена', '<p>Страница больше не используется.</p>', 0, '/img/logo-wiki.webp', '2025-10-10 13:35:59'),
(21, '/index/xmlrpc.php', 'Наша новая статья', '<p>Здесь должен быть лаконичный текст :)</p>', 0, '/img/logo-wiki.webp', '2025-10-10 20:45:31');

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `timezone` varchar(200) NOT NULL,
  `oldtimezone` varchar(200) NOT NULL,
  `title` varchar(75) NOT NULL,
  `metrika` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `version` int NOT NULL DEFAULT '1',
  `search` varchar(3000) DEFAULT NULL,
  `favicon` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `timezone`, `oldtimezone`, `title`, `metrika`, `version`, `search`, `favicon`) VALUES
(1, 'Europe/Moscow', 'Europe/Moscow', 'Мастхев CMS Wiki', '<!-- Yandex.Metrika counter -->\r\n<script type=\"text/javascript\">\r\n    (function(m,e,t,r,i,k,a){\r\n        m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};\r\n        m[i].l=1*new Date();\r\n        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}\r\n        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)\r\n    })(window, document,\'script\',\'https://mc.yandex.ru/metrika/tag.js?id=104582436\', \'ym\');\r\n\r\n    ym(104582436, \'init\', {ssr:true, webvisor:true, clickmap:true, ecommerce:\"dataLayer\", accurateTrackBounce:true, trackLinks:true});\r\n</script>\r\n<noscript><div><img src=\"https://mc.yandex.ru/watch/104582436\" style=\"position:absolute; left:-9999px;\" alt=\"\" /></div></noscript>\r\n<!-- /Yandex.Metrika counter -->', 5, '<div class=\"ya-site-form ya-site-form_inited_no\" data-bem=\"{&quot;action&quot;:&quot;https://yandex.ru/search/site/&quot;,&quot;arrow&quot;:false,&quot;bg&quot;:&quot;transparent&quot;,&quot;fontsize&quot;:12,&quot;fg&quot;:&quot;#000000&quot;,&quot;language&quot;:&quot;ru&quot;,&quot;logo&quot;:&quot;rb&quot;,&quot;publicname&quot;:&quot;CMS Wiki&quot;,&quot;suggest&quot;:true,&quot;target&quot;:&quot;_self&quot;,&quot;tld&quot;:&quot;ru&quot;,&quot;type&quot;:3,&quot;usebigdictionary&quot;:true,&quot;searchid&quot;:13912284,&quot;input_fg&quot;:&quot;#000000&quot;,&quot;input_bg&quot;:&quot;#ffffff&quot;,&quot;input_fontStyle&quot;:&quot;normal&quot;,&quot;input_fontWeight&quot;:&quot;normal&quot;,&quot;input_placeholder&quot;:null,&quot;input_placeholderColor&quot;:&quot;#000000&quot;,&quot;input_borderColor&quot;:&quot;#7f9db9&quot;}\"><form action=\"https://yandex.ru/search/site/\" method=\"get\" target=\"_self\" accept-charset=\"utf-8\"><input type=\"hidden\" name=\"searchid\" value=\"13912284\"/><input type=\"hidden\" name=\"l10n\" value=\"ru\"/><input type=\"hidden\" name=\"reqenc\" value=\"\"/><input type=\"search\" name=\"text\" value=\"\"/><input type=\"submit\" value=\"Найти\"/></form></div><style type=\"text/css\">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type=\"text/javascript\">(function(w,d,c){var s=d.createElement(\'script\'),h=d.getElementsByTagName(\'script\')[0],e=d.documentElement;if((\' \'+e.className+\' \').indexOf(\' ya-page_js_yes \')===-1){e.className+=\' ya-page_js_yes\';}s.type=\'text/javascript\';s.async=true;s.charset=\'utf-8\';s.src=(d.location.protocol===\'https:\'?\'https:\':\'http:\')+\'//site.yandex.net/v2.0/js/all.js\';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,\'yandex_site_callbacks\');</script>', '/img/logo-not-fon.png');

-- --------------------------------------------------------

--
-- Структура таблицы `start_url`
--

CREATE TABLE `start_url` (
  `id` int NOT NULL,
  `url` varchar(20) NOT NULL,
  `get` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `start_url`
--

INSERT INTO `start_url` (`id`, `url`, `get`) VALUES
(1, 'index', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `timezones`
--

CREATE TABLE `timezones` (
  `id` int NOT NULL,
  `utc` varchar(20) NOT NULL,
  `timezone` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `country` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `timezones`
--

INSERT INTO `timezones` (`id`, `utc`, `timezone`, `country`) VALUES
(1045, 'UTC-11', ' Pacific/Midway', ' United States Minor Outlying Islands '),
(1046, 'UTC-11', ' Pacific/Niue', ' Niue '),
(1047, 'UTC-11', ' Pacific/Pago_Pago', ' American Samoa '),
(1048, 'UTC-10', ' America/Adak', ' United States '),
(1049, 'UTC-10', ' Pacific/Honolulu', ' United States '),
(1050, 'UTC-10', ' Pacific/Rarotonga', ' Cook Islands '),
(1051, 'UTC-10', ' Pacific/Tahiti', ' French Polynesia '),
(1052, 'UTC-9:30', ' Pacific/Marquesas', ' French Polynesia '),
(1053, 'UTC-9', ' America/Anchorage', ' United States '),
(1054, 'UTC-9', ' America/Juneau', ' United States '),
(1055, 'UTC-9', ' America/Metlakatla', ' United States '),
(1056, 'UTC-9', ' America/Nome', ' United States '),
(1057, 'UTC-9', ' America/Sitka', ' United States '),
(1058, 'UTC-9', ' America/Yakutat', ' United States '),
(1059, 'UTC-9', ' Pacific/Gambier', ' French Polynesia '),
(1060, 'UTC-8', ' America/Los_Angeles', ' United States '),
(1061, 'UTC-8', ' America/Tijuana', ' Mexico '),
(1062, 'UTC-8', ' America/Vancouver', ' Canada '),
(1063, 'UTC-8', ' Pacific/Pitcairn', ' Pitcairn '),
(1064, 'UTC-7', ' America/Boise', ' United States '),
(1065, 'UTC-7', ' America/Cambridge_Bay', ' Canada '),
(1066, 'UTC-7', ' America/Ciudad_Juarez', ' Mexico '),
(1067, 'UTC-7', ' America/Creston', ' Canada '),
(1068, 'UTC-7', ' America/Dawson', ' Canada '),
(1069, 'UTC-7', ' America/Dawson_Creek', ' Canada '),
(1070, 'UTC-7', ' America/Denver', ' United States '),
(1071, 'UTC-7', ' America/Edmonton', ' Canada '),
(1072, 'UTC-7', ' America/Fort_Nelson', ' Canada '),
(1073, 'UTC-7', ' America/Hermosillo', ' Mexico '),
(1074, 'UTC-7', ' America/Inuvik', ' Canada '),
(1075, 'UTC-7', ' America/Mazatlan', ' Mexico '),
(1076, 'UTC-7', ' America/Phoenix', ' United States '),
(1077, 'UTC-7', ' America/Whitehorse', ' Canada '),
(1078, 'UTC-7', ' America/Yellowknife', ' Canada '),
(1079, 'UTC-6', ' America/Bahia_Banderas', ' Mexico '),
(1080, 'UTC-6', ' America/Belize', ' Belize '),
(1081, 'UTC-6', ' America/Chicago', ' United States '),
(1082, 'UTC-6', ' America/Chihuahua', ' Mexico '),
(1083, 'UTC-6', ' America/Costa_Rica', ' Costa Rica '),
(1084, 'UTC-6', ' America/El_Salvador', ' El Salvador '),
(1085, 'UTC-6', ' America/Guatemala', ' Guatemala '),
(1086, 'UTC-6', ' America/Indiana/Knox', ' United States '),
(1087, 'UTC-6', ' America/Indiana/Tell_City', ' United States '),
(1088, 'UTC-6', ' America/Managua', ' Nicaragua '),
(1089, 'UTC-6', ' America/Matamoros', ' Mexico '),
(1090, 'UTC-6', ' America/Menominee', ' United States '),
(1091, 'UTC-6', ' America/Merida', ' Mexico '),
(1092, 'UTC-6', ' America/Mexico_City', ' Mexico '),
(1093, 'UTC-6', ' America/Monterrey', ' Mexico '),
(1094, 'UTC-6', ' America/North_Dakota/Beulah', ' United States '),
(1095, 'UTC-6', ' America/North_Dakota/Center', ' United States '),
(1096, 'UTC-6', ' America/North_Dakota/New_Salem', ' United States '),
(1097, 'UTC-6', ' America/Ojinaga', ' Mexico '),
(1098, 'UTC-6', ' America/Rankin_Inlet', ' Canada '),
(1099, 'UTC-6', ' America/Regina', ' Canada '),
(1100, 'UTC-6', ' America/Resolute', ' Canada '),
(1101, 'UTC-6', ' America/Swift_Current', ' Canada '),
(1102, 'UTC-6', ' America/Tegucigalpa', ' Honduras '),
(1103, 'UTC-6', ' America/Winnipeg', ' Canada '),
(1104, 'UTC-6', ' Pacific/Easter', ' Chile '),
(1105, 'UTC-6', ' Pacific/Galapagos', ' Ecuador '),
(1106, 'UTC-5', ' America/Atikokan', ' Canada '),
(1107, 'UTC-5', ' America/Bogota', ' Colombia '),
(1108, 'UTC-5', ' America/Cancun', ' Mexico '),
(1109, 'UTC-5', ' America/Cayman', ' Cayman Islands '),
(1110, 'UTC-5', ' America/Detroit', ' United States '),
(1111, 'UTC-5', ' America/Eirunepe', ' Brazil '),
(1112, 'UTC-5', ' America/Grand_Turk', ' Turks and Caicos Islands '),
(1113, 'UTC-5', ' America/Guayaquil', ' Ecuador '),
(1114, 'UTC-5', ' America/Havana', ' Cuba '),
(1115, 'UTC-5', ' America/Indiana/Indianapolis', ' United States '),
(1116, 'UTC-5', ' America/Indiana/Marengo', ' United States '),
(1117, 'UTC-5', ' America/Indiana/Petersburg', ' United States '),
(1118, 'UTC-5', ' America/Indiana/Vevay', ' United States '),
(1119, 'UTC-5', ' America/Indiana/Vincennes', ' United States '),
(1120, 'UTC-5', ' America/Indiana/Winamac', ' United States '),
(1121, 'UTC-5', ' America/Iqaluit', ' Canada '),
(1122, 'UTC-5', ' America/Jamaica', ' Jamaica '),
(1123, 'UTC-5', ' America/Kentucky/Louisville', ' United States '),
(1124, 'UTC-5', ' America/Kentucky/Monticello', ' United States '),
(1125, 'UTC-5', ' America/Lima', ' Peru '),
(1126, 'UTC-5', ' America/Nassau', ' Bahamas '),
(1127, 'UTC-5', ' America/New_York', ' United States '),
(1128, 'UTC-5', ' America/Panama', ' Panama '),
(1129, 'UTC-5', ' America/Port-au-Prince', ' Haiti '),
(1130, 'UTC-5', ' America/Rio_Branco', ' Brazil '),
(1131, 'UTC-5', ' America/Toronto', ' Canada '),
(1132, 'UTC-4', ' America/Anguilla', ' Anguilla '),
(1133, 'UTC-4', ' America/Antigua', ' Antigua and Barbuda '),
(1134, 'UTC-4', ' America/Aruba', ' Aruba '),
(1135, 'UTC-4', ' America/Asuncion', ' Paraguay '),
(1136, 'UTC-4', ' America/Barbados', ' Barbados '),
(1137, 'UTC-4', ' America/Blanc-Sablon', ' Canada '),
(1138, 'UTC-4', ' America/Boa_Vista', ' Brazil '),
(1139, 'UTC-4', ' America/Campo_Grande', ' Brazil '),
(1140, 'UTC-4', ' America/Caracas', ' Venezuela '),
(1141, 'UTC-4', ' America/Cuiaba', ' Brazil '),
(1142, 'UTC-4', ' America/Curacao', ' Curacao '),
(1143, 'UTC-4', ' America/Dominica', ' Dominica '),
(1144, 'UTC-4', ' America/Glace_Bay', ' Canada '),
(1145, 'UTC-4', ' America/Goose_Bay', ' Canada '),
(1146, 'UTC-4', ' America/Grenada', ' Grenada '),
(1147, 'UTC-4', ' America/Guadeloupe', ' Guadeloupe '),
(1148, 'UTC-4', ' America/Guyana', ' Guyana '),
(1149, 'UTC-4', ' America/Halifax', ' Canada '),
(1150, 'UTC-4', ' America/Kralendijk', ' Bonaire'),
(1151, 'UTC-4', ' America/La_Paz', ' Bolivia '),
(1152, 'UTC-4', ' America/Lower_Princes', ' Sint Maarten '),
(1153, 'UTC-4', ' America/Manaus', ' Brazil '),
(1154, 'UTC-4', ' America/Marigot', ' Saint Martin '),
(1155, 'UTC-4', ' America/Martinique', ' Martinique '),
(1156, 'UTC-4', ' America/Moncton', ' Canada '),
(1157, 'UTC-4', ' America/Montserrat', ' Montserrat '),
(1158, 'UTC-4', ' America/Porto_Velho', ' Brazil '),
(1159, 'UTC-4', ' America/Port_of_Spain', ' Trinidad and Tobago '),
(1160, 'UTC-4', ' America/Puerto_Rico', ' Puerto Rico '),
(1161, 'UTC-4', ' America/Santiago', ' Chile '),
(1162, 'UTC-4', ' America/Santo_Domingo', ' Dominican Republic '),
(1163, 'UTC-4', ' America/St_Barthelemy', ' Saint Barthelemy '),
(1164, 'UTC-4', ' America/St_Kitts', ' Saint Kitts and Nevis '),
(1165, 'UTC-4', ' America/St_Lucia', ' Saint Lucia '),
(1166, 'UTC-4', ' America/St_Thomas', ' U.S. Virgin Islands '),
(1167, 'UTC-4', ' America/St_Vincent', ' Saint Vincent and the Grenadines '),
(1168, 'UTC-4', ' America/Thule', ' Greenland '),
(1169, 'UTC-4', ' America/Tortola', ' British Virgin Islands '),
(1170, 'UTC-4', ' Atlantic/Bermuda', ' Bermuda '),
(1171, 'UTC-3:30', ' America/St_Johns', ' Canada '),
(1172, 'UTC-3', ' America/Araguaina', ' Brazil '),
(1173, 'UTC-3', ' America/Argentina/Buenos_Aires', ' Argentina '),
(1174, 'UTC-3', ' America/Argentina/Catamarca', ' Argentina '),
(1175, 'UTC-3', ' America/Argentina/Cordoba', ' Argentina '),
(1176, 'UTC-3', ' America/Argentina/Jujuy', ' Argentina '),
(1177, 'UTC-3', ' America/Argentina/La_Rioja', ' Argentina '),
(1178, 'UTC-3', ' America/Argentina/Mendoza', ' Argentina '),
(1179, 'UTC-3', ' America/Argentina/Rio_Gallegos', ' Argentina '),
(1180, 'UTC-3', ' America/Argentina/Salta', ' Argentina '),
(1181, 'UTC-3', ' America/Argentina/San_Juan', ' Argentina '),
(1182, 'UTC-3', ' America/Argentina/San_Luis', ' Argentina '),
(1183, 'UTC-3', ' America/Argentina/Tucuman', ' Argentina '),
(1184, 'UTC-3', ' America/Argentina/Ushuaia', ' Argentina '),
(1185, 'UTC-3', ' America/Bahia', ' Brazil '),
(1186, 'UTC-3', ' America/Belem', ' Brazil '),
(1187, 'UTC-3', ' America/Cayenne', ' French Guiana '),
(1188, 'UTC-3', ' America/Fortaleza', ' Brazil '),
(1189, 'UTC-3', ' America/Maceio', ' Brazil '),
(1190, 'UTC-3', ' America/Miquelon', ' Saint Pierre and Miquelon '),
(1191, 'UTC-3', ' America/Montevideo', ' Uruguay '),
(1192, 'UTC-3', ' America/Paramaribo', ' Suriname '),
(1193, 'UTC-3', ' America/Punta_Arenas', ' Chile '),
(1194, 'UTC-3', ' America/Recife', ' Brazil '),
(1195, 'UTC-3', ' America/Santarem', ' Brazil '),
(1196, 'UTC-3', ' America/Sao_Paulo', ' Brazil '),
(1197, 'UTC-3', ' Antarctica/Palmer', ' Antarctica '),
(1198, 'UTC-3', ' Antarctica/Rothera', ' Antarctica '),
(1199, 'UTC-3', ' Atlantic/Stanley', ' Falkland Islands '),
(1200, 'UTC-2', ' America/Noronha', ' Brazil '),
(1201, 'UTC-2', ' America/Nuuk', ' Greenland '),
(1202, 'UTC-2', ' Atlantic/South_Georgia', ' South Georgia and the South Sandwich Islands '),
(1203, 'UTC-1', ' America/Scoresbysund', ' Greenland '),
(1204, 'UTC-1', ' Atlantic/Azores', ' Portugal '),
(1205, 'UTC-1', ' Atlantic/Cape_Verde', ' Cabo Verde '),
(1206, 'UTC+0', ' Africa/Abidjan', ' Ivory Coast '),
(1207, 'UTC+0', ' Africa/Accra', ' Ghana '),
(1208, 'UTC+0', ' Africa/Bamako', ' Mali '),
(1209, 'UTC+0', ' Africa/Banjul', ' Gambia '),
(1210, 'UTC+0', ' Africa/Bissau', ' Guinea-Bissau '),
(1211, 'UTC+0', ' Africa/Casablanca', ' Morocco '),
(1212, 'UTC+0', ' Africa/Conakry', ' Guinea '),
(1213, 'UTC+0', ' Africa/Dakar', ' Senegal '),
(1214, 'UTC+0', ' Africa/El_Aaiun', ' Western Sahara '),
(1215, 'UTC+0', ' Africa/Freetown', ' Sierra Leone '),
(1216, 'UTC+0', ' Africa/Lome', ' Togo '),
(1217, 'UTC+0', ' Africa/Monrovia', ' Liberia '),
(1218, 'UTC+0', ' Africa/Nouakchott', ' Mauritania '),
(1219, 'UTC+0', ' Africa/Ouagadougou', ' Burkina Faso '),
(1220, 'UTC+0', ' Africa/Sao_Tome', ' Sao Tome and Principe '),
(1221, 'UTC+0', ' America/Danmarkshavn', ' Greenland '),
(1222, 'UTC+0', ' Antarctica/Troll', ' Antarctica '),
(1223, 'UTC+0', ' Atlantic/Canary', ' Spain '),
(1224, 'UTC+0', ' Atlantic/Faroe', ' Faroe Islands '),
(1225, 'UTC+0', ' Atlantic/Madeira', ' Portugal '),
(1226, 'UTC+0', ' Atlantic/Reykjavik', ' Iceland '),
(1227, 'UTC+0', ' Atlantic/St_Helena', ' Saint Helena '),
(1228, 'UTC+0', ' Europe/Dublin', ' Ireland '),
(1229, 'UTC+0', ' Europe/Guernsey', ' Guernsey '),
(1230, 'UTC+0', ' Europe/Isle_of_Man', ' Isle of Man '),
(1231, 'UTC+0', ' Europe/Jersey', ' Jersey '),
(1232, 'UTC+0', ' Europe/Lisbon', ' Portugal '),
(1233, 'UTC+0', ' Europe/London', ' United Kingdom '),
(1234, 'UTC+1', ' Africa/Algiers', ' Algeria '),
(1235, 'UTC+1', ' Africa/Bangui', ' Central African Republic '),
(1236, 'UTC+1', ' Africa/Brazzaville', ' Republic of the Congo '),
(1237, 'UTC+1', ' Africa/Ceuta', ' Spain '),
(1238, 'UTC+1', ' Africa/Douala', ' Cameroon '),
(1239, 'UTC+1', ' Africa/Kinshasa', ' Democratic Republic of the Congo '),
(1240, 'UTC+1', ' Africa/Lagos', ' Nigeria '),
(1241, 'UTC+1', ' Africa/Libreville', ' Gabon '),
(1242, 'UTC+1', ' Africa/Luanda', ' Angola '),
(1243, 'UTC+1', ' Africa/Malabo', ' Equatorial Guinea '),
(1244, 'UTC+1', ' Africa/Ndjamena', ' Chad '),
(1245, 'UTC+1', ' Africa/Niamey', ' Niger '),
(1246, 'UTC+1', ' Africa/Porto-Novo', ' Benin '),
(1247, 'UTC+1', ' Africa/Tunis', ' Tunisia '),
(1248, 'UTC+1', ' Africa/Windhoek', ' Namibia '),
(1249, 'UTC+1', ' Arctic/Longyearbyen', ' Svalbard and Jan Mayen '),
(1250, 'UTC+1', ' Europe/Amsterdam', ' The Netherlands '),
(1251, 'UTC+1', ' Europe/Andorra', ' Andorra '),
(1252, 'UTC+1', ' Europe/Belgrade', ' Serbia '),
(1253, 'UTC+1', ' Europe/Berlin', ' Germany '),
(1254, 'UTC+1', ' Europe/Bratislava', ' Slovakia '),
(1255, 'UTC+1', ' Europe/Brussels', ' Belgium '),
(1256, 'UTC+1', ' Europe/Budapest', ' Hungary '),
(1257, 'UTC+1', ' Europe/Copenhagen', ' Denmark '),
(1258, 'UTC+1', ' Europe/Gibraltar', ' Gibraltar '),
(1259, 'UTC+1', ' Europe/Ljubljana', ' Slovenia '),
(1260, 'UTC+1', ' Europe/Luxembourg', ' Luxembourg '),
(1261, 'UTC+1', ' Europe/Madrid', ' Spain '),
(1262, 'UTC+1', ' Europe/Malta', ' Malta '),
(1263, 'UTC+1', ' Europe/Monaco', ' Monaco '),
(1264, 'UTC+1', ' Europe/Oslo', ' Norway '),
(1265, 'UTC+1', ' Europe/Paris', ' France '),
(1266, 'UTC+1', ' Europe/Podgorica', ' Montenegro '),
(1267, 'UTC+1', ' Europe/Prague', ' Czechia '),
(1268, 'UTC+1', ' Europe/Rome', ' Italy '),
(1269, 'UTC+1', ' Europe/San_Marino', ' San Marino '),
(1270, 'UTC+1', ' Europe/Sarajevo', ' Bosnia and Herzegovina '),
(1271, 'UTC+1', ' Europe/Skopje', ' North Macedonia '),
(1272, 'UTC+1', ' Europe/Stockholm', ' Sweden '),
(1273, 'UTC+1', ' Europe/Tirane', ' Albania '),
(1274, 'UTC+1', ' Europe/Vaduz', ' Liechtenstein '),
(1275, 'UTC+1', ' Europe/Vatican', ' Vatican '),
(1276, 'UTC+1', ' Europe/Vienna', ' Austria '),
(1277, 'UTC+1', ' Europe/Warsaw', ' Poland '),
(1278, 'UTC+1', ' Europe/Zagreb', ' Croatia '),
(1279, 'UTC+1', ' Europe/Zurich', ' Switzerland '),
(1280, 'UTC+2', ' Africa/Blantyre', ' Malawi '),
(1281, 'UTC+2', ' Africa/Bujumbura', ' Burundi '),
(1282, 'UTC+2', ' Africa/Cairo', ' Egypt '),
(1283, 'UTC+2', ' Africa/Gaborone', ' Botswana '),
(1284, 'UTC+2', ' Africa/Harare', ' Zimbabwe '),
(1285, 'UTC+2', ' Africa/Johannesburg', ' South Africa '),
(1286, 'UTC+2', ' Africa/Juba', ' South Sudan '),
(1287, 'UTC+2', ' Africa/Khartoum', ' Sudan '),
(1288, 'UTC+2', ' Africa/Kigali', ' Rwanda '),
(1289, 'UTC+2', ' Africa/Lubumbashi', ' Democratic Republic of the Congo '),
(1290, 'UTC+2', ' Africa/Lusaka', ' Zambia '),
(1291, 'UTC+2', ' Africa/Maputo', ' Mozambique '),
(1292, 'UTC+2', ' Africa/Maseru', ' Lesotho '),
(1293, 'UTC+2', ' Africa/Mbabane', ' Eswatini '),
(1294, 'UTC+2', ' Africa/Tripoli', ' Libya '),
(1295, 'UTC+2', ' Asia/Beirut', ' Lebanon '),
(1296, 'UTC+2', ' Asia/Famagusta', ' Cyprus '),
(1297, 'UTC+2', ' Asia/Gaza', ' Palestinian Territory '),
(1298, 'UTC+2', ' Asia/Hebron', ' Palestinian Territory '),
(1299, 'UTC+2', ' Asia/Jerusalem', ' Israel '),
(1300, 'UTC+2', ' Asia/Nicosia', ' Cyprus '),
(1301, 'UTC+2', ' Europe/Athens', ' Greece '),
(1302, 'UTC+2', ' Europe/Bucharest', ' Romania '),
(1303, 'UTC+2', ' Europe/Chisinau', ' Moldova '),
(1304, 'UTC+2', ' Europe/Helsinki', ' Finland '),
(1305, 'UTC+2', ' Europe/Kaliningrad', ' Russia '),
(1306, 'UTC+2', ' Europe/Kyiv', ' Ukraine '),
(1307, 'UTC+2', ' Europe/Mariehamn', ' Aland Islands '),
(1308, 'UTC+2', ' Europe/Riga', ' Latvia '),
(1309, 'UTC+2', ' Europe/Sofia', ' Bulgaria '),
(1310, 'UTC+2', ' Europe/Tallinn', ' Estonia '),
(1311, 'UTC+2', ' Europe/Vilnius', ' Lithuania '),
(1312, 'UTC+3', ' Africa/Addis_Ababa', ' Ethiopia '),
(1313, 'UTC+3', ' Africa/Asmara', ' Eritrea '),
(1314, 'UTC+3', ' Africa/Dar_es_Salaam', ' Tanzania '),
(1315, 'UTC+3', ' Africa/Djibouti', ' Djibouti '),
(1316, 'UTC+3', ' Africa/Kampala', ' Uganda '),
(1317, 'UTC+3', ' Africa/Mogadishu', ' Somalia '),
(1318, 'UTC+3', ' Africa/Nairobi', ' Kenya '),
(1319, 'UTC+3', ' Antarctica/Syowa', ' Antarctica '),
(1320, 'UTC+3', ' Asia/Aden', ' Yemen '),
(1321, 'UTC+3', ' Asia/Amman', ' Jordan '),
(1322, 'UTC+3', ' Asia/Baghdad', ' Iraq '),
(1323, 'UTC+3', ' Asia/Bahrain', ' Bahrain '),
(1324, 'UTC+3', ' Asia/Damascus', ' Syria '),
(1325, 'UTC+3', ' Asia/Kuwait', ' Kuwait '),
(1326, 'UTC+3', ' Asia/Qatar', ' Qatar '),
(1327, 'UTC+3', ' Asia/Riyadh', ' Saudi Arabia '),
(1328, 'UTC+3', ' Europe/Istanbul', ' Turkey '),
(1329, 'UTC+3', ' Europe/Kirov', ' Russia '),
(1330, 'UTC+3', ' Europe/Minsk', ' Belarus '),
(1331, 'UTC+3', ' Europe/Moscow', ' Russia '),
(1332, 'UTC+3', ' Europe/Simferopol', ' Ukraine '),
(1333, 'UTC+3', ' Europe/Volgograd', ' Russia '),
(1334, 'UTC+3', ' Indian/Antananarivo', ' Madagascar '),
(1335, 'UTC+3', ' Indian/Comoro', ' Comoros '),
(1336, 'UTC+3', ' Indian/Mayotte', ' Mayotte '),
(1337, 'UTC+3:30', ' Asia/Tehran', ' Iran '),
(1338, 'UTC+4', ' Asia/Baku', ' Azerbaijan '),
(1339, 'UTC+4', ' Asia/Dubai', ' United Arab Emirates '),
(1340, 'UTC+4', ' Asia/Muscat', ' Oman '),
(1341, 'UTC+4', ' Asia/Tbilisi', ' Georgia '),
(1342, 'UTC+4', ' Asia/Yerevan', ' Armenia '),
(1343, 'UTC+4', ' Europe/Astrakhan', ' Russia '),
(1344, 'UTC+4', ' Europe/Samara', ' Russia '),
(1345, 'UTC+4', ' Europe/Saratov', ' Russia '),
(1346, 'UTC+4', ' Europe/Ulyanovsk', ' Russia '),
(1347, 'UTC+4', ' Indian/Mahe', ' Seychelles '),
(1348, 'UTC+4', ' Indian/Mauritius', ' Mauritius '),
(1349, 'UTC+4', ' Indian/Reunion', ' Reunion '),
(1350, 'UTC+4:30', ' Asia/Kabul', ' Afghanistan '),
(1351, 'UTC+5', ' Antarctica/Mawson', ' Antarctica '),
(1352, 'UTC+5', ' Asia/Aqtau', ' Kazakhstan '),
(1353, 'UTC+5', ' Asia/Aqtobe', ' Kazakhstan '),
(1354, 'UTC+5', ' Asia/Ashgabat', ' Turkmenistan '),
(1355, 'UTC+5', ' Asia/Atyrau', ' Kazakhstan '),
(1356, 'UTC+5', ' Asia/Dushanbe', ' Tajikistan '),
(1357, 'UTC+5', ' Asia/Karachi', ' Pakistan '),
(1358, 'UTC+5', ' Asia/Oral', ' Kazakhstan '),
(1359, 'UTC+5', ' Asia/Qyzylorda', ' Kazakhstan '),
(1360, 'UTC+5', ' Asia/Samarkand', ' Uzbekistan '),
(1361, 'UTC+5', ' Asia/Tashkent', ' Uzbekistan '),
(1362, 'UTC+5', ' Asia/Yekaterinburg', ' Russia '),
(1363, 'UTC+5', ' Indian/Kerguelen', ' French Southern Territories '),
(1364, 'UTC+5', ' Indian/Maldives', ' Maldives '),
(1365, 'UTC+5:30', ' Asia/Colombo', ' Sri Lanka '),
(1366, 'UTC+5:30', ' Asia/Kolkata', ' India '),
(1367, 'UTC+5:45', ' Asia/Kathmandu', ' Nepal '),
(1368, 'UTC+6', ' Antarctica/Vostok', ' Antarctica '),
(1369, 'UTC+6', ' Asia/Almaty', ' Kazakhstan '),
(1370, 'UTC+6', ' Asia/Bishkek', ' Kyrgyzstan '),
(1371, 'UTC+6', ' Asia/Dhaka', ' Bangladesh '),
(1372, 'UTC+6', ' Asia/Omsk', ' Russia '),
(1373, 'UTC+6', ' Asia/Qostanay', ' Kazakhstan '),
(1374, 'UTC+6', ' Asia/Thimphu', ' Bhutan '),
(1375, 'UTC+6', ' Asia/Urumqi', ' China '),
(1376, 'UTC+6', ' Indian/Chagos', ' British Indian Ocean Territory '),
(1377, 'UTC+6:30', ' Asia/Yangon', ' Myanmar '),
(1378, 'UTC+6:30', ' Indian/Cocos', ' Cocos Islands '),
(1379, 'UTC+7', ' Antarctica/Davis', ' Antarctica '),
(1380, 'UTC+7', ' Asia/Bangkok', ' Thailand '),
(1381, 'UTC+7', ' Asia/Barnaul', ' Russia '),
(1382, 'UTC+7', ' Asia/Hovd', ' Mongolia '),
(1383, 'UTC+7', ' Asia/Ho_Chi_Minh', ' Vietnam '),
(1384, 'UTC+7', ' Asia/Jakarta', ' Indonesia '),
(1385, 'UTC+7', ' Asia/Krasnoyarsk', ' Russia '),
(1386, 'UTC+7', ' Asia/Novokuznetsk', ' Russia '),
(1387, 'UTC+7', ' Asia/Novosibirsk', ' Russia '),
(1388, 'UTC+7', ' Asia/Phnom_Penh', ' Cambodia '),
(1389, 'UTC+7', ' Asia/Pontianak', ' Indonesia '),
(1390, 'UTC+7', ' Asia/Tomsk', ' Russia '),
(1391, 'UTC+7', ' Asia/Vientiane', ' Laos '),
(1392, 'UTC+7', ' Indian/Christmas', ' Christmas Island '),
(1393, 'UTC+8', ' Asia/Brunei', ' Brunei '),
(1394, 'UTC+8', ' Asia/Choibalsan', ' Mongolia '),
(1395, 'UTC+8', ' Asia/Hong_Kong', ' Hong Kong '),
(1396, 'UTC+8', ' Asia/Irkutsk', ' Russia '),
(1397, 'UTC+8', ' Asia/Kuala_Lumpur', ' Malaysia '),
(1398, 'UTC+8', ' Asia/Kuching', ' Malaysia '),
(1399, 'UTC+8', ' Asia/Macau', ' Macao '),
(1400, 'UTC+8', ' Asia/Makassar', ' Indonesia '),
(1401, 'UTC+8', ' Asia/Manila', ' Philippines '),
(1402, 'UTC+8', ' Asia/Shanghai', ' China '),
(1403, 'UTC+8', ' Asia/Singapore', ' Singapore '),
(1404, 'UTC+8', ' Asia/Taipei', ' Taiwan '),
(1405, 'UTC+8', ' Asia/Ulaanbaatar', ' Mongolia '),
(1406, 'UTC+8', ' Australia/Perth', ' Australia '),
(1407, 'UTC+8:45', ' Australia/Eucla', ' Australia '),
(1408, 'UTC+9', ' Asia/Chita', ' Russia '),
(1409, 'UTC+9', ' Asia/Dili', ' Timor Leste '),
(1410, 'UTC+9', ' Asia/Jayapura', ' Indonesia '),
(1411, 'UTC+9', ' Asia/Khandyga', ' Russia '),
(1412, 'UTC+9', ' Asia/Pyongyang', ' North Korea '),
(1413, 'UTC+9', ' Asia/Seoul', ' South Korea '),
(1414, 'UTC+9', ' Asia/Tokyo', ' Japan '),
(1415, 'UTC+9', ' Asia/Yakutsk', ' Russia '),
(1416, 'UTC+9', ' Pacific/Palau', ' Palau '),
(1417, 'UTC+9:30', ' Australia/Adelaide', ' Australia '),
(1418, 'UTC+9:30', ' Australia/Broken_Hill', ' Australia '),
(1419, 'UTC+9:30', ' Australia/Darwin', ' Australia '),
(1420, 'UTC+10', ' Antarctica/DumontDUrville', ' Antarctica '),
(1421, 'UTC+10', ' Antarctica/Macquarie', ' Australia '),
(1422, 'UTC+10', ' Asia/Ust-Nera', ' Russia '),
(1423, 'UTC+10', ' Asia/Vladivostok', ' Russia '),
(1424, 'UTC+10', ' Australia/Brisbane', ' Australia '),
(1425, 'UTC+10', ' Australia/Hobart', ' Australia '),
(1426, 'UTC+10', ' Australia/Lindeman', ' Australia '),
(1427, 'UTC+10', ' Australia/Melbourne', ' Australia '),
(1428, 'UTC+10', ' Australia/Sydney', ' Australia '),
(1429, 'UTC+10', ' Pacific/Chuuk', ' Micronesia '),
(1430, 'UTC+10', ' Pacific/Guam', ' Guam '),
(1431, 'UTC+10', ' Pacific/Port_Moresby', ' Papua New Guinea '),
(1432, 'UTC+10', ' Pacific/Saipan', ' Northern Mariana Islands '),
(1433, 'UTC+10:30', ' Australia/Lord_Howe', ' Australia '),
(1434, 'UTC+11', ' Antarctica/Casey', ' Antarctica '),
(1435, 'UTC+11', ' Asia/Magadan', ' Russia '),
(1436, 'UTC+11', ' Asia/Sakhalin', ' Russia '),
(1437, 'UTC+11', ' Asia/Srednekolymsk', ' Russia '),
(1438, 'UTC+11', ' Pacific/Bougainville', ' Papua New Guinea '),
(1439, 'UTC+11', ' Pacific/Efate', ' Vanuatu '),
(1440, 'UTC+11', ' Pacific/Guadalcanal', ' Solomon Islands '),
(1441, 'UTC+11', ' Pacific/Kosrae', ' Micronesia '),
(1442, 'UTC+11', ' Pacific/Norfolk', ' Norfolk Island '),
(1443, 'UTC+11', ' Pacific/Noumea', ' New Caledonia '),
(1444, 'UTC+11', ' Pacific/Pohnpei', ' Micronesia '),
(1445, 'UTC+12', ' Antarctica/McMurdo', ' Antarctica '),
(1446, 'UTC+12', ' Asia/Anadyr', ' Russia '),
(1447, 'UTC+12', ' Asia/Kamchatka', ' Russia '),
(1448, 'UTC+12', ' Pacific/Auckland', ' New Zealand '),
(1449, 'UTC+12', ' Pacific/Fiji', ' Fiji '),
(1450, 'UTC+12', ' Pacific/Funafuti', ' Tuvalu '),
(1451, 'UTC+12', ' Pacific/Kwajalein', ' Marshall Islands '),
(1452, 'UTC+12', ' Pacific/Majuro', ' Marshall Islands '),
(1453, 'UTC+12', ' Pacific/Nauru', ' Nauru '),
(1454, 'UTC+12', ' Pacific/Tarawa', ' Kiribati '),
(1455, 'UTC+12', ' Pacific/Wake', ' United States Minor Outlying Islands '),
(1456, 'UTC+12', ' Pacific/Wallis', ' Wallis and Futuna '),
(1457, 'UTC+12:45', ' Pacific/Chatham', ' New Zealand '),
(1458, 'UTC+13', ' Pacific/Apia', ' Samoa '),
(1459, 'UTC+13', ' Pacific/Fakaofo', ' Tokelau '),
(1460, 'UTC+13', ' Pacific/Kanton', ' Kiribati '),
(1461, 'UTC+13', ' Pacific/Tongatapu', ' Tonga ');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currname` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `moderate`
--
ALTER TABLE `moderate`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `start_url`
--
ALTER TABLE `start_url`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `moderate`
--
ALTER TABLE `moderate`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `page`
--
ALTER TABLE `page`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `start_url`
--
ALTER TABLE `start_url`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1462;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
